<?php

namespace App\Modules\Watcher;

class Watcher
{
    private array $events = [];

    public function record(string $eventName, array $payload = []): void
    {
        $this->events[] = [
            'event' => $eventName,
            'payload' => $payload,
            'timestamp' => (new \DateTimeImmutable())->format('Y-m-d H:i:s')
        ];
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function clear(): void
    {
        $this->events = [];
    }
}
