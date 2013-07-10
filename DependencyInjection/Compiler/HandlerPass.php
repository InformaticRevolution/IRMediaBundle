<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Adds all services with the tags "ir_media.handler" to the media manager.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class HandlerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {                
        if (!$container->hasDefinition('ir_media.media_manager')) {
            return;
        }        
        
        $definition = $container->getDefinition('ir_media.media_manager');        
                
        foreach ($container->findTaggedServiceIds('ir_media.handler') as $id => $attributes) {
            if (!isset($attributes[0]['alias'])) {
                throw new \InvalidArgumentException(sprintf('Handler service "%s" must have an alias attribute', $id));
            }

            $definition->addMethodCall('addHandler', array($attributes[0]['alias'], new Reference($id)));
            
            $handlerDefinition = $container->getDefinition($id);
            $handlerDefinition->addMethodCall('setMediaManager', array(new Reference('ir_media.media_manager')));
        }        
    }  
}