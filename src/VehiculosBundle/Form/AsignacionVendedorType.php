<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AsignacionVendedorType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                
                
                  ->add('vendedor', 'jqueryautocomplete', array(
                    'label' => 'Vendedor (Por Apellido)',
                    'class' => 'PersonasBundle:Empleado',
                    'search_method' => 'getEmpleadoByApellido',
                    'required' => true,
                    'route_name' => 'get_empleado_by_apellido',
                      'attr'=>array('placeholder'=>'Ingrese Apellido')
                ))
//               
//                 ->add('vendedor', 'jqueryautocomplete', array(
//                    'class' => 'ClientesBundle:Cliente',
//                    'search_method' => 'getClienteByApellido',
//                    'required' => false,
//                    'route_name' => 'get_cliente_by_apellido',
//                     'attr'=>array('placeholder'=>'Ingrese Apellido')
//                  
//                ))

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'VehiculosBundle\Entity\Vehiculo'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'vehiculosbundle_asignacion_vendedor';
    }

}
