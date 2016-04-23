<?php

namespace VehiculosBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AltaVehiculoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('documento', 'text', array(
                    'attr' => array('class' => 'maskdocumento')
                ))
                ->add('fechaEmisionDocumento', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => array(
                        'class' => 'datepicker',
                    ),
                ))
                ->add('vin')
                ->add('chasis', 'text', array(
                    'attr' => array('readonly' => 'readonly')
                ))
                ->add('modelo', 'entity', array(
                    'class' => 'VehiculosBundle:CodigoModelo',
                    'attr' => array(
                        'class' => 'select2'
                    ),
                    'query_builder' => function ( EntityRepository $er ) {
                return $er->createQueryBuilder('cm')
                        ->where('cm.activo = true');
            },
                        )
                )
                ->add('colorVehiculo', 'entity', array(
                    'class' => 'VehiculosBundle:ColorVehiculo',
                    'attr' => array(
                        'class' => 'select2'
                    ),
                    'query_builder' => function ( EntityRepository $er ) {
                return $er->createQueryBuilder('cm')
                        ->where('cm.activo = true');
            },
                        )
                )
//                ->add('colorVehiculo')
                ->add('motor')
                ->add('importe', 'money', array(
                    'attr' => array('class' => 'maskmoney')
                ))
                ->add('impuestos', 'money', array(
                    'attr' => array('class' => 'maskmoney')
                ))
                ->add('numeroPedido')
//                ->add('tipoVentaEspecial')
                ->add('tipoVentaEspecial', 'entity', array(
                     'class' => 'VehiculosBundle:TipoVentaEspecial',
                    'label'=>'Tipo venta'
                ))
                ->add('numeroGrupo', 'text', array(
                    'label_attr' => array('class' => 'hidden tipo-venta-especial-field'),
                    'attr' => array('class' => 'hidden tipo-venta-especial-field')
                ))
                ->add('numeroOrden', 'text', array(
                    'label_attr' => array('class' => 'hidden tipo-venta-especial-field'),
                    'attr' => array('class' => 'hidden tipo-venta-especial-field')
                ))
                ->add('numeroSolicitud', 'text', array(
                    'label_attr' => array('class' => 'hidden tipo-venta-especial-field'),
                    'attr' => array('class' => 'hidden tipo-venta-especial-field')
                ))
                ->add('cliente', 'jqueryautocomplete', array(
                    'label' => 'Cliente (Por DNI)',
                    'class' => 'ClientesBundle:Cliente',
//					'property'      => 'nombreCompleto',
                    'search_method' => 'getClienteByDni',
                    'required' => false,
                    'route_name' => 'get_cliente_by_dni',
//					'route_name'    => "buscarPersonaConDominio",
//					'class'         => 'PersonaBundle:Persona',
//					'property'      => 'nombreCompleto',
//					'search_method' => 'getEmpadronadoresPorSector',
                    'label_attr' => array('class' => 'hidden tipo-venta-especial-field cliente'),
                    'attr' => array('class' => 'hidden tipo-venta-especial-field cliente')
                ))
                ->add('remito', new RemitoType());
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
        return 'vehiculosbundle_alta_vehiculo';
    }

}
