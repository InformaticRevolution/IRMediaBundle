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
use IR\Bundle\MediaBundle\Model\MediaInterface;
use IR\Bundle\MediaBundle\Util\PathGeneratorInterface;

/**
 * Image handler implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class ImageHandler extends FileHandler
{
    protected function doHandlePostUpload(MediaInterface $media)
    {
        $this->generateThumbnails($media);
    }      
    
    protected function doHandleRemove(MediaInterface $media)
    {
        parent::doHandleRemove($media);
        
        $this->removeThumbnails($media);
    }    
    
    protected function generateThumbnails(MediaInterface $media)
    {        
        $context = $this->mediaManager->getContext($media->getContext());
       
        $in = $this->filesystem->createFile($this->getReferencePath($media), false);
        
        foreach ($context['formats'] as $name => $settings) {
            if (null !== $media->oldReference) {
                $this->removeThumbnail($media, $name, pathinfo($media->oldReference, PATHINFO_EXTENSION));
            }
            
            $out = $this->filesystem->createFile($this->getThumbnailPath($media, $name, $media->getExtension()), true);
            
            $resizer = $this->mediaManager->getResizer($settings['resizer']);
            $resizer->resize($in, $out, $media->getExtension(), $settings['width'], $settings['height'], $settings['quality']);
        }        
    }    
    
    protected function removeThumbnails(MediaInterface $media)
    {
        $context = $this->mediaManager->getContext($media->getContext());
        
        foreach ($context['formats'] as $name => $settings) {
            $this->removeThumbnail($media, $name, $media->getExtension());        
        }        
    }    
    
    protected function removeThumbnail(MediaInterface $media, $format, $extension)
    {        
        $path = $this->getThumbnailPath($media, $format, $extension);
        
        if ($this->filesystem->has($path)) {
            $this->filesystem->delete($path);
        }            
    }    
    
    /**
     * Get thumbnail path.
     *
     * @param MediaInterface $media
     * 
     * return string
     */        
    public function getThumbnailPath(MediaInterface $media, $format, $extension)
    {
        return sprintf('%s/%s_%s.%s',
            $this->generatePath($media),
            $media->getId(),
            $format,
            $extension
        );
    }      
}
