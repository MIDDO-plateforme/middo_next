<?php

namespace App\Controller\Cockpit;

use App\Cockpit\Security\SecurityCockpitEngine;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SecurityCockpitController extends AbstractController
{
    #[Route('/cockpit/security', name: 'cockpit_security', methods: ['GET'])]
    public function index(SecurityCockpitEngine $engine): JsonResponse
    {
        return $this->json($engine->buildView());
    }
}
