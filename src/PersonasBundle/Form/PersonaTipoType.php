<?php

namespace PersonasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaTipoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creado')
            ->add('actualizado')
            ->add('creadoPor')
            ->add('actualizadoPor')
            ->add('persona')
            ->add('cliente')
            ->add('empleado')
            ->add('sucursal')
            ->add('usuario')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PersonasBundle\Entity\PersonaTipo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'personasbundle_personatipo';
    }
}
