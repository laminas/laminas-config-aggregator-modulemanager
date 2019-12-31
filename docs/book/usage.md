# Usage

This package ships with a [laminas-config-aggregator provider](https://docs.laminas.dev/laminas-config-aggregator/config-providers/)
that allows you to use `Module` classes as configuration providers in
applications backed by `Laminas\ConfigAggregator\ConfigAggregator`.

As an example, consider the following `Module` class:

```php
namespace My\Laminas\MvcModule;

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
`Laminas\ConfigAggregatorModuleManager\LaminasModuleProvider` to wrap the module and
use it as a configuration provider:

```php
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregatorModuleManager\LaminasModuleProvider;
use My\Laminas\MvcModule\Module as MyLaminasMvcModule;

$aggregator = new ConfigAggregator([
    new LaminasModuleProvider(new MyLaminasMvcModule()),
]);

var_dump($aggregator->getMergedConfig());
```

Using this provider, the `Module` class is being parsed for
`laminas/laminas-modulemanager` interfaces or methods in exactly the same way as
performed in laminas-mvc applications.

The resultant output of the above example would be:

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
