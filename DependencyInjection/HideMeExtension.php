<?php

namespace Antonisin\HideMeBundle\DependencyInjection;

use Antonisin\HideMeBundle\Service\ProxyServiceInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class HideMeExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');


        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('hideme.api_key', $config[ProxyServiceInterface::PARAM_KEY_API_KEY]);
        $container->setParameter('hideme.api_url', $config[ProxyServiceInterface::PARAM_KEY_API_URL]);

        if (!array_key_exists('filters', $config)) {
            throw new \Exception("FILTERS MISSING IN CONFIG FILE");
        }

        $container->setParameter('hideme.filters', $config['filters']);
    }
}
