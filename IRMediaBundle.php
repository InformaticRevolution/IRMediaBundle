<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;

use IR\Bundle\MediaBundle\DependencyInjection\Compiler\HandlerPass;
use IR\Bundle\MediaBundle\DependencyInjection\Compiler\ResizerPass;

/**
 * This bundle provides simple architecture for media management.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class IRMediaBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */    
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        
        $this->addRegisterMappingsPass($container);
        
        $container->addCompilerPass(new HandlerPass());
        $container->addCompilerPass(new ResizerPass());
    }    
    
    private function addRegisterMappingsPass(ContainerBuilder $container)
    {
        $mappings = array(
            realpath(__DIR__ . '/Resources/config/doctrine/model') => 'IR\Bundle\MediaBundle\Model',
        );   
        
        $container->addCompilerPass(DoctrineOrmMappingsPass::createXmlMappingDriver($mappings, array('ir_media.entity_manager')));     
    }    
}
