<?php

namespace App\Modules\Compiler;

class Compiler
{
    public function toJson(array $data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function fromJson(string $json): array
    {
        return json_decode($json, true) ?? [];
    }

    public function normalizeKeys(array $data): array
    {
        $normalized = [];
        foreach ($data as $key => $value) {
            $normalized[strtolower(trim($key))] = $value;
        }
        return $normalized;
    }

    public function flatten(array $data, string $prefix = ''): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            $newKey = $prefix === '' ? $key : $prefix . '.' . $key;
            if (is_array($value)) {
                $result += $this->flatten($value, $newKey);
            } else {
                $result[$newKey] = $value;
            }
        }
        return $result;
    }
}
