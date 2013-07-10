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
 * Context interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ContextInterface
{
    /**
     * Returns the resizer.
     *
     * @return string
     */
    public function getResizer();    
    
    /**
     * Sets the resizer.
     *
     * @param string $resizer
     * 
     * @return ContextInterface
     */
    public function setResizer($resizer);        
}