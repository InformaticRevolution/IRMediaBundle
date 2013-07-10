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

/**
 * Resizer interface.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface ResizerInterface
{
    /**
     * Resize an image.
     * 
     * @param File    $in
     * @param File    $out
     * @param string  $format
     * @param integer $width
     * @param integer $height
     * @param integer $quality
     *
     * @return void
     */
    public function resize(File $in, File $out, $format, $width = null, $height = null, $quality = 100);
}