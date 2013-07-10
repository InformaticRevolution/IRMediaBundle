<?php

namespace IR\Bundle\MediaBundle;

use Gaufrette\Filesystem;
use IR\Bundle\MediaBundle\Model\ContextInterface;
use IR\Bundle\MediaBundle\Resizer\ResizerInterface;
use IR\Bundle\MediaBundle\Handler\MediaHandlerInterface;

class MediaManager {

    protected $handlers;
        
    protected $resizers;    
    
    protected $contexts;


    public function __construct() 
    {
        $this->handlers = array();
        $this->resizers = array();
        $this->contexts = array();
    }

    public function getHandler($name)
    {
        return $this->handlers[$name];
    }
    
    public function addHandler($name, MediaHandlerInterface $handler)
    {   
        $this->handlers[$name] = $handler;
    }    

    public function getResizer($name)
    {
        return $this->resizers[$name];
    }    
    
    public function addResizer($name, ResizerInterface $resizer)
    {
        $this->resizers[$name] = $resizer;
    }    
    
    public function getContext($name)
    {
        return $this->contexts[$name];
    }    
    
    public function addContext($name, $context)
    {
        $this->contexts[$name] = $context;
    }    
}