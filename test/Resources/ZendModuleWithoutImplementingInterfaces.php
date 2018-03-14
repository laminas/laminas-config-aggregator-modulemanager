<?php

namespace ZendTest\ConfigAggregatorModuleManager\Resources;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * @author Maximilian Bösing <max@boesing.email>
 */
class ZendModuleWithoutImplementingInterfaces
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
