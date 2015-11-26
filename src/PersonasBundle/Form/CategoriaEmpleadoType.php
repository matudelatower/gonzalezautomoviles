<?php

namespace PersonasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriaEmpleadoType extends AbstractType
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
            'data_class' => 'PersonasBundle\Entity\CategoriaEmpleado'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'personasbundle_categoriaempleado';
    }
}
