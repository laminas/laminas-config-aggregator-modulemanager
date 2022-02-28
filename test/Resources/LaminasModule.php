<?php

/**
 * @see       https://github.com/laminas/laminas-config-aggregator-modulemanager for the canonical source repository
 */

declare(strict_types=1);

namespace LaminasTest\ConfigAggregatorModuleManager\Resources;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;

class LaminasModule implements ServiceProviderInterface, ConfigProviderInterface
{
    use ServiceManagerConfigurationTrait;

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return [
            '__class__' => self::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getServiceConfig()
    {
        return $this->createServiceManagerConfiguration();
    }
}
