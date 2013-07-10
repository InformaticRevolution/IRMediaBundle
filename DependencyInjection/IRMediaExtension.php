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

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * Media extension.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRMediaExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load(sprintf('driver/%s/media.xml', $config['db_driver']));
        
        $container->setAlias('ir_media.util.path_generator', $config['service']['path_generator']);
        
        foreach (array('handler', 'listener', 'media', 'resizer', 'test', 'util') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }         
        
        $container->setParameter('ir_media.model.media.class', $config['media_class']);

        if (!empty($config['filesystem'])) {
            $this->loadFilesystem($config['filesystem'], $container, $loader);
        }  
        
        if (!empty($config['contexts'])) {
            $this->loadContexts($config['contexts'], $container);
        }          
    }

    private function loadFilesystem(array $config, ContainerBuilder $container, XmlFileLoader $loader)
    {   
        $loader->load('gaufrette.xml');
        
        $container->getDefinition('ir_media.filesystem.adapter.local')
            ->addArgument($config['local']['directory'])
            ->addArgument($config['local']['create'])
        ;
    }   
    
    private function loadContexts(array $config, ContainerBuilder $container)
    {   
        if (!$container->hasDefinition('ir_media.media_manager')) {
            return;
        }
        
        $mediaManager = $container->getDefinition('ir_media.media_manager');
                
        foreach ($config as $contextName => $contextSettings) {
            $context = array();
            $formats = array();
                                   
            foreach ($contextSettings['formats'] as $formatName => $formatSettings) {
                if (!isset($formatSettings['resizer'])) {
                    $formatSettings['resizer'] = $contextSettings['resizer'];
                }
                
                $formats[$formatName] = $formatSettings;
            }
            
            $context['formats'] = $formats;

            $mediaManager->addMethodCall('addContext', array($contextName, $context));
        }
    }
}
