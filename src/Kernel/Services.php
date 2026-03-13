<?php

namespace App\Kernel;

class Services
{
    private MIDDOKernel $kernel;

    public function __construct(MIDDOKernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function middoService()
    {
        return $this->kernel->getModule('middo.service');
    }
}
