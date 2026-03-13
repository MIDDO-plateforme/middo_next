<?php

namespace App\Modules\Security\SecurityDashboard;

class SecurityDashboardEngine
{
    private array $sections = [];

    public function setSection(string $name, array $data): void
    {
        $this->sections[$name] = $data;
    }

    public function getSection(string $name): ?array
    {
        return $this->sections[$name] ?? null;
    }

    public function getAll(): array
    {
        return $this->sections;
    }

    public function clear(): void
    {
        $this->sections = [];
    }

    public function buildDashboard(): array
    {
        return [
            'timestamp' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            'sections' => $this->sections,
        ];
    }
}
