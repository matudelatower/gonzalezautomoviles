<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CodigoModeloType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('anio')
            ->add('codigo')
            ->add('version')
            ->add('nombreModelo')
            ->add('activo')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VehiculosBundle\Entity\CodigoModelo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vehiculosbundle_codigomodelo';
    }
}
