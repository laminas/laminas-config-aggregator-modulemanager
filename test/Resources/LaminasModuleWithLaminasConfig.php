<?php

/**
 * @see       https://github.com/laminas/laminas-config-aggregator-modulemanager for the canonical source repository
 * @copyright https://github.com/laminas/laminas-config-aggregator-modulemanager/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-config-aggregator-modulemanager/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace LaminasTest\ConfigAggregatorModuleManager\Resources;

use Laminas\Config\Config;
use stdClass;

class LaminasModuleWithLaminasConfig
{
    use ServiceManagerConfigurationTrait;

    public function getConfig()
    {
        return new Config([
            'service_manager' => $this->createServiceManagerConfiguration(),
        ]);
    }
}
