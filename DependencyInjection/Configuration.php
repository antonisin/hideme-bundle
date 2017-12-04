<?php

namespace Antonisin\HideMeBundle\DependencyInjection;

use Antonisin\HideMeBundle\Service\ProxyServiceInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('hideme');

        $rootNode
            ->children()
                ->scalarNode('api_url')
                    ->isRequired()
                    ->end()

                ->scalarNode('api_key')
                    ->isRequired()
                    ->end()

                ->arrayNode('filters')
                    ->children()
                        ->enumNode('out')
                            ->values([
                                ProxyServiceInterface::FORMAT_PHP,
                                ProxyServiceInterface::FORMAT_PLAIN,
                                ProxyServiceInterface::FORMAT_XML,
                                ProxyServiceInterface::FORMAT_JSON,
                                ProxyServiceInterface::FORMAT_CSV,
                            ])
                            ->defaultValue(ProxyServiceInterface::FORMAT_JSON)
                        ->end()

                        ->arrayNode("country")
                            ->scalarPrototype()
                            ->end()
                        ->end()

                        ->integerNode('maxtime')
                            ->min(50)
                            ->max(10000)
                        ->end()

                        ->arrayNode('ports')
                            ->integerPrototype()
                                ->min(1)
                                ->max(65555)
                            ->end()
                        ->end()

                        ->arrayNode('type')
                            ->enumPrototype()
                                ->values([
                                    ProxyServiceInterface::TYPE_HTTP,
                                    ProxyServiceInterface::TYPE_HTTPS,
                                    ProxyServiceInterface::TYPE_SOCKS4,
                                    ProxyServiceInterface::TYPE_SOCKS5,
                                ])
                            ->end()
                        ->end()

                        ->arrayNode('anon')
                            ->integerPrototype()
                                ->min(1)
                                ->max(4)
                            ->end()
                        ->end()

                        ->integerNode('uptime')
                            ->min(1)
                            ->max(100)
                        ->end()
        ;

        return $treeBuilder;
    }
}
