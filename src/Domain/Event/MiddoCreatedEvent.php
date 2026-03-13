<?php

namespace App\Domain\Event;

use App\Domain\Entity\Middo;

class MiddoCreatedEvent
{
    private Middo $middo;
    private \DateTimeImmutable $occurredAt;

    public function __construct(Middo $middo)
    {
        $this->middo = $middo;
        $this->occurredAt = new \DateTimeImmutable();
    }

    public function middo(): Middo
    {
        return $this->middo;
    }

    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }
}
