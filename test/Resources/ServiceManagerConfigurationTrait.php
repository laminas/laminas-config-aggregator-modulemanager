<?php
/**
 * @see       https://github.com/zendframework/zend-config-aggregator-modulemanager for the canonical source repository
 * @copyright Copyright (c) 2018 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-config-aggregator-modulemanager/blob/master/LICENSE.md
 *            New BSD License
 */

declare(strict_types=1);

namespace ZendTest\ConfigAggregatorModuleManager\Resources;

trait ServiceManagerConfigurationTrait
{
    private function createServiceManagerConfiguration() : array
    {
        return [
            'factories' => [],
            'invokables' => [],
            'aliases' => [],
            'delegators' => [],
            'abstract_factories' => [],
            'shared' => [],
            'initializers' => [],
        ];
    }
}
