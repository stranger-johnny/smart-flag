<?php

namespace Provider;

use Model\Flags;
use OpenFeature\implementation\common\Metadata;
use OpenFeature\implementation\provider\ResolutionDetailsBuilder;
use OpenFeature\interfaces\common\LoggerAwareTrait;
use OpenFeature\interfaces\flags\EvaluationContext;
use OpenFeature\interfaces\hooks\HooksAwareTrait;
use OpenFeature\interfaces\provider\Provider;
use OpenFeature\interfaces\provider\ResolutionDetails;

class SmartProvider implements Provider
{

    use HooksAwareTrait;
    use LoggerAwareTrait;

    public function __construct(private Flags $flags) 
    {
    }

    public function getMetadata(): Metadata
    {
        return new Metadata('smart-flag');
    }

     /**
     * Resolves the flag value for the provided flag key as a boolean
     */
    public function resolveBooleanValue(string $flagKey, bool $defaultValue, ?EvaluationContext $context = null): ResolutionDetails 
    {
        $flag = $this->flags->get($flagKey);
        if ($flag !== null) {
            return (new ResolutionDetailsBuilder())->withValue($flag->evaluate($context))->build();
        }

        return (new ResolutionDetailsBuilder())->withValue($defaultValue)->build();
    }

    /**
     * Resolves the flag value for the provided flag key as a string
     */
    public function resolveStringValue(string $flagKey, string $defaultValue, ?EvaluationContext $context = null): ResolutionDetails
    {
        return (new ResolutionDetailsBuilder())->withValue($defaultValue)->build();
    }

    /**
     * Resolves the flag value for the provided flag key as an integer
     */
    public function resolveIntegerValue(string $flagKey, int $defaultValue, ?EvaluationContext $context = null): ResolutionDetails
    {
        return (new ResolutionDetailsBuilder())->withValue($defaultValue)->build();
    }

    /**
     * Resolves the flag value for the provided flag key as a float
     */
    public function resolveFloatValue(string $flagKey, float $defaultValue, ?EvaluationContext $context = null): ResolutionDetails
    {
        return (new ResolutionDetailsBuilder())->withValue($defaultValue)->build();
    }

    /**
     * Resolves the flag value for the provided flag key as an object
     *
     * @param mixed[] $defaultValue
     */
    public function resolveObjectValue(string $flagKey, array $defaultValue, ?EvaluationContext $context = null): ResolutionDetails
    {
        return (new ResolutionDetailsBuilder())->withValue($defaultValue)->build();
    }
}