<?php

namespace ZendTest\ConfigAggregator\ModuleManager\Resources;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ServiceManager\Factory\InvokableFactory;

/**
 * @author Maximilian Bösing <max@boesing.email>
 */
class ZendModule implements ServiceProviderInterface, ConfigProviderInterface
{

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
        return [
            'factories' => [
                'MyInvokable' => InvokableFactory::class,
            ],
        ];
    }
}
