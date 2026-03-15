<?php

namespace App\Modules\Security\SOC;

use App\Modules\Security\ThreatIntelligence\ThreatIntelligenceEngine;
use App\Modules\Security\ThreatCorrelation\ThreatCorrelationEngine;
use App\Modules\Security\SecurityWatcher\SecurityWatcher;
use App\Modules\Security\SecurityTimeline\SecurityTimelineEngine;
use App\Modules\Security\SecurityHeatmap\SecurityHeatmapEngine;
use App\Modules\Security\SecurityPrediction\SecurityPredictionEngine;
use App\Modules\Security\SecurityRisk\SecurityRiskEngine;
use App\Modules\Security\ThreatGraph\ThreatGraphEngine;

class SOCEngine
{
    public function __construct(
        private ThreatIntelligenceEngine $intelligence,
        private ThreatCorrelationEngine $correlation,
        private SecurityWatcher $watcher,
        private SecurityTimelineEngine $timeline,
        private SecurityHeatmapEngine $heatmap,
        private SecurityPredictionEngine $prediction,
        private SecurityRiskEngine $risk,
        private ThreatGraphEngine $graph
    ) {}

    public function ingestEvent(string $type, array $context = []): array
    {
        // 1. Analyse
        $alert = $this->intelligence->analyzeEvent($type, $context);

        // 2. Log
        $this->watcher->log('security', "Event: $type", $context);

        // 3. Timeline
        $this->timeline->addEvent($type, 'Event received', $context);

        // 4. Heatmap
        if (isset($context['zone'])) {
            $this->heatmap->addPoint($context['zone'], $alert['score']);
        }

        // 5. Graph
        if (isset($context['source']) && isset($context['target'])) {
            $this->graph->addNode($context['source']);
            $this->graph->addNode($context['target']);
            $this->graph->addEdge($context['source'], $context['target'], ['type' => $type]);
        }

        // 6. Correlation
        $this->correlation->addEvent([
            'type' => $type,
            'context' => $context,
            'timestamp' => $alert['timestamp'],
        ]);

        return $alert;
    }

    public function computeGlobalRisk(): array
    {
        $factors = [
            'threat_score' => array_sum(array_column($this->intelligence->getAlerts(), 'score')),
            'correlation_score' => count($this->correlation->correlate()) * 10,
            'prediction_score' => $this->prediction->predict([
                'alerts' => count($this->intelligence->getAlerts()),
                'events' => count($this->watcher->getLogs()),
            ])['score'] ?? 0,
        ];

        return $this->risk->compute($factors);
    }

    public function getSOCView(): array
    {
        return [
            'alerts' => $this->intelligence->getAlerts(),
            'correlation' => $this->correlation->correlate(),
            'logs' => $this->watcher->getLogs(),
            'timeline' => $this->timeline->getTimeline(),
            'heatmap' => $this->heatmap->getHeatmap(),
            'graph' => $this->graph->getGraph(),
            'global_risk' => $this->computeGlobalRisk(),
            'timestamp' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ];
    }
}
