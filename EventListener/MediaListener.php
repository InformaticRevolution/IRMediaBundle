<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\EventListener;

use IR\Bundle\MediaBundle\Model\MediaInterface;
use IR\Bundle\MediaBundle\Util\PathGeneratorInterface;


use Doctrine\ORM\Events;
use Doctrine\Common\EventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;


/**
 * Media listener.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MediaListener implements EventSubscriber
{
    protected $mediaManager;
    
    protected $handler;

    
    public function __construct($mediaManager)
    {
        $this->mediaManager = $mediaManager;
        $this->handler = $mediaManager->getHandler('video');
    }

    /**
     * {@inheritdoc}
     */       
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::postPersist,
            Events::preUpdate,
            Events::postUpdate,
            Events::preRemove,
        );
    }    
    
    /**
     * Pre persist.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {   
        $object = $args->getEntity();
        if ($object instanceof MediaInterface) {
            $this->handler->handleUpload($object);
        }
    }    

    /**
     * Post persist.
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof MediaInterface) {   
            $this->handler->handlePostUpload($object);
        }
    }    
    
    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof MediaInterface) {
            $this->handler->handleUpload($object);
            
            // We are doing a update, so we must force Doctrine to update the
            // changeset in case we changed something above
            $em = $args->getEntityManager();
            $uow = $em->getUnitOfWork();
            $meta = $em->getClassMetadata(get_class($object));
            $uow->recomputeSingleEntityChangeSet($meta, $object);            
        }
    }    
    
    
    public function postUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof MediaInterface) {
            $this->handler->handlePostUpload($object);
        }        
    }   
    
    public function preRemove(EventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof MediaInterface) { 
            $this->handler->handleRemove($object);
        }        
    }   
}