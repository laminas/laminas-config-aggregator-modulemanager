<?php
/**
 * @see       https://github.com/zendframework/zend-config-aggregator-modulemanager for the canonical source repository
 * @copyright Copyright (c) 2018 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-config-aggregator-modulemanager/blob/master/LICENSE.md
 *            New BSD License
 */

declare(strict_types=1);

namespace ZendTest\ConfigAggregatorModuleManager\Resources;

use stdClass;
use Zend\Config\Config;

/**
 * @author Maximilian Bösing <max@boesing.email>
 */
class ZendModuleWithZendConfig
{
    use ServiceManagerConfigurationTrait;

    public function getConfig()
    {
        return new Config([
            'service_manager' => $this->createServiceManagerConfiguration(),
        ]);
    }
}
