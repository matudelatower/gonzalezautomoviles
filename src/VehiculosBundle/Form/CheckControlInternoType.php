<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Entity\DanioVehiculo;

class CheckControlInternoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tarjetaInfocard')
            ->add('manualUsuario')
            ->add('encendedor')
            ->add('alfombras')
            ->add('kitSeguridad')
            ->add('ruedaAuxilio')
            ->add('radio')
            ->add('llaveRuedas')
            ->add('controlAlarma')
            ->add('manualRadio')
            ->add('gato')
            ->add('antena')
            ->add('llave')
            ->add('personaEntrego')
            ->add('vehiculo')
            ->add(
                'danioVehiculo',
                'bootstrapcollection',
                array(
                    'type' => new DanioVehiculoType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'mapped' => false
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'VehiculosBundle\Entity\CheckControlInterno'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vehiculosbundle_checkcontrolinterno';
    }
}
