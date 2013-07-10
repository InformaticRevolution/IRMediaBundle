<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use IR\Bundle\MediaBundle\Model\MediaInterface;
use IR\Bundle\MediaBundle\Manager\MediaManager as AbstractMediaManager;

/**
 * Doctrine media manager.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MediaManager extends AbstractMediaManager
{
    /**
     * @var ObjectManager
     */          
    protected $objectManager;
    
    /**
     * @var EntityRepository
     */           
    protected $repository;    

    /**
     * @var string
     */           
    protected $class;  
    
    
   /**
    * Constructor.
    *
    * @param ObjectManager $om
    * @param string        $class
    */        
    public function __construct(ObjectManager $om, $class)
    {        
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }      
    
    /**
     * Updates a media.
     *
     * @param MediaInterface $media
     * @param Boolean        $andFlush Whether to flush the changes (default true)
     */ 
    public function updateMedia(MediaInterface $media, $andFlush = true)
    {  
        $this->objectManager->persist($media);
        
        if ($andFlush) {
            $this->objectManager->flush();
        }   
    }

    /**
     * {@inheritDoc}
     */     
    public function deleteMedia(MediaInterface $media)
    {
        $this->objectManager->remove($media);
        $this->objectManager->flush();          
    }

    /**
     * {@inheritDoc}
     */
    public function findMediaBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */    
    public function getClass()
    {
        return $this->class;
    }
}
