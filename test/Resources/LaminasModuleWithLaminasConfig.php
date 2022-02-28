<?php

/**
 * @see       https://github.com/laminas/laminas-config-aggregator-modulemanager for the canonical source repository
 */

declare(strict_types=1);

namespace LaminasTest\ConfigAggregatorModuleManager\Resources;

use Laminas\Config\Config;

class LaminasModuleWithLaminasConfig
{
    use ServiceManagerConfigurationTrait;

    /**
     * @return Config
     */
    public function getConfig()
    {
        return new Config([
            'service_manager' => $this->createServiceManagerConfiguration(),
        ]);
    }
}
