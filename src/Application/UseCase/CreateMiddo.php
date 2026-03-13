<?php

namespace App\Application\UseCase;

use App\Application\DTO\CreateMiddoRequest;
use App\Application\DTO\CreateMiddoResponse;
use App\Domain\Service\MiddoDomainService;

class CreateMiddo
{
    private MiddoDomainService $service;

    public function __construct(MiddoDomainService $service)
    {
        $this->service = $service;
    }

    public function execute(CreateMiddoRequest $request): CreateMiddoResponse
    {
        $middo = $this->service->create(
            $request->id,
            $request->name
        );

        return new CreateMiddoResponse(
            $middo->id(),
            $middo->name()
        );
    }
}
