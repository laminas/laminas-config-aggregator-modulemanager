<?php

declare(strict_types=1);

namespace LaminasTest\ConfigAggregatorModuleManager;

use InvalidArgumentException;
use Laminas\ConfigAggregatorModuleManager\LaminasModuleProvider;
use Laminas\ModuleManager\Feature\FilterProviderInterface;
use Laminas\ModuleManager\Feature\FormElementProviderInterface;
use Laminas\ModuleManager\Feature\HydratorProviderInterface;
use Laminas\ModuleManager\Feature\InputFilterProviderInterface;
use Laminas\ModuleManager\Feature\RouteProviderInterface;
use Laminas\ModuleManager\Feature\SerializerProviderInterface;
use Laminas\ModuleManager\Feature\ValidatorProviderInterface;
use Laminas\ModuleManager\Feature\ViewHelperProviderInterface;
use LaminasTest\ConfigAggregatorModuleManager\Resources\LaminasModule;
use LaminasTest\ConfigAggregatorModuleManager\Resources\LaminasModuleWithInvalidConfiguration;
use LaminasTest\ConfigAggregatorModuleManager\Resources\LaminasModuleWithLaminasConfig;
use LaminasTest\ConfigAggregatorModuleManager\Resources\LaminasModuleWithoutImplementingInterfaces;
use LaminasTest\ConfigAggregatorModuleManager\Resources\LaminasModuleWithTraversableConfig;
use LaminasTest\ConfigAggregatorModuleManager\Resources\ServiceManagerConfigurationTrait;
use PHPUnit\Framework\TestCase;
use stdClass;

class LaminasModuleProviderTest extends TestCase
{
    use ServiceManagerConfigurationTrait;

    public function testCanProvideDependenciesFromServiceProviderInterface()
    {
        $module = new LaminasModule();
        $provider = new LaminasModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['dependencies']);
    }

    public function testCanProvideRouteManagerFromRouteProviderInterface()
    {
        $module = $this->createMock(RouteProviderInterface::class);
        $module
            ->expects($this->once())
            ->method('getRouteConfig')
            ->willReturn($this->createServiceManagerConfiguration());

        $provider = new LaminasModuleProvider($module);

        $config = $provider();
        $this->assertArrayHasKey('route_manager', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['route_manager']);
    }

    public function testCanProvideFormElementsFromFormElementProviderInterface()
    {
        $module = $this->createMock(FormElementProviderInterface::class);
        $module
            ->expects($this->once())
            ->method('getFormElementConfig')
            ->willReturn($this->createServiceManagerConfiguration());

        $provider = new LaminasModuleProvider($module);

        $config = $provider();
        $this->assertArrayHasKey('form_elements', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['form_elements']);
    }

    public function testCanProvideFiltersFromFilterProviderInterface()
    {
        $module = $this->createMock(FilterProviderInterface::class);
        $module
            ->expects($this->once())
            ->method('getFilterConfig')
            ->willReturn($this->createServiceManagerConfiguration());

        $provider = new LaminasModuleProvider($module);

        $config = $provider();
        $this->assertArrayHasKey('filters', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['filters']);
    }

    public function testCanProvideValidatorsFromValidatorProviderInterface()
    {
        $module = $this->createMock(ValidatorProviderInterface::class);
        $module
            ->expects($this->once())
            ->method('getValidatorConfig')
            ->willReturn($this->createServiceManagerConfiguration());

        $provider = new LaminasModuleProvider($module);

        $config = $provider();
        $this->assertArrayHasKey('validators', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['validators']);
    }

    public function testCanProvideHydratorsFromHydratorProviderInterface()
    {
        $module = $this->createMock(HydratorProviderInterface::class);
        $module
            ->expects($this->once())
            ->method('getHydratorConfig')
            ->willReturn($this->createServiceManagerConfiguration());

        $provider = new LaminasModuleProvider($module);

        $config = $provider();
        $this->assertArrayHasKey('hydrators', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['hydrators']);
    }

    public function testCanProvideInputFiltersFromInputFilterProviderInterface()
    {
        $module = $this->createMock(InputFilterProviderInterface::class);
        $module
            ->expects($this->once())
            ->method('getInputFilterConfig')
            ->willReturn($this->createServiceManagerConfiguration());

        $provider = new LaminasModuleProvider($module);

        $config = $provider();
        $this->assertArrayHasKey('input_filters', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['input_filters']);
    }

    public function testCanProvideSerializersFromSerializerProviderInterface()
    {
        $module = $this->createMock(SerializerProviderInterface::class);
        $module
            ->expects($this->once())
            ->method('getSerializerConfig')
            ->willReturn($this->createServiceManagerConfiguration());

        $provider = new LaminasModuleProvider($module);

        $config = $provider();
        $this->assertArrayHasKey('serializers', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['serializers']);
    }

    public function testCanProviderViewHelpersFromViewHelperProviderInterface()
    {
        $module = $this->createMock(ViewHelperProviderInterface::class);
        $module
            ->expects($this->once())
            ->method('getViewHelperConfig')
            ->willReturn($this->createServiceManagerConfiguration());

        $provider = new LaminasModuleProvider($module);

        $config = $provider();
        $this->assertArrayHasKey('view_helpers', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['view_helpers']);
    }

    public function testCanProvideAnyConfigValue()
    {
        $module = new LaminasModule();
        $provider = new LaminasModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('__class__', $config);
        $this->assertSame(LaminasModule::class, $config['__class__']);
    }

    public function testCanProvideDependenciesFromModuleWithoutInterface()
    {
        $module = new LaminasModuleWithoutImplementingInterfaces();
        $provider = new LaminasModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['dependencies']);
    }

    public function testCanHandleModulesWithoutConfigurationProvider()
    {
        $module = new stdClass();
        $provider = new LaminasModuleProvider($module);

        $config = $provider();

        $this->assertEmpty($config);
    }

    public function testCanHandleModulesWithTraversableConfiguration()
    {
        $module = new LaminasModuleWithLaminasConfig();
        $provider = new LaminasModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['dependencies']);
    }

    public function testCanHandleModulesWithLaminasConfigConfiguration()
    {
        $module = new LaminasModuleWithTraversableConfig();
        $provider = new LaminasModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['dependencies']);
    }

    public function testThrowsInvalidArgumentExceptionOnInvalidConfiguration()
    {
        $this->expectException(InvalidArgumentException::class);
        $module = new LaminasModuleWithInvalidConfiguration();
        $provider = new LaminasModuleProvider($module);

        $provider();
    }
}
