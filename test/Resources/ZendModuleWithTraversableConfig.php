<?php

namespace ZendTest\ConfigAggregator\ModuleManager\Resources;

use ArrayObject;
use stdClass;

/**
 * @author Maximilian Bösing <max@boesing.email>
 */
class ZendModuleWithTraversableConfig
{

    public function getConfig()
    {
        return new ArrayObject([
            'service_manager' => [
                'invokables' => [
                    stdClass::class => stdClass::class,
                ],
            ],
        ]);
    }
}
