<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Form\EventListener\AddAnioCodigoVersionFieldSubscriber;

class VehiculoFilterType extends AbstractType {

    private $em;
    public function __construct($em) {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $factory                         = $builder->getFormFactory();
        $builder->addEventSubscriber(new AddAnioCodigoVersionFieldSubscriber($factory,$this->em));
        $builder
                ->add('vin', 'text', array(
                    'required' => false,
                ))
                ->add('colorVehiculo', 'entity', array(
                    'class' => 'VehiculosBundle:ColorVehiculo',
                    'choice_label' => 'color',
                    'required' => false,
                ))
                ->add('modelo', 'entity', array(
                    'class' => 'VehiculosBundle:NombreModelo',
                    'choice_label' => 'nombre',
                    'required' => false,
                    'attr'=>array('class'=>'modelo'),
                ))
                ->add('tipoVentaEspecial', 'entity', array(
                    'class' => 'VehiculosBundle:TipoVentaEspecial',
                    'choice_label' => 'nombre',
                    'required' => false,
                ))
                ->add('deposito', 'entity', array(
                    'class' => 'VehiculosBundle:Deposito',
                    'choice_label' => 'nombre',
                    'required' => false,
                ))
                ->add('cliente', 'jqueryautocomplete', array(
                    'label' => 'Cliente (Por DNI)',
                    'class' => 'ClientesBundle:Cliente',
                    'search_method' => 'getClienteByDni',
                    'required' => false,
                    'route_name' => 'get_cliente_by_dni',
                ))
                ->add('registrosPaginador', 'choice', array(
                    'data' => '10',
                    'choices' => array(
                        '5' => '5',
                        '10' => '10',
                        '20' => '20',
                        '30' => '30',
                        '40' => '40',
                        '50' => '50',
                        '60' => '60',
                        '70' => '70',
                        '80' => '80',
                        '90' => '90',
                        '100' => '100',
                    ),
                    "attr" => array("onchange" => 'document.form_listado.submit()')
                ))
                ->add('estadoVehiculo', 'entity',array(
                    'class'=> 'VehiculosBundle\Entity\TipoEstadoVehiculo',
                    'required'=> false,

                ))
                ->add( 'rango','text', array(
                    'required' => false,
                    'attr' => array( 'class' => 'daterange' )
                ) )
                ->add('numeroGrupo','text',array(
                    'required'=>false,
                ))
                 ->add('numeroOrden','text',array(
                    'required'=>false,
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
        return 'vehiculosbundle_vehiculo_filter';
    }

}
