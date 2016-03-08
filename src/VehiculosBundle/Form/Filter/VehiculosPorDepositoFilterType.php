<?php

namespace VehiculosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculosPorDepositoFilterType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('modelo', 'entity', array(
                    'class' => 'VehiculosBundle:NombreModelo',
                    'choice_label' => 'nombre',
                    'required' => false,
                ))
                ->add('colorVehiculo', 'entity', array(
                    'class' => 'VehiculosBundle:ColorVehiculo',
                    'choice_label' => 'color',
                    'required' => false,
                ))
                ->add('deposito', 'entity', array(
                    'class' => 'VehiculosBundle:Deposito',
                    'choice_label' => 'nombre',
                    'required' => true,
                ))             
                
                ->add('tipoVentaEspecial', 'entity', array(
                    'class' => 'VehiculosBundle:TipoVentaEspecial',
                    'choice_label' => 'nombre',
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
        return 'vehiculosbundle_vehiculos_por_deposito_filter';
    }

}
