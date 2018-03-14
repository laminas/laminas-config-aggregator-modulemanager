<?php

namespace ZendTest\ConfigAggregatorModuleManager\Resources;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * @author Maximilian Bösing <max@boesing.email>
 */
class ZendModule implements ServiceProviderInterface, ConfigProviderInterface
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
