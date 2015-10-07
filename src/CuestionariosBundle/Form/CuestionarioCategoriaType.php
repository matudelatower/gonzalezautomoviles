<?php

namespace CuestionariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuestionarioCategoriaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cuestionario')
            ->add('nombre')
            ->add('descripcion')
            ->add('codigo')
            ->add('slug')
            ->add('activo')
            ->add('orden')

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CuestionariosBundle\Entity\CuestionarioCategoria'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cuestionariosbundle_cuestionariocategoria';
    }
}
