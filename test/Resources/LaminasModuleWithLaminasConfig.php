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

    public function getConfig() /* : Config */
    {
        return new Config([
            'service_manager' => $this->createServiceManagerConfiguration(),
        ]);
    }
}
