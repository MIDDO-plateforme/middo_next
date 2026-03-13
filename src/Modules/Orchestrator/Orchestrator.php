<?php

namespace App\Modules\Orchestrator;

use App\Modules\Validator\Validator;
use App\Modules\Watcher\Watcher;
use App\Modules\Compiler\Compiler;
use App\Kernel\Services;

class Orchestrator
{
    private Validator $validator;
    private Watcher $watcher;
    private Compiler $compiler;
    private Services $services;

    public function __construct(
        Validator $validator,
        Watcher $watcher,
        Compiler $compiler,
        Services $services
    ) {
        $this->validator = $validator;
        $this->watcher = $watcher;
        $this->compiler = $compiler;
        $this->services = $services;
    }

    public function createMiddo(array $payload): array
    {
        // 1. Validation
        if (!$this->validator->validateArray($payload, ['id', 'name'])) {
            $this->watcher->record('middo.create.failed', ['reason' => 'invalid_payload']);
            return ['error' => 'Invalid payload'];
        }

        // 2. Normalisation
        $normalized = $this->compiler->normalizeKeys($payload);

        // 3. Domain action
        $middo = $this->services->middoService()->create(
            $normalized['id'],
            $normalized['name']
        );

        // 4. Logging
        $this->watcher->record('middo.created', [
            'id' => $middo->id(),
            'name' => $middo->name()
        ]);

        // 5. Output
        return [
            'id' => $middo->id(),
            'name' => $middo->name()
        ];
    }
}
