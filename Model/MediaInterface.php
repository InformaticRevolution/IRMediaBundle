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
 * Media interface.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
interface MediaInterface
{   
    /**
     * Returns the id.
     * 
     * @return mixed
     */
    public function getId();      

    /**
     * Returns the reference name.
     *
     * @return string
     */
    public function getReferenceName();    
    
    /**
     * Sets the reference name.
     *
     * @param string $referenceName
     * 
     * @return MediaInterface
     */
    public function setReferenceName($referenceName);    
    
    /**
     * Returns the extension.
     * 
     * @return string
     */
    public function getExtension();    
    
    /**
     * Returns the content type.
     *
     * @return string
     */
    public function getContentType();    
    
    /**
     * Sets the content type.
     *
     * @param string $contentType
     * 
     * @return MediaInterface
     */
    public function setContentType($contentType); 
    
    /**
     * Returns the size in bytes.
     *
     * @return integer
     */
    public function getSize(); 
    
    /**
     * Sets the size in bytes.
     *
     * @param integer $size
     * 
     * @return MediaInterface
     */
    public function setSize($size);

    
    
    
    
    
    
    /**
     * Returns the context.
     *
     * @return string
     */
    public function getContext();    
    
    /**
     * Sets the context.
     *
     * @param string $context
     * 
     * @return MediaInterface
     */
    public function setContext($context);     
    
    
    
    
    
    /**
     * Returns all metadata.
     *
     * @return array
     */
    public function getMetadata();     
    
    /**
     * Sets metadata.
     *
     * @param array $metadata
     *
     * @return MediaInterface
     */
    public function setMetadata(array $metadata);

    /**
     * Returns a metadata.
     *
     * @param string $name
     *
     * @return mixed|null
     */
    public function getMetadataValue($name);    
    
    /**
     * Adds a metadata.
     *
     * @param string $name
     * @param mixed  $value
     * 
     * @return MediaInterface
     */
    public function addMetadataValue($name, $value); 
    
    /**
     * Checks if a metadata is defined.
     * 
     * @param string $name
     * 
     * @return Boolean
     */    
    public function hasMetadataValue($name);    
         
    /**
     * Removes a metadata.
     *
     * @param string $name
     * 
     * @return MediaInterface
     */
    public function removeMetadataValue($name);
    
    /**
     * Clears all metadata.
     *
     * @return MediaInterface
     */
    public function clearMetadata();   
}

