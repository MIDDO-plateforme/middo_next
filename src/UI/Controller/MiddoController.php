<?php

namespace App\UI\Controller;

use App\Application\UseCase\CreateMiddo;
use App\Application\DTO\CreateMiddoRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MiddoController
{
    private CreateMiddo $createMiddo;

    public function __construct(CreateMiddo $createMiddo)
    {
        $this->createMiddo = $createMiddo;
    }

    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $response = $this->createMiddo->execute(
            new CreateMiddoRequest(
                $data['id'] ?? '',
                $data['name'] ?? ''
            )
        );

        return new JsonResponse([
            'id' => $response->id,
            'name' => $response->name
        ]);
    }
}
