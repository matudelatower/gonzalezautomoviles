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
                    'search_method' => 'getEmpleadoByApellido',
                    'required' => true,
                    'route_name' => 'get_empleado_by_apellido'
                ))
                ->add('cliente', 'jqueryautocomplete', array(
                    'class' => 'ClientesBundle:Cliente',
                    'search_method' => 'getClienteByApellido',
                    'required' => true,
                    'route_name' => 'get_cliente_by_apellido',
                    'attr' => array('placeholder' => 'Ingrese Apellido'),
                    'query_builder' => function (EntityRepository $er) {
	                    return $er->createQueryBuilder('c')
	                              ->setMaxResults(1);
                    },
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
