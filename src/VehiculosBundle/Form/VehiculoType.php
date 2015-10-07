<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vin')
            ->add('nombreVehiculo')
            ->add('modelo')
            ->add('anioFabricacion')
            ->add('motor')
            ->add('codigoLlave')
            ->add('codigoRadio')
            ->add('codigoSeguridad')
            ->add('codigoInmovilizador')
            ->add('colorInterno')
            ->add('colorExterno')
            ->add('kmIngreso')
            ->add('observacion')
//            ->add('creado')
//            ->add('actualizado')
//            ->add('creadoPor')
//            ->add('actualizadoPor')
            ->add('remito')
            ->add('cliente')
            ->add('tipoCompra')
            ->add('factura')
            ->add('patentamiento')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VehiculosBundle\Entity\Vehiculo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vehiculosbundle_vehiculo';
    }
}
