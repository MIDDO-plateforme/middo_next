<?php

namespace App\Modules\Security\SecurityWatcher;

class SecurityWatcher
{
    private array $logs = [];

    public function log(string $category, string $message, array $context = []): void
    {
        $this->logs[] = [
            'category' => $category,
            'message' => $message,
            'context' => $context,
            'timestamp' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ];
    }

    public function getLogs(?string $category = null): array
    {
        if ($category === null) {
            return $this->logs;
        }

        return array_values(array_filter($logs = $this->logs, function ($log) use ($category) {
            return $log['category'] === $category;
        }));
    }

    public function clear(): void
    {
        $this->logs = [];
    }
}
