<?php

declare(strict_types=1);

namespace LaminasTest\ConfigAggregatorModuleManager\Resources;

use ArrayObject;
use stdClass;

class LaminasModuleWithTraversableConfig
{
    use ServiceManagerConfigurationTrait;

    public function getConfig()
    {
        return new ArrayObject([
            'service_manager' => $this->createServiceManagerConfiguration(),
        ]);
    }
}
