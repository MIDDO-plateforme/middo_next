<?php

namespace App\Modules\Validator;

class Validator
{
    public function validateArray(array $data, array $requiredKeys): bool
    {
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $data)) {
                return false;
            }
        }
        return true;
    }

    public function validateString(string $value): bool
    {
        return trim($value) !== '';
    }

    public function validateId(string $id): bool
    {
        return preg_match('/^[a-zA-Z0-9_-]+$/', $id) === 1;
    }
}
