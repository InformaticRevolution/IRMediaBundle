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

use Imagine\Image\ImagineInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;


/**
 * This reziser crop the image when the width and height are specified.
 * Every time you specify the W and H, the script generate a square with the
 * smaller size. For example, if width is 100 and height 80; the generated image
 * will be 80x80.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class SquareResizer implements ResizerInterface
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
        if (null === $width) {
            throw new \InvalidArgumentException('Width cannot be null');
        }

        $image = $this->adapter->load($in->getContent());
        $size = $image->getSize();
        
        $min = min($size->getWidth(), $size->getHeight());
        $max = max($size->getWidth(), $size->getHeight());
                
        $image->crop(new Point(($size->getWidth()-$min)/2, ($size->getHeight()-$min)/2), new Box($min, $min));
        
        $content = $image
            ->thumbnail(new Box($width, $width))
            ->get($format, array('quality' => $quality))
        ;
        
        $out->setContent($content);
    }
}