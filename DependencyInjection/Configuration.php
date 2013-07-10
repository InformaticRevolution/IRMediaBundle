<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This class contains the configuration information for the bundle.
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ir_media');

        $supportedDrivers = array('orm');

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('media_class')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;        
        
        $this->addFilesystemSection($rootNode);
        $this->addContextsSection($rootNode);
        $this->addServiceSection($rootNode);
        
        return $treeBuilder;
    } 

    private function addFilesystemSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('filesystem')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('local')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('directory')->defaultValue('%kernel.root_dir%/../web/uploads/media')->end()
                                ->booleanNode('create')->defaultValue(false)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }   
    
    private function addContextsSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('contexts')
                    ->useAttributeAsKey('id')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('resizer')->defaultValue('simple')->end()
                            ->arrayNode('formats')
                                ->isRequired()
                                ->useAttributeAsKey('id')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('resizer')->end()
                                        ->scalarNode('width')->defaultNull()->end()
                                        ->scalarNode('height')->defaultNull()->end()
                                        ->scalarNode('quality')->defaultValue(80)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    } 
    
    private function addServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('path_generator')->defaultValue('ir_media.util.path_generator.default')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;        
    }    
}
