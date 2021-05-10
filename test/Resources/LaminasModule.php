<?php

declare(strict_types=1);

namespace LaminasTest\ConfigAggregatorModuleManager\Resources;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;

class LaminasModule implements ServiceProviderInterface, ConfigProviderInterface
{
    use ServiceManagerConfigurationTrait;

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return [
            '__class__' => __CLASS__,
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
