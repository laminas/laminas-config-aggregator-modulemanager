<?php

/**
 * @see       https://github.com/laminas/laminas-config-aggregator-modulemanager for the canonical source repository
 * @copyright https://github.com/laminas/laminas-config-aggregator-modulemanager/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-config-aggregator-modulemanager/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace LaminasTest\ConfigAggregatorModuleManager\Resources;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;

class LaminasModuleWithoutImplementingInterfaces
{
    use ServiceManagerConfigurationTrait;

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return [
            '__class__' => __CLASS__,
            'service_manager' => $this->createServiceManagerConfiguration(),
        ];
    }
}
