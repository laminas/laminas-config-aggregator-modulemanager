# laminas-config-aggregator-modulemanager

[![Build Status](https://travis-ci.org/laminas/laminas-config-aggregator-modulemanager.svg?branch=master)](https://travis-ci.org/laminas/laminas-config-aggregator-modulemanager)
[![Coverage Status](https://coveralls.io/repos/github/laminas/laminas-config-aggregator-modulemanager/badge.svg?branch=master)](https://coveralls.io/github/laminas/laminas-config-aggregator-modulemanager?branch=master)

Provides an extension to the `laminas/laminas-config-aggregator` so `laminas/laminas-mvc` 
modules can be parsed into the new config structure, e.g. for `mezzio/mezzio` 
or other projects.
 
## Usage

```php
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregatorModuleManager\LaminasModuleProvider;
use My\Laminas\MvcModule\Module as MyLaminasMvcModule;

namespace My\Laminas\MvcModule
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

namespace My\Laminas\MvcModule\Service {
    class MyService 
    {
    }
}

$aggregator = new ConfigAggregator([
    new LaminasModuleProvider(new MyLaminasMvcModule()),
]);

var_dump($aggregator->getMergedConfig());
```

Using this provider, the Module class is being parsed for `laminas/laminas-modulemanager` interfaces or methods. 
Just the same way as `laminas/laminas-mvc` does. Therefore, the output of the example would be:

```php
array(1) {
  'dependencies' => 
  array(1) {
    'invokables' =>
    array(1) {
       'My\Laminas\MvcModule\Service\MyService' =>
       string(35) "My\Laminas\MvcModule\Service\MyService"
    }
  }
}
```

For more details, please refer to the [documentation](https://docs.laminas.dev/laminas-config-aggregator-modulemanager/).

-----

- File issues at https://github.com/laminas/laminas-config-aggregator-modulemanager/issues
- Documentation is at https://docs.laminas.dev/laminas-config-aggregator-modulemanager/
