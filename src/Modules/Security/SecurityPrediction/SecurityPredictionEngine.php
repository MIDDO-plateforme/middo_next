<?php

namespace App\Modules\Security\SecurityPrediction;

class SecurityPredictionEngine
{
    public function predict(array $metrics): array
    {
        $score = 0;

        foreach ($metrics as $key => $value) {
            if (is_numeric($value)) {
                $score += $value;
            }
        }

        $level = $this->computeLevel($score);

        return [
            'score' => $score,
            'level' => $level,
            'timestamp' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ];
    }

    private function computeLevel(int $score): string
    {
        if ($score >= 80) {
            return 'critical';
        }

        if ($score >= 50) {
            return 'high';
        }

        if ($score >= 20) {
            return 'medium';
        }

        return 'low';
    }
}
