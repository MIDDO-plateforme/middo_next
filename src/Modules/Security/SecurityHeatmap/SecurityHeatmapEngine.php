<?php

namespace App\Modules\Security\SecurityHeatmap;

class SecurityHeatmapEngine
{
    private array $grid = [];

    public function addPoint(string $zone, int $intensity = 1): void
    {
        if (!isset($this->grid[$zone])) {
            $this->grid[$zone] = 0;
        }

        $this->grid[$zone] += $intensity;
    }

    public function getHeatmap(): array
    {
        arsort($this->grid);

        $result = [];
        foreach ($this->grid as $zone => $score) {
            $result[] = [
                'zone' => $zone,
                'score' => $score,
            ];
        }

        return $result;
    }

    public function clear(): void
    {
        $this->grid = [];
    }
}
