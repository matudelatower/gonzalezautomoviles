<?php

namespace VehiculosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReportePatentamientosFilterType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('estado', 'choice', array(
                    'choices' => array(
                        'pendiente' => 'Pendiente',
                        'iniciado' => 'Iniciado',
                        'patentado' => 'Patentado',
                    ),
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                ))
                ->add('tipoVentaEspecial', 'entity', array(
                    'class' => 'VehiculosBundle:TipoVentaEspecial',
                    'choice_label' => 'nombre',
                    'required' => false,
                ))
                ->add('rango', 'text', array(
                    'attr' => array('class' => 'daterange fecha-rango hidden'),
                    'label_attr' => array('class' => 'fecha-rango hidden'),
                     'required' => false,
                ))

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'vehiculosbundle_reporte_patentamientos_filter';
    }

}
