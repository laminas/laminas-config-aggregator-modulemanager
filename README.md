# laminas-config-aggregator-modulemanager

> This package is considered feature-complete, and is now in **security-only** maintenance mode, following a [decision by the Technical Steering Committee](https://github.com/laminas/technical-steering-committee/blob/2b55453e172a1b8c9c4c212be7cf7e7a58b9352c/meetings/minutes/2020-08-03-TSC-Minutes.md#vote-on-components-to-mark-as-security-only).
> If you have a security issue, please [follow our security reporting guidelines](https://getlaminas.org/security/).
> If you wish to take on the role of maintainer, please [nominate yourself](https://github.com/laminas/technical-steering-committee/issues/new?assignees=&labels=Nomination&template=Maintainer_Nomination.md&title=%5BNOMINATION%5D%5BMAINTAINER%5D%3A+%7Bname+of+person+being+nominated%7D)


[![Build Status](https://github.com/laminas/laminas-config-aggregator-modulemanager/workflows/Continuous%20Integration/badge.svg)](https://github.com/laminas/laminas-config-aggregator-modulemanager/actions?query=workflow%3A"Continuous+Integration")

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
