<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TipoCompraType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('descripcion')
//            ->add('creado')
//            ->add('actualizado')
//            ->add('creadoPor')
//            ->add('actualizadoPor')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VehiculosBundle\Entity\TipoCompra'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'vehiculosbundle_tipocompra';
    }
}
