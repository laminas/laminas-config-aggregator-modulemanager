# Usage

This package ships with a [zend-config-aggregator provider](https://docs.zendframework.com/zend-config-aggregator/config-providers/)
that allows you to use `Module` classes as configuration providers in
applications backed by `Zend\ConfigAggregator\ConfigAggregator`.

As an example, consider the following `Module` class:

```php
namespace My\Zend\MvcModule;

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
```

When defining configuration for your application, you can use the class
`Zend\ConfigAggregatorModuleManager\ZendModuleProvider` to wrap the module and
use it as a configuration provider:

```php
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregatorModuleManager\ZendModuleProvider;
use My\Zend\MvcModule\Module as MyZendMvcModule;

$aggregator = new ConfigAggregator([
    new ZendModuleProvider(new MyZendMvcModule()),
]);

var_dump($aggregator->getMergedConfig());
```

Using this provider, the `Module` class is being parsed for
`zendframework/zend-modulemanager` interfaces or methods in exactly the same way as
performed in zend-mvc applications.

The resultant output of the above example would be:

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
