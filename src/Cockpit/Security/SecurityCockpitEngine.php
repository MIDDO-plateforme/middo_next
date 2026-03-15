<?php

namespace App\Cockpit\Security;

use App\Modules\Security\SOC\SOCEngine;

class SecurityCockpitEngine
{
    public function __construct(
        private SOCEngine $soc
    ) {}

    public function buildView(): array
    {
        $socView = $this->soc->getSOCView();

        return [
            'timestamp' => $socView['timestamp'],
            'global_risk' => $socView['global_risk'],
            'alerts' => $socView['alerts'],
            'correlation' => $socView['correlation'],
            'timeline' => $socView['timeline'],
            'heatmap' => $socView['heatmap'],
            'graph' => $socView['graph'],
            'logs' => $socView['logs'],
        ];
    }
}
