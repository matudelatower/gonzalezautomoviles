<?php

namespace VehiculosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AutosVendidosPorVendedorFilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('rango', 'text', array(
                    'required' => false,
                    'attr' => array('class' => 'daterange')
                ))
                ->add('vendedor', 'jqueryautocomplete', array(
                    'label' => 'Vendedor (Por Apellido)',
                    'class' => 'PersonasBundle:Empleado',
//					'property'      => 'nombreCompleto',
                    'search_method' => 'getEmpleadoByApellido',
                    'route_name' => 'get_empleado_by_apellido'
        ));
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

    public function getName() {
        return 'vehiculos_bundle_autos_vendidos_por_vendedor_filter_type';
    }

}
