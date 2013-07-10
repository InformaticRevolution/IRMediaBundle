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
 * Base handler implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class BaseHandler implements MediaHandlerInterface
{
    /**
     * @var Filesystem
     */    
    protected $filesystem;    
    
    /**
     * @var PathGeneratorInterface
     */    
    protected $pathGenerator;    

    /**
     * @var MediaManager
     */    
    protected $mediaManager;      
    
    /**
     * Constructor.
     * 
     * @param Filesystem   $filesystem
     * @param MediaManager $mediaManager
     */        
    public function __construct(Filesystem $filesystem, PathGeneratorInterface $pathGenerator)
    {
        $this->filesystem = $filesystem;
        $this->pathGenerator = $pathGenerator;
    }

    public function setMediaManager(MediaManager $mediaManager)
    {
        $this->mediaManager = $mediaManager;
    }    
    
    public function handleUpload(MediaInterface $media)
    {
        if (null === $media->data) {
            return;
        }        
        
        $this->doHandleUpload($media);
    }

    public function handlePostUpload(MediaInterface $media)
    {
        if (null === $media->data) {
            return;
        }        
        
        $this->doHandlePostUpload($media);
    }      

    public function handleRemove(MediaInterface $media)
    {
        $this->doHandleRemove($media);
    }       
    
    abstract protected function doHandleUpload(MediaInterface $media); 
    
    abstract protected function doHandlePostUpload(MediaInterface $media);
   
    abstract protected function doHandleRemove(MediaInterface $media);
}
