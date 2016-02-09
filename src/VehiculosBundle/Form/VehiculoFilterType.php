<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculoFilterType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
//                ->add('documento')
//                ->add('fechaEmisionDocumento', 'date', array(
//                    'widget' => 'single_text',
//                    'format' => 'dd-MM-yyyy',
//                    'attr' => array(
//                        'class' => 'datepicker',
//                    ),
//                ))
                ->add('vin', 'text', array(
                    'required' => false,
                ))
//                ->add('modelo')
                ->add('colorVehiculo', 'entity', array(
                    'class' => 'VehiculosBundle:ColorVehiculo',
                    'choice_label' => 'color',
                    'required' => false,
                ))
               ->add('modelo', 'entity', array(
                    'class' => 'VehiculosBundle:NombreModelo',
                    'choice_label' => 'nombre',
                    'required' => false,
                ))
//                ->add('motor', 'text', array(
//                    'required' => false,
//                ))
//                ->add('importe')
//                ->add('impuestos')
//                ->add('numeroPedido')
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
//                ->add('remito', new RemitoType())
//            ->add('importe')
//            ->add('impuestos')
//            ->add('tipoVentaEspecial')
//            ->add('nombreVehiculo')
//            ->add('anioFabricacion')
//            ->add('codigoLlave')
//            ->add('codigoRadio')
//            ->add('codigoSeguridad')
//            ->add('codigoInmovilizador')
//            ->add('kmIngreso')
//            ->add('observacion')
//            ->add('creado')
//            ->add('actualizado')
//            ->add('creadoPor')
//            ->add('actualizadoPor')
//            ->add('cliente')
//            ->add('tipoCompra')
//            ->add('factura')
//            ->add('patentamiento')
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
