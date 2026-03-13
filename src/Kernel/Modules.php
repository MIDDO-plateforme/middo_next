<?php

namespace App\Kernel;

use App\Infrastructure\Repository\InMemoryMiddoRepository;
use App\Domain\Service\MiddoDomainService;

class Modules
{
    public static function load(MIDDOKernel $kernel): void
    {
        // Repository
        $middoRepository = new InMemoryMiddoRepository();

        // Domain Services
        $middoService = new MiddoDomainService($middoRepository);

        // Register modules
        $kernel->registerModule('middo.repository', $middoRepository);
        $kernel->registerModule('middo.service', $middoService);
    }
}
