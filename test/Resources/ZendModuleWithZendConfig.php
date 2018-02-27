<?php

namespace ZendTest\ConfigAggregatorModuleManager\Resources;

use stdClass;
use Zend\Config\Config;

/**
 * @author Maximilian Bösing <max@boesing.email>
 */
class ZendModuleWithZendConfig
{

    public function getConfig()
    {
        return new Config([
            'service_manager' => [
                'invokables' => [
                    stdClass::class => stdClass::class,
                ],
            ],
        ]);
    }
}
