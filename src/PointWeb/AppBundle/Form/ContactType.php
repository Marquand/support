<?php

namespace PointWeb\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', 'text', array(
                "label" => "Nom :",
                'attr' => array('id' => 'icon_prefix', 'class' => 'validate'
            )))
            ->add('firstname', 'text', array(
                "label" => "Prénom :",
                'attr' => array('id' => 'icon_prefix', 'class' => 'validate'
            )))
            ->add('phone', 'text', array(
                "label" => "Téléphone :",
                'attr' => array('id' => 'icon_prefix', 'class' => 'validate'
            )))
            ->add('email', 'text', array(
                "label" => "Email :",
                'attr' => array('id' => 'icon_prefix', 'class' => 'validate'
            )))
            ->add('address', 'text', array(
                "label" => "Adresse :",
                'attr' => array('id' => 'icon_prefix', 'class' => 'validate'
            )))
            ->add('zipCode', 'text', array(
                "label" => "Code postal :",
                'attr' => array('id' => 'icon_prefix', 'class' => 'validate'
            )))
            ->add('city', 'text', array(
                "label" => "Ville :",
                'attr' => array('id' => 'icon_prefix', 'class' => 'validate'
            )))



            ->add('Mactualite', 'choice', array(
                'required' => false,
                'placeholder' => false,
                'choices' => array(
                    '1' => 'Oui',
                    '0' => 'Non'
                ),
                'data' => false,
                "label" => "Module Actualité :",
                'attr' => array( 'class' => ' '
            )))
            ->add('Mcontact', 'choice', array(
                'required' => false,
                'placeholder' => false,
                'choices' => array(
                    '1' => 'Oui',
                    '0' => 'Non'
                ),
                'data' => false,
                "label" => "Module Actualité :",
                'attr' => array( 'class' => ' '
            )))
            ->add('Mproduit', 'choice', array(
                'required' => false,
                'placeholder' => false,
                'choices' => array(
                    '1' => 'Oui',
                    '0' => 'Non'
                ),
                'data' => false,
                "label" => "Module Actualité :",
                'attr' => array( 'class' => ' '
            )))
            ->add('Mlivre', 'choice', array(
                'required' => false,
                'placeholder' => false,
                'choices' => array(
                    '1' => 'Oui',
                    '0' => 'Non'
                ),
                'data' => false,
                "label" => "Module Actualité :",
                'attr' => array( 'class' => ' '
            )))
            ->add('Mpartenaire', 'choice', array(
                'required' => false,
                'placeholder' => false,
                'choices' => array(
                    '1' => 'Oui',
                    '0' => 'Non'
                ),
                'data' => false,
                "label" => "Module Actualité :",
                'attr' => array( 'class' => ' '
            )))
            ->add('Mcategorie', 'choice', array(
                'required' => false,
                'placeholder' => false,
                'choices' => array(
                    '1' => 'Oui',
                    '0' => 'Non'
                ),
                'data' => false,
                "label" => "Module Actualité :",
                'attr' => array( 'class' => ' '
            )))
            ->add('Mreferencement', 'choice', array(
                'required' => false,
                'placeholder' => false,
                'choices' => array(
                    '1' => 'Oui',
                    '0' => 'Non'
                ),
                'data' => false,
                "label" => "Module Actualité :",
                'attr' => array( 'class' => ' '
            )))
            ->add('Mcalendrier', 'choice', array(
                'required' => false,
                'placeholder' => false,
                'choices' => array(
                    '1' => 'Oui',
                    '0' => 'Non'
                ),

                'data' => false,
                "label" => "Module Actualité :",
                'attr' => array( 'class' => ''
            )))
            ->add('Mnewsletter', 'choice', array(
                'required' => false,
                'placeholder' => false,
                'choices' => array(
                    '1' => 'Oui',
                    '0' => 'Non'
                ),

                'data' => false,
                "label" => "Module Actualité :",
                'attr' => array( 'class' => ''
            )))



            ->add('Mautre', 'text', array(
                "label" => "Autre Module :",
                'attr' => array('id' => 'icon_prefix', 'class' => 'validate'
            )))
            ->add('message', 'textarea', array(
                "label" => "Message :",
                'attr' => array( 'class' => 'control-label'
            )));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PointWeb\AppBundle\Entity\Contact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pointweb_appbundle_contact';
    }
}
