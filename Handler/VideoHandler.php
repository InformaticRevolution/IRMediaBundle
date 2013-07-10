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

use Buzz\Browser;
use Gaufrette\Filesystem;
use IR\Bundle\MediaBundle\Model\MediaInterface;
use IR\Bundle\MediaBundle\Util\PathGeneratorInterface;

/**
 * Video handler implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class VideoHandler extends BaseHandler
{
    protected $browser;
 
    
    /**
     * Constructor.
     * 
     * @param Filesystem   $filesystem
     * @param MediaManager $mediaManager
     */        
    public function __construct(Filesystem $filesystem, PathGeneratorInterface $pathGenerator, Browser $browser)
    {
        parent::__construct($filesystem, $pathGenerator);

        $this->browser = $browser;
    }    
    
    protected function doHandleUpload(MediaInterface $media)
    {
        $this->fixBinaryContent($media);
        
        // Ce n'est pas un lien youtube valide
        if (!$media->data) {
            return;
        }
        
        $media->setReferenceName($media->data);
        $this->updateMetadata($media);
    }
    
    protected function doHandlePostUpload(MediaInterface $media)
    {
        
    }
   
    protected function doHandleRemove(MediaInterface $media)
    {
        
    }
    
    protected function fixBinaryContent(MediaInterface $media)
    {
        if (preg_match("/(?<=v(\=|\/))([-a-zA-Z0-9_]+)|(?<=youtu\.be\/)([-a-zA-Z0-9_]+)/", $media->data, $matches)) {
            $media->data = $matches[2];
        }
    }     
    
    public function updateMetadata(MediaInterface $media, $force = false)
    {
        $url = sprintf('http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=%s&format=json', $media->getReferenceName());

        try {
            $metadata = $this->getMetadata($media, $url);
        } catch (\RuntimeException $e) {
            return;
        }

        $media->setContentType('video/x-flv');        
    }
    
    protected function getMetadata(MediaInterface $media, $url)
    {
        try {
            $response = $this->browser->get($url);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException('Unable to retrieve the video information for :' . $url, null, $e);
        }

        $metadata = json_decode($response->getContent(), true);

        if (!$metadata) {
            throw new \RuntimeException('Unable to decode the video information for :' . $url);
        }

        return $metadata;
    }     
}
