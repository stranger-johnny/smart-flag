<?php

namespace Model;

use Symfony\Component\Yaml\Yaml;

class Flags
{
    /**
     * @param array<Flag> $values
     */
    public function __construct(public array $values = [])
    {
    }

    public function get(string $key): Flag|null
    {
        foreach ($this->values as $flag) {
            if ($flag->getKey() === $key) {
                return $flag;
            }
        }

        return null;
    }

    public static function fromYaml(string $yamlString): Flags
    {
        try {
            $data = Yaml::parse($yamlString);
        } catch (\Exception $e) {
            return new Flags();
        }

        $featureFlags = new Flags();
        foreach ($data as $key => $flagData) {
            $strategies = [];
            if (isset($flagData['strategies'])) {
                foreach ($flagData['strategies'] as $strategyData) {
                    $queries = [];
                    if (isset($strategyData['queries'])) {
                        foreach ($strategyData['queries'] as $queryData) {
                            $queries[] = new Query($queryData['key'], $queryData['type'], $queryData['values']);
                        }
                    }
                    $strategies[] = new Strategy($strategyData['environment'], $queries);
                }
            }
            $featureFlags->values[] = new Flag($key, $strategies);
        }

        return $featureFlags;
    }

    public function __toString(): string
    {
        return json_encode($this->values);
    }
}
