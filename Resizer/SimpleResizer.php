<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\Resizer;

use Gaufrette\File;
use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;

/**
 * ???
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class SimpleResizer implements ResizerInterface
{
    /**
     * @var ImagineInterface
     */
    protected $adapter;

    
    /**
     * Constructor.
     * 
     * @param ImagineInterface $adapter
     */
    public function __construct(ImagineInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function resize(File $in, File $out, $format, $width = null, $height = null, $quality = 100)
    {        
        if (null === $width && null === $height) {
            throw new \RuntimeException(sprintf('You need to specify a width or a height'));
        }        
        
        $image = $this->adapter->load($in->getContent());
        $size = $image->getSize();
        
        if(null === $height) {
            $height = (int) ($width * $size->getHeight() / $size->getWidth());
        }
        else if (null === $width) {
            $width = (int) ($height * $size->getWidth() / $size->getHeight());
        }        
        
        $ratios = array(
            $width / $size->getWidth(),
            $height / $size->getHeight()
        );        
        
        $ratio = min($ratios);
        $box = $size->scale($ratio);
                        
        $content = $image
            ->resize($box)
            ->get($format, array('quality' => $quality))
        ;        
        
        $out->setContent($content);
    }
}