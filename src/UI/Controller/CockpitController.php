<?php

namespace App\UI\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CockpitController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('cockpit/index.html.twig', [
            'title' => 'MIDDO Cockpit',
        ]);
    }
}
