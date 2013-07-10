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

use IR\Bundle\MediaBundle\Model\MediaInterface;

/**
 * Media manager interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface MediaManagerInterface
{   
    /**
     * Creates an empty media instance.
     *
     * @return MediaInterface
     */    
    public function createMedia();
    
    /**
     * Updates a media.
     *
     * @param MediaInterface $media
     * 
     * @return void
     */
    public function updateMedia(MediaInterface $media);    
         
    /**
     * Deletes a media.
     *
     * @param MediaInterface $media
     *
     * @return void
     */
    public function deleteMedia(MediaInterface $media);    

    /**
     * Finds a media by the given criteria.
     *
     * @param array $criteria
     *
     * @return MediaInterface|null
     */
    public function findMediaBy(array $criteria);    

    /**
     * Returns the media's fully qualified class name.
     *
     * @return string
     */
    public function getClass(); 
}

