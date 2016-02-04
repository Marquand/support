<?php

namespace PointWeb\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CalendarEventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', 'date', array(
                'label' => "Date de début :",
                'widget' => 'single_text',
                'input' => 'datetime',
                'required' => false,
                'format' => 'dd/MM/yyyy HH:mm',
                'attr' => array('class' => 'form-control datetimepicker'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('endDate', 'date', array(
                'label' => "Date de fin :",
                'widget' => 'single_text',
                'input' => 'datetime',
                'required' => false,
                'format' => 'dd/MM/yyyy HH:mm',
                'attr' => array('class' => 'form-control datetimepicker'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
            ->add('description', 'textarea', array(
                "label" => "Description :",
                'required' => false,
                'attr' => array('class' => 'tinymce form-control'),
                'label_attr' => array('class' => 'col-lg-2 control-label'),
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PointWeb\CalendarBundle\Entity\CalendarEvent'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'pointweb_calendarbundle_calendarevent';
    }
}
