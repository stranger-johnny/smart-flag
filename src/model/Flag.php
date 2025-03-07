<?php

namespace Model;

use OpenFeature\interfaces\flags\EvaluationContext;

class Flag
{
    /**
     * @param string $key
     * @param array<Strategy> $strategies
     */
    public function __construct(
        public string $key,
        public array $strategies,
    ) {
    }

    public function getKey(): string
    {
        return $this->key;
    }

    // aaaaaaaaa
    public function evaluate(?EvaluationContext $context = null): bool
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->getEnvironment() === $context?->getTargetingKey()) {
                return $strategy->evaluate($context?->getAttributes());
            }
        }

        return false;
    }
}
