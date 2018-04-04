<?php
/**
 * @see       https://github.com/zendframework/zend-config-aggregator-modulemanager for the canonical source repository
 * @copyright Copyright (c) 2018 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-config-aggregator-modulemanager/blob/master/LICENSE.md
 *            New BSD License
 */

declare(strict_types=1);

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
