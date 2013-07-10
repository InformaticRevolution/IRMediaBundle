<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\Model;

/**
 * Default context implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Context implements ContextInterface
{
    /**
     * @var string
     */
    protected $resizer;

    
    /**
     * {@inheritdoc}
     */  
    public function getResizer()
    {
        return $this->resizer;
    }
    
    /**
     * {@inheritdoc}
     */  
    public function setResizer($resizer)
    {
        $this->resizer = $resizer;
        
        return $this;
    }
}