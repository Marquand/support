<?php

namespace PointWeb\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactMailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                "label" => "Nom * :",
                'attr' => array('id' => 'icon_prefix', 'class' => 'validate')
            ))
            ->add('email', 'text', array(
                "label" => "Email * :",
                'attr' => array('id' => 'icon_telephone', 'class' => 'validate')
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PointWeb\AppBundle\Entity\ContactMail'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pointweb_appbundle_contactmail';
    }
}


