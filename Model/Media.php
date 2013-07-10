<?php

/*
 * This file is part of the IRMediaBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\Model;

/**
 * Abstract media implementation.
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
abstract class Media implements MediaInterface
{
    /**
     * @var mixed
     */
    protected $id; 

    /**
     * @var string
     */
    protected $referenceName;     
    
    /**
     * @var string
     */
    protected $contentType; 
    
    /**
     * @var integer
     */
    protected $size; 
    
    
    public $oldReference;
    
    /**
     * @var string
     */
    protected $context;    

    
    /**
     * @var array
     */    
    protected $metadata;  
    
    public $data;
    
        
    /**
     * Constructor.
     */            
    public function __construct()
    {
        $this->metadata = array();
    }      
    
    /**
     * {@inheritdoc}
     */  
    public function getId()
    {
        return $this->id;
    } 
   
    /**
     * {@inheritdoc}
     */    
    public function getReferenceName()
    {
        return $this->referenceName;
    }    

    /**
     * {@inheritdoc}
     */
    public function setReferenceName($referenceName)
    {
        $this->referenceName = $referenceName;
        
        return $this;
    }    
   
    /**
     * {@inheritdoc}
     */
    public function getExtension()
    {        
        return pathinfo($this->getReferenceName(), PATHINFO_EXTENSION);
    }    
    
    /**
     * {@inheritdoc}
     */
    public function getContentType()
    {
        return $this->contentType;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return $this->size;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setSize($size)
    {
        $this->size = $size;
        
        return $this;
    }

    
    
    
    
    
    /**
     * Returns the context.
     *
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }
    
    /**
     * Sets the context.
     *
     * @param string $context
     */
    public function setContext($context)
    {
        $this->context = $context;
        
        return $this;
    }
    


    /**
     * {@inheritdoc}
     */    
    public function getMetadata()
    {
        return $this->metadata;
    }    
    
    /**
     * {@inheritdoc}
     */  
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
        
        return $this;
    }

    /**
     * {@inheritdoc}
     */  
    public function getMetadataValue($name)
    {
        return isset($this->metadata[$name]) ? $this->metadata[$name] : null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addMetadataValue($name, $value)
    {
        $this->metadata[$name] = $value;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */    
    public function removeMetadataValue($name)
    {
        unset($this->metadata[$name]);
        
        return $this;
    }    
    
    /**
     * {@inheritdoc}
     */    
    public function hasMetadataValue($name)
    {
        return isset($this->metadata[$name]);
    }    
        
    /**
     * {@inheritdoc}
     */   
    public function clearMetadata()
    {
        $this->metadata = array();

        return $this;        
    }
}