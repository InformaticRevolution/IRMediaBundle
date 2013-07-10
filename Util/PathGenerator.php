<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\Util;

use IR\Bundle\MediaBundle\Model\MediaInterface;

/**
 * Default path generator implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class PathGenerator implements PathGeneratorInterface
{
    /**
     * @var integer
     */
    protected $firstLevel;

    /**
     * @var integer
     */    
    protected $secondLevel;

    /**
     * Constructor.
     * 
     * @param int $firstLevel
     * @param int $secondLevel
     */
    public function __construct($firstLevel = 100000, $secondLevel = 1000)
    {
        $this->firstLevel = $firstLevel;
        $this->secondLevel = $secondLevel;
    }

    /**
     * {@inheritdoc}
     */
    public function generatePath(MediaInterface $media)
    {
        $firstLevelRepertory = (int) ($media->getId() / $this->firstLevel);
        $secondLevelRepertory = (int) (($media->getId() - ($firstLevelRepertory * $this->firstLevel)) / $this->secondLevel);

        return sprintf('%04s/%02s', $firstLevelRepertory + 1, $secondLevelRepertory + 1);
    }
}