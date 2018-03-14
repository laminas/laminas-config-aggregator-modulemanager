<?php
/**
 * @see       https://github.com/zendframework/zend-config-aggregator-modulemanager for the canonical source repository
 * @copyright Copyright (c) 2018 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   https://github.com/zendframework/zend-config-aggregator-modulemanager/blob/master/LICENSE.md
 *            New BSD License
 */
declare(strict_types=1);

namespace Zend\ConfigAggregatorModuleManager;

use InvalidArgumentException;
use Traversable;
use Zend\Config\Config;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FilterProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\ModuleManager\Feature\HydratorProviderInterface;
use Zend\ModuleManager\Feature\InputFilterProviderInterface;
use Zend\ModuleManager\Feature\RouteProviderInterface;
use Zend\ModuleManager\Feature\SerializerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ValidatorProviderInterface;

/**
 * Provide a configuration by using zend-modulemanager Module files.
 */
class ZendModuleProvider
{

    /**
     * @var object
     */
    private $module;

    /**
     * @var array
     */
    private $dependencies = [];

    /**
     * @var string
     */
    private $dependenciesIdentifier = 'dependencies';

    /**
     * @param object $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }

    public function __invoke(): array
    {
        return array_filter(array_replace_recursive($this->getModuleConfig(), [
            $this->getDependenciesIdentifier() => $this->getModuleDependencies(),
            'route_manager' => $this->getRouteConfig(),
            'form_elements' => $this->getFormElementConfig(),
            'filters' => $this->getFilterConfig(),
            'validators' => $this->getValidatorConfig(),
            'hydrators' => $this->getHydratorConfig(),
            'input_filters' => $this->getInputFilterConfig(),
            'serializers' => $this->getSerializerConfig(),
        ]));
    }

    private function getModuleConfig(): array
    {
        $module = $this->module;

        if (!$module instanceof ConfigProviderInterface
            && !is_callable([$module, 'getConfig'])
        ) {
            return [];
        }

        $converted = $this->convert($module->getConfig());

        if (isset($converted['service_manager'])) {
            $this->dependencies = $converted['service_manager'] ?: [];
            unset($converted['service_manager']);
        }

        return $converted;
    }

    /**
     * @param array|Traversable $config
     *
     * @return array
     */
    private function convert($config): array
    {
        if ($config instanceof Config) {
            $config = $config->toArray();
        }

        if ($config instanceof Traversable) {
            $config = iterator_to_array($config);
        }

        if (!is_array($config)) {
            throw new InvalidArgumentException(sprintf(
                'Config being merged must be an array, '
                . 'implement the Traversable interface, or be an '
                . 'instance of Zend\Config\Config. %s given.',
                is_object($config) ? get_class($config) : gettype($config)
            ));
        }

        return $config;
    }

    public function getDependenciesIdentifier(): string
    {
        return $this->dependenciesIdentifier;
    }

    public function setDependenciesIdentifier(string $dependenciesIdentifier): void
    {
        $this->dependenciesIdentifier = (string) $dependenciesIdentifier;
    }

    private function getModuleDependencies(): array
    {
        $module = $this->module;
        if (!$module instanceof ServiceProviderInterface) {
            return $this->dependencies;
        }

        return array_replace_recursive($this->dependencies, $this->convert($module->getServiceConfig()));
    }

    public function getRouteConfig(): array
    {
        if (!$this->module instanceof RouteProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getRouteConfig());
    }

    public function getFormElementConfig(): array
    {
        if (!$this->module instanceof FormElementProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getFormElementConfig());
    }

    public function getFilterConfig(): array
    {
        if (!$this->module instanceof FilterProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getFilterConfig());
    }

    public function getValidatorConfig(): array
    {
        if (!$this->module instanceof ValidatorProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getValidatorConfig());
    }

    public function getHydratorConfig(): array
    {
        if (!$this->module instanceof HydratorProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getHydratorConfig());
    }

    public function getInputFilterConfig()
    {
        if (!$this->module instanceof InputFilterProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getInputFilterConfig());
    }

    public function getSerializerConfig(): array
    {
        if (!$this->module instanceof SerializerProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getSerializerConfig());
    }
}
