<?php

namespace App\Modules\Security\SecurityTimeline;

class SecurityTimelineEngine
{
    private array $events = [];

    public function addEvent(string $type, string $message, array $context = []): void
    {
        $this->events[] = [
            'type' => $type,
            'message' => $message,
            'context' => $context,
            'timestamp' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ];
    }

    public function getTimeline(): array
    {
        usort($this->events, function ($a, $b) {
            return strcmp($a['timestamp'], $b['timestamp']);
        });

        return $this->events;
    }

    public function clear(): void
    {
        $this->events = [];
    }
}
