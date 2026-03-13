<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Middo;

interface MiddoRepositoryInterface
{
    public function save(Middo $middo): void;

    public function findById(string $id): ?Middo;

    /**
     * @return Middo[]
     */
    public function findAll(): array;

    public function delete(string $id): void;
}
