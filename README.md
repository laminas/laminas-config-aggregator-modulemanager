# laminas-config-aggregator-modulemanager

> [!CAUTION]
> This package is **abandoned** and will receive no further development.
>
> See the Technical Steering Committee [meeting minutes](https://github.com/laminas/technical-steering-committee/blob/main/meetings/minutes/2024-11-04-TSC-Minutes.md#archive--abandon-various-legacy-libraries).

> ## 🇷🇺 Русским гражданам
> 
> Мы, участники Laminas, родились и живем в разных странах. У многих из нас есть друзья, родственники и коллеги как в России, так и в Украине. Некоторые из нас родились в России. Некоторые из нас живут в России. У некоторых бабушки и дедушки сражались с фашистами во Второй мировой войне. Здесь никто не поддерживает фашизм.
> 
> У одного из нас есть украинская родственница, которая спаслась из дома вместе с сыном. Поезд задержался из-за бомбежки на дороге впереди. У нас есть друзья, которые прячутся в бомбоубежищах. Мы с тревогой ждем весточки от них после воздушных налетов, которые беспорядочно наносят удары и попадают по больницам, школам, детским садам и домам. Мы не берем это из каких-либо СМИ. Мы наблюдаем это напрямую.
> 
> Вы доверяете нам достаточно, чтоб использовать наши программы, и мы просим вас довериться нам вновь. Мы нуждаемся в помощи. Выходите и протестуйте против этой бесполезной войны. Остановите кровопролитие. Скажите "Нет войне!"
> 
> ## 🇺🇸 To Citizens of Russia
> 
> We at Laminas come from all over the world. Many of us have friends, family and colleagues in both Russia and Ukraine. Some of us were born in Russia. Some of us currently live in Russia. Some have grandparents who fought Nazis in World War II. Nobody here supports fascism.
> 
> One team member has a Ukrainian relative who fled her home with her son. The train was delayed due to bombing on the road ahead. We have friends who are hiding in bomb shelters. We anxiously follow up on them after the air raids, which indiscriminately fire at hospitals, schools, kindergartens and houses. We're not taking this from any media. These are our actual experiences.
> 
> You trust us enough to use our software. We ask that you trust us to say the truth on this. We need your help. Go out and protest this unnecessary war. Stop the bloodshed. Say "stop the war!"

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
