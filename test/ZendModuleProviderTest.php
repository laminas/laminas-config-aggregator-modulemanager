<?php

namespace ZendTest\ConfigAggregatorModuleManager;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Zend\ConfigAggregatorModuleManager\ZendModuleProvider;
use Zend\ServiceManager\Factory\InvokableFactory;
use ZendTest\ConfigAggregatorModuleManager\Resources\ZendModule;
use ZendTest\ConfigAggregatorModuleManager\Resources\ZendModuleWithInvalidConfiguration;
use ZendTest\ConfigAggregatorModuleManager\Resources\ZendModuleWithoutImplementingInterfaces;
use ZendTest\ConfigAggregatorModuleManager\Resources\ZendModuleWithTraversableConfig;
use ZendTest\ConfigAggregatorModuleManager\Resources\ZendModuleWithZendConfig;

/**
 * @author Maximilian Bösing <max@boesing.email>
 */
class ZendModuleProviderTest extends TestCase
{

    public function testCanProvideDependenciesFromInterface()
    {
        $module = new ZendModule();
        $provider = new ZendModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertSame([
            'factories' => [
                'MyInvokable' => InvokableFactory::class,
            ],
        ], $config['dependencies']);
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
        $this->assertSame([
            'factories' => [
                'SomeObject' => InvokableFactory::class,
            ],
        ], $config['dependencies']);
    }

    public function testCanHandleModulesWithoutConfigurationProvider()
    {
        $module = new stdClass();
        $provider = new ZendModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertEmpty($config['dependencies']);
    }

    public function testCanHandleModulesWithTraversableConfiguration()
    {
        $module = new ZendModuleWithZendConfig();
        $provider = new ZendModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertSame([
            'invokables' => [
                stdClass::class => stdClass::class,
            ],
        ], $config['dependencies']);
    }

    public function testCanHandleModuelsWithZendConfigConfiguration()
    {
        $module = new ZendModuleWithTraversableConfig();
        $provider = new ZendModuleProvider($module);

        $config = $provider();

        $this->assertArrayHasKey('dependencies', $config);
        $this->assertSame([
            'invokables' => [
                stdClass::class => stdClass::class,
            ],
        ], $config['dependencies']);
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
