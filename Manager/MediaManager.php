<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\Manager;

/**
 * Abstract media manager implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class MediaManager implements MediaManagerInterface
{
    /**
     * {@inheritdoc}
     */  
    public function createMedia()
    {
        $class = $this->getClass();
        $media = new $class;

        return $media;
    } 
}
