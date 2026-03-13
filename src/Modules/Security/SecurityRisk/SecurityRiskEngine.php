<?php

namespace App\Modules\Security\SecurityRisk;

class SecurityRiskEngine
{
    public function compute(array $factors): array
    {
        $weights = [
            'threat_score' => 0.5,
            'correlation_score' => 0.3,
            'prediction_score' => 0.2,
        ];

        $risk = 0;

        foreach ($weights as $key => $weight) {
            if (isset($factors[$key]) && is_numeric($factors[$key])) {
                $risk += $factors[$key] * $weight;
            }
        }

        $level = $this->computeLevel($risk);

        return [
            'risk' => round($risk, 2),
            'level' => $level,
            'timestamp' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ];
    }

    private function computeLevel(float $risk): string
    {
        if ($risk >= 80) {
            return 'critical';
        }

        if ($risk >= 50) {
            return 'high';
        }

        if ($risk >= 20) {
            return 'medium';
        }

        return 'low';
    }
}
