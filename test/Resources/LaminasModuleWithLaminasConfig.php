<?php

declare(strict_types=1);

namespace LaminasTest\ConfigAggregatorModuleManager\Resources;

use Laminas\Config\Config;
use stdClass;

class LaminasModuleWithLaminasConfig
{
    use ServiceManagerConfigurationTrait;

    public function getConfig()
    {
        return new Config([
            'service_manager' => $this->createServiceManagerConfiguration(),
        ]);
    }
}
