<?php

namespace App\Modules\Security\ThreatIntelligence;

class ThreatIntelligenceEngine
{
    private array $rules = [];
    private array $alerts = [];

    public function __construct()
    {
        $this->rules = [
            'failed_login' => 3,
            'suspicious_ip' => 5,
            'multiple_requests' => 4,
            'data_export' => 7,
        ];
    }

    public function analyzeEvent(string $type, array $context = []): array
    {
        $score = $this->rules[$type] ?? 1;

        $alert = [
            'type' => $type,
            'score' => $score,
            'context' => $context,
            'level' => $this->computeLevel($score),
            'timestamp' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ];

        if ($alert['level'] !== 'low') {
            $this->alerts[] = $alert;
        }

        return $alert;
    }

    /**
     * @param array<int, array{type:string,context:array}>
     */
    public function analyzeBatch(array $events): array
    {
        $results = [];
        foreach ($events as $event) {
            $results[] = $this->analyzeEvent(
                $event['type'] ?? 'unknown',
                $event['context'] ?? []
            );
        }

        return $results;
    }

    public function getAlerts(): array
    {
        return $this->alerts;
    }

    public function clearAlerts(): void
    {
        $this->alerts = [];
    }

    private function computeLevel(int $score): string
    {
        if ($score >= 7) {
            return 'critical';
        }

        if ($score >= 4) {
            return 'high';
        }

        if ($score >= 2) {
            return 'medium';
        }

        return 'low';
    }
}
