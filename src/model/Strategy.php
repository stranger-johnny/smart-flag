<?php

namespace Model;

use OpenFeature\interfaces\flags\Attributes;
use OpenFeature\interfaces\flags\EvaluationContext;

class Strategy
{
    /**
     * @param string $environment
     * @param array<Query> $queries
     */
    public function __construct(
        public string $environment,
        public array $queries,
    ) {
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    // aaa
    public function evaluate(?Attributes $attributes): bool
    {
        if ($attributes === null) {
            return false;
        }
        foreach ($this->queries as $query) {
            foreach ($attributes->toArray() as $key => $value) {
                if ($query->getKey() === $key) {
                    return $query->evaluate($value);
                }
            }
        }
        return false;
    }
}
