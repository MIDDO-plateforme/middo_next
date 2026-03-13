<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Middo;
use App\Domain\Repository\MiddoRepositoryInterface;

class InMemoryMiddoRepository implements MiddoRepositoryInterface
{
    /** @var Middo[] */
    private array $items = [];

    public function save(Middo $middo): void
    {
        $this->items[$middo->id()] = $middo;
    }

    public function findById(string $id): ?Middo
    {
        return $this->items[$id] ?? null;
    }

    public function findAll(): array
    {
        return array_values($items);
    }

    public function delete(string $id): void
    {
        unset($this->items[$id]);
    }
}
