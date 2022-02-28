<?php

/**
 * @see       https://github.com/laminas/laminas-config-aggregator-modulemanager for the canonical source repository
 */

declare(strict_types=1);

namespace Laminas\ConfigAggregatorModuleManager;

use InvalidArgumentException;
use Laminas\Config\Config;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\FilterProviderInterface;
use Laminas\ModuleManager\Feature\FormElementProviderInterface;
use Laminas\ModuleManager\Feature\HydratorProviderInterface;
use Laminas\ModuleManager\Feature\InputFilterProviderInterface;
use Laminas\ModuleManager\Feature\RouteProviderInterface;
use Laminas\ModuleManager\Feature\SerializerProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ModuleManager\Feature\ValidatorProviderInterface;
use Laminas\ModuleManager\Feature\ViewHelperProviderInterface;
use Traversable;

use function array_filter;
use function array_replace_recursive;
use function get_class;
use function gettype;
use function is_array;
use function is_callable;
use function is_object;
use function iterator_to_array;
use function sprintf;

/**
 * Provide configuration by consuming laminas-modulemanager Module classes.
 */
class LaminasModuleProvider
{
    /** @var object */
    private $module;

    /** @var array */
    private $dependencies = [];

    /** @var string */
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
            'route_manager'                    => $this->getRouteConfig(),
            'form_elements'                    => $this->getFormElementConfig(),
            'filters'                          => $this->getFilterConfig(),
            'validators'                       => $this->getValidatorConfig(),
            'hydrators'                        => $this->getHydratorConfig(),
            'input_filters'                    => $this->getInputFilterConfig(),
            'serializers'                      => $this->getSerializerConfig(),
            'view_helpers'                     => $this->getViewHelperConfig(),
        ]));
    }

    private function getModuleConfig(): array
    {
        $module = $this->module;

        if (
            ! $module instanceof ConfigProviderInterface
            && ! is_callable([$module, 'getConfig'])
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
     * @return array
     */
    private function convert($config): array
    {
        if ($config instanceof Config) {
            return $config->toArray();
        }

        if ($config instanceof Traversable) {
            return iterator_to_array($config);
        }

        if (! is_array($config)) {
            throw new InvalidArgumentException(sprintf(
                'Config being merged must be an array, implement the Traversable interface,'
                . ' or be an instance of %s. %s given.',
                Config::class,
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
        $this->dependenciesIdentifier = $dependenciesIdentifier;
    }

    private function getModuleDependencies(): array
    {
        $module = $this->module;
        if (! $module instanceof ServiceProviderInterface) {
            return $this->dependencies;
        }

        return array_replace_recursive($this->dependencies, $this->convert($module->getServiceConfig()));
    }

    public function getRouteConfig(): array
    {
        if (! $this->module instanceof RouteProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getRouteConfig());
    }

    public function getFormElementConfig(): array
    {
        if (! $this->module instanceof FormElementProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getFormElementConfig());
    }

    public function getFilterConfig(): array
    {
        if (! $this->module instanceof FilterProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getFilterConfig());
    }

    public function getValidatorConfig(): array
    {
        if (! $this->module instanceof ValidatorProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getValidatorConfig());
    }

    public function getHydratorConfig(): array
    {
        if (! $this->module instanceof HydratorProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getHydratorConfig());
    }

    public function getInputFilterConfig() /* : array */
    {
        if (! $this->module instanceof InputFilterProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getInputFilterConfig());
    }

    public function getSerializerConfig(): array
    {
        if (! $this->module instanceof SerializerProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getSerializerConfig());
    }

    public function getViewHelperConfig(): array
    {
        if (! $this->module instanceof ViewHelperProviderInterface) {
            return [];
        }

        return $this->convert($this->module->getViewHelperConfig());
    }
}
