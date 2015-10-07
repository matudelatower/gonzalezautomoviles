<?php

namespace CuestionariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPreguntasCategoriasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'preguntas',
                'bootstrapcollection',
                array(
                    'type' => new PreguntaACategoriaType(),
                    'allow_add' => true,
//                    'allow_delete' => true,
                    'by_reference' => true,
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CuestionariosBundle\Entity\CuestionarioCategoria'
            )
        );
    }

    public function getName()
    {
        return 'cuestionarios_bundle_add_preguntas_categorias_type';
    }
}
