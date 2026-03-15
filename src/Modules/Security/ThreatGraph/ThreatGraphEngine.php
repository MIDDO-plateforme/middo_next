<?php

namespace App\Modules\Security\ThreatGraph;

class ThreatGraphEngine
{
    private array $nodes = [];
    private array $edges = [];

    public function addNode(string $id, array $attributes = []): void
    {
        $this->nodes[$id] = [
            'id' => $id,
            'attributes' => $attributes,
        ];
    }

    public function addEdge(string $from, string $to, array $attributes = []): void
    {
        $this->edges[] = [
            'from' => $from,
            'to' => $to,
            'attributes' => $attributes,
        ];
    }

    public function getNodes(): array
    {
        return array_values($this->nodes);
    }

    public function getEdges(): array
    {
        return $this->edges;
    }

    public function getGraph(): array
    {
        return [
            'nodes' => $this->getNodes(),
            'edges' => $this->getEdges(),
            'timestamp' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
        ];
    }

    public function clear(): void
    {
        $this->nodes = [];
        $this->edges = [];
    }
}
