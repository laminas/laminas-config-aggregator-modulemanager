# zend-config-aggregator-modulemanager

[![Build Status](https://secure.travis-ci.org/zendframework/zend-config-aggregator-modulemanager.svg?branch=master)](https://secure.travis-ci.org/zendframework/zend-config-aggregator-modulemanager)
[![Coverage Status](https://coveralls.io/repos/github/zendframework/zend-config-aggregator-modulemanager/badge.svg?branch=master)](https://coveralls.io/github/zendframework/zend-config-aggregator-modulemanager?branch=master)

Provides an extension to the `zendframework/zend-config-aggregator` so `zendframework/zend-mvc` 
modules can be parsed into the new config structure, e.g. for `zendframework/zend-expressive` 
or other projects.
 
## Usage

```php
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\ModuleManager\ZendModuleProvider;
use My\Zend\MvcModule\Module as MyZendMvcModule;

namespace My\Zend\MvcModule
{
    class Module 
    {
        public function getConfig()
        {
            return [
                'service_manager' => [
                    'invokables' => [
                        Service\MyService::class => Service\MyService::class, 
                    ],
                ],
            ];
        }
    }
}

namespace My\Zend\MvcModule\Service {
    class MyService 
    {
    }
}

$aggregator = new ConfigAggregator([
    new ZendModuleProvider(new MyZendMvcModule()),
]);

var_dump($aggregator->getMergedConfig());
```

Using this provider, the Module class is being parsed for `zendframework/zend-modulemanager` interfaces or methods. 
Just the same way as `zendframework/zend-mvc` does. Therefore, the output of the example would be:

```php
array(1) {
  'dependencies' => 
  array(1) {
    'invokables' =>
    array(1) {
       'My\Zend\MvcModule\Service\MyService' =>
       string(35) "My\Zend\MvcModule\Service\MyService"
    }
  }
}
```

For more details, please refer to the [documentation](https://docs.zendframework.com/zend-config-aggregator-modulemanager/).

-----

- File issues at https://github.com/zendframework/zend-config-aggregator-modulemanager/issues
- Documentation is at https://docs.zendframework.com/zend-config-aggregator-modulemanager/
