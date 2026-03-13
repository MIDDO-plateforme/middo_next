<?php

namespace App\Modules\Security\ThreatCorrelation;

class ThreatCorrelationEngine
{
    private array $events = [];

    public function addEvent(array $event): void
    {
        $this->events[] = $event;
    }

    public function addEvents(array $events): void
    {
        foreach ($events as $event) {
            $this->addEvent($event);
        }
    }

    public function correlate(): array
    {
        $byType = [];
        foreach ($this->events as $event) {
            $type = $event['type'] ?? 'unknown';
            $byType[$type][] = $event;
        }

        $correlations = [];
        foreach ($byType as $type => $items) {
            $correlations[] = [
                'type' => $type,
                'count' => count($items),
                'first_timestamp' => $items[0]['timestamp'] ?? null,
                'last_timestamp' => $items[count($items) - 1]['timestamp'] ?? null,
            ];
        }

        return $correlations;
    }

    public function clear(): void
    {
        $this->events = [];
    }
}
