<?php

namespace App\Domain\Service;

use App\Domain\Entity\Middo;
use App\Domain\Exception\InvalidMiddoException;
use App\Domain\Repository\MiddoRepositoryInterface;

class MiddoDomainService
{
    private MiddoRepositoryInterface $repository;

    public function __construct(MiddoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $id, string $name): Middo
    {
        if (empty($id)) {
            throw InvalidMiddoException::emptyId();
        }

        if (empty($name)) {
            throw InvalidMiddoException::emptyName();
        }

        $middo = new Middo($id, $name);
        $this->repository->save($middo);

        return $middo;
    }

    public function delete(string $id): void
    {
        if (empty($id)) {
            throw InvalidMiddoException::emptyId();
        }

        $this->repository->delete($id);
    }
}
