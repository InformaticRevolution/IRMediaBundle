<?php

/*
 * This file is part of the IRCustomerBundle package.
 *
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use IR\Bundle\MediaBundle\Form\DataTransformer\MediaTransformer;

/**
 * Media type.
 * 
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class MediaType extends AbstractType
{
    /**
     * @var string
     */         
    protected $class;

    
    /**
     * Constructor.
     * 
     * @param string  $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * {@inheritdoc}
     */     
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('data', 'text', array(
                'label'              => 'form.media.data', 
                'translation_domain' => 'ir_media',                
            ))
            ->add('context', 'hidden', array(
                'data' => $options['context'],
            ))
            ->addModelTransformer(new MediaTransformer());
        ;
    }
   
    /**
     * {@inheritdoc}
     */       
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention' => 'media',
        ));
        
        $resolver->setRequired(array(
            'context',
        ));         
    }    
    
    /**
     * {@inheritdoc}
     */        
    public function getName()
    {
        return 'ir_media';
    }   
}