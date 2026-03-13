<?php

namespace App\Kernel;

class MIDDOKernel
{
    private array $modules = [];

    public function registerModule(string $name, object $module): void
    {
        $this->modules[$name] = $module;
    }

    public function getModule(string $name): ?object
    {
        return $this->modules[$name] ?? null;
    }

    public function listModules(): array
    {
        return array_keys($this->modules);
    }
}
