<?php

namespace ZendTest\ConfigAggregatorModuleManager\Resources;

use ArrayObject;
use stdClass;

/**
 * @author Maximilian Bösing <max@boesing.email>
 */
class ZendModuleWithTraversableConfig
{
    use ServiceManagerConfigurationTrait;

    public function getConfig()
    {
        return new ArrayObject([
            'service_manager' => $this->createServiceManagerConfiguration(),
        ]);
    }
}
