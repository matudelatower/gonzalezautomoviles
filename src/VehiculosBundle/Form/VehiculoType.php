<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('documento')
                ->add('fechaEmisionDocumento', 'date', array(
                    'widget' => 'single_text',
                    'format' => 'dd-MM-yyyy',
                    'attr' => array(
                        'class' => 'datepicker',
                    ),
                ))
                ->add('vin')
                ->add('chasis')
                ->add('modelo')
                ->add('colorExterno')
                ->add('motor')
                ->add('importe')
                ->add('impuestos')
                ->add('numeroPedido')
                ->add('tipoVentaEspecial')
                ->add('remito', new RemitoType())
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
            'data_class' => 'VehiculosBundle\Entity\Vehiculo'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'vehiculosbundle_vehiculo';
    }

}
