<?php

namespace CuestionariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CuestionarioPreguntaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('textoPregunta')
            ->add('activo')
            ->add('orden')
            ->add('categoria')
            ->add('tipoPregunta')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CuestionariosBundle\Entity\CuestionarioPregunta'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cuestionariosbundle_cuestionariopregunta';
    }
}
