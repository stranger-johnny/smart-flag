<?php

namespace Model;

use OpenFeature\interfaces\flags\Attributes;

class Query
{
    public function __construct(
        public string $key,
        public string $type,
        public string | int | array $values,
    ) {
    }

    public function getKey(): string
    {
        return $this->key;
    }    

    public function evaluate(string | int | array $values): bool
    {
        return match ($this->type) {
            "equal" => $values === $this->values,
            "not-equal" => $values !== $this->values,
            "in" => in_array($values, $this->values),
            "not-in" => !in_array($values, $this->values),
            default => false,
        };
    }
}
