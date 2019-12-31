<?php

/**
 * @see       https://github.com/laminas/laminas-config-aggregator-modulemanager for the canonical source repository
 * @copyright https://github.com/laminas/laminas-config-aggregator-modulemanager/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-config-aggregator-modulemanager/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace LaminasTest\ConfigAggregatorModuleManager\Resources;

use ArrayObject;
use stdClass;

class LaminasModuleWithTraversableConfig
{
    use ServiceManagerConfigurationTrait;

    public function getConfig()
    {
        return new ArrayObject([
            'service_manager' => $this->createServiceManagerConfiguration(),
        ]);
    }
}
