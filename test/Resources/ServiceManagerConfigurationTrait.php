<?php

declare(strict_types=1);

namespace LaminasTest\ConfigAggregatorModuleManager\Resources;

trait ServiceManagerConfigurationTrait
{
    private function createServiceManagerConfiguration() : array
    {
        return [
            'factories' => [],
            'invokables' => [],
            'aliases' => [],
            'delegators' => [],
            'abstract_factories' => [],
            'shared' => [],
            'initializers' => [],
        ];
    }
}
