<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatentamientoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('estadoPatentamiento')
                ->add('agenteInicioPatente')
                ->add('fechaInicio', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                     'attr' => array('class' => 'datepicker'),
                ))
                ->add('dominio', 'text', array(
                    'label_attr' => array('class' => 'hidden estado-patente-field'),
                    'attr' => array('class' => 'hidden estado-patente-field')
                ))
                ->add('fechaPatentamiento', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => array('class' => 'datepicker  hidden estado-patente-field'),
                    'label_attr' => array('class' => 'hidden estado-patente-field'),
                ))
                ->add('registro', 'text', array(
                    'label_attr' => array('class' => ' hidden estado-patente-field'),
                    'attr' => array('class' => ' hidden estado-patente-field')
                ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'VehiculosBundle\Entity\Patentamiento'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'vehiculosbundle_patentamiento';
    }

}
