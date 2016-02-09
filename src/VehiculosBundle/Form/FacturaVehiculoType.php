<?php

namespace VehiculosBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FacturaVehiculoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('factura', new FacturaType())
                ->add('vendedor', 'jqueryautocomplete', array(
                    'label' => 'Vendedor (Por Apellido)',
                    'class' => 'PersonasBundle:Empleado',
//					'property'      => 'nombreCompleto',
                    'search_method' => 'getEmpleadoByApellido',
                    'required' => false,
                    'route_name' => 'get_empleado_by_apellido'
//					'route_name'    => "buscarPersonaConDominio",
//					'class'         => 'PersonaBundle:Persona',
//					'property'      => 'nombreCompleto',
//					'search_method' => 'getEmpadronadoresPorSector',
//                    'label_attr' => array('class' => 'hidden tipo-venta-especial-field'),
//                    'attr' => array('class' => 'hidden tipo-venta-especial-field')
        ));
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
        return 'vehiculosbundle_factura_vehiculo';
    }

}
