<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\Handler;

use Gaufrette\Filesystem;
use IR\Bundle\MediaBundle\MediaManager;
use IR\Bundle\MediaBundle\Model\MediaInterface;
use IR\Bundle\MediaBundle\Util\PathGeneratorInterface;

/**
 * File handler implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class FileHandler extends BaseHandler
{
    protected function doHandleUpload(MediaInterface $media)
    {
        $this->updateMedia($media);
        $this->saveFile($media);
    }    

    protected function doHandlePostUpload(MediaInterface $media)
    {
    }    

    protected function doHandleRemove(MediaInterface $media)
    {
        $this->removeReferenceFile($media);
    }

    protected function updateMedia(MediaInterface $media)
    {
        $file = $media->data;

        $media->setSize($file->getSize());
        $media->setContentType($file->getMimeType());
    }    
    
    protected function saveFile(MediaInterface $media)
    {   
        if (null !== $media->getReferenceName()) {
           // Remove the file because the new file can have a different extension.
           $this->removeReferenceFile($media); 
        }
        
        $media->oldReference = $media->getReferenceName();
        $media->setReferenceName($this->generateReferenceName($media));
        
        $file = $this->filesystem->createFile($this->getReferencePath($media), true);
        $file->setContent(file_get_contents($media->data->getRealPath()));
    }
    
    protected function removeReferenceFile(MediaInterface $media)
    {
        $path = $this->getReferencePath($media);
            
        if ($this->filesystem->has($path)) {
            $this->filesystem->delete($path);
        }            
    }    

    /**
     * Generate reference name.
     *
     * @param MediaInterface $media
     * 
     * return string
     */        
    protected function generateReferenceName(MediaInterface $media)
    {        
        return bin2hex(openssl_random_pseudo_bytes(20)) . '.' . $media->data->guessExtension();
    }      
    
    /**
     * Generate path.
     *
     * @param MediaInterface $media
     * 
     * return string
     */    
    protected function generatePath(MediaInterface $media)
    {
        return $this->pathGenerator->generatePath($media);
    }    
    
    /**
     * Get reference path.
     *
     * @param MediaInterface $media
     * 
     * return string
     */        
    protected function getReferencePath(MediaInterface $media)
    {
        return sprintf('%s/%s',
            $this->generatePath($media),
            $media->getReferenceName()
        );
    }
}
