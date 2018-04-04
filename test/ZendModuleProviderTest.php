<?php
/**
 * @see       https://github.com/zendframework/zend-config-aggregator-modulemanager for the canonical source repository
 * @copyright Copyright (c) 2018 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-config-aggregator-modulemanager/blob/master/LICENSE.md
 *            New BSD License
 */

declare(strict_types=1);

namespace ZendTest\ConfigAggregatorModuleManager;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Zend\ConfigAggregatorModuleManager\ZendModuleProvider;
use Zend\ModuleManager\Feature\FilterProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\HydratorProviderInterface;
use Zend\ModuleManager\Feature\InputFilterProviderInterface;
use Zend\ModuleManager\Feature\RouteProviderInterface;
use Zend\ModuleManager\Feature\SerializerProviderInterface;
use Zend\ModuleManager\Feature\ValidatorProviderInterface;
use ZendTest\ConfigAggregatorModuleManager\Resources\ServiceManagerConfigurationTrait;
use ZendTest\ConfigAggregatorModuleManager\Resources\ZendModule;
use ZendTest\ConfigAggregatorModuleManager\Resources\ZendModuleWithInvalidConfiguration;
use ZendTest\ConfigAggregatorModuleManager\Resources\ZendModuleWithoutImplementingInterfaces;
use ZendTest\ConfigAggregatorModuleManager\Resources\ZendModuleWithTraversableConfig;
use ZendTest\ConfigAggregatorModuleManager\Resources\ZendModuleWithZendConfig;

class ZendModuleProviderTest extends TestCase
{
    use ServiceManagerConfigurationTrait;

    public function testCanProvideDependenciesFromServiceProviderInterface()
    {
        $module = new ZendModule();
        $provider = new ZendModuleProvider($module);

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

        $provider = new ZendModuleProvider($module);

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

        $provider = new ZendModuleProvider($module);

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

        $provider = new ZendModuleProvider($module);

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

        $provider = new ZendModuleProvider($module);

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

        $provider = new ZendModuleProvider($module);

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

        $provider = new ZendModuleProvider($module);

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

        $provider = new ZendModuleProvider($module);

        $config = $provider();
        $this->assertArrayHasKey('serializers', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['serializers']);
    }

    public function testCanProvideAnyConfigValue()
    {
        $module = new ZendModule();
        $provider = new ZendModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('__class__', $config);
        $this->assertSame(ZendModule::class, $config['__class__']);
    }

    public function testCanProvideDependenciesFromModuleWithoutInterface()
    {
        $module = new ZendModuleWithoutImplementingInterfaces();
        $provider = new ZendModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['dependencies']);
    }

    public function testCanHandleModulesWithoutConfigurationProvider()
    {
        $module = new stdClass();
        $provider = new ZendModuleProvider($module);

        $config = $provider();

        $this->assertEmpty($config);
    }

    public function testCanHandleModulesWithTraversableConfiguration()
    {
        $module = new ZendModuleWithZendConfig();
        $provider = new ZendModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['dependencies']);
    }

    public function testCanHandleModuelsWithZendConfigConfiguration()
    {
        $module = new ZendModuleWithTraversableConfig();
        $provider = new ZendModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertSame($this->createServiceManagerConfiguration(), $config['dependencies']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowsInvalidArgumentExceptionOnInvalidConfiguration()
    {
        $module = new ZendModuleWithInvalidConfiguration();
        $provider = new ZendModuleProvider($module);

        $provider();
    }
}
