<?php

namespace PointWeb\GuestBookBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GuestBookType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', 'text', array(
                "label" => "Nom * :",
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('firstname', 'text', array(
                'required' => false,
                "label" => "Prénom :",
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('email', 'text', array(
                'required' => true,
                "label" => "Email * :",
                'required' => true,
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('comment', 'textarea', array(
                "label" => "Commentaire * :",
                'required' => false,
                'attr' => array('class' => 'tinymce form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('notation', 'integer', array(
                'required' => false,
                "label" => "Notation :",
                'attr' => array('class' => 'form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ));
        if ($options['back']) {
            $builder
                ->add('online', 'choice', array(
                    'label' => 'En ligne ?',
                    'required' => false,
                    'placeholder' => false,
                    'choices' => array(
                        '1' => 'Oui',
                        '0' => 'Non'
                    ),
                    'data' => '0',
                    'multiple' => false,
                    'expanded' => true,
                    'attr' => array('class' => 'radio'),
                    'label_attr' => array('class' => 'col-lg-2 control-label'),
                ));
        }

    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PointWeb\GuestBookBundle\Entity\GuestBook',
            'back' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pointweb_guestbookbundle_guestbook';
    }
}
