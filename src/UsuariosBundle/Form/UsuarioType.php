<?php

namespace UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                'text',
                array(
                    'label' => 'form.username',
                    'translation_domain' => 'FOSUserBundle',
                )
            )
            ->add(
                'email',
                'email',
                array(
                    'label' => 'form.email',
                    'translation_domain' => 'FOSUserBundle',
                )
            )
            ->add(
                'plain_password',
                'password',
                array(
                    'label' => 'form.password',
                    'translation_domain' => 'FOSUserBundle',
                )
            )
            ->add(
                'enabled',
                'checkbox',
                array(
                    'label' => 'Activo',
                    'value' => false,
                )
            )
            ->add(
                'grupos',
                'bootstrapcollection',
                array(
                    'type' => new UsuarioGrupoType(),
                    'by_reference' => true,
                    'allow_delete' => true,
                    'allow_add' => true,
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
                'data_class' => 'UsuariosBundle\Entity\Usuario'
            )
        );
    }

//    public function getParent(){
//        return 'fos_user_profile';
//    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'usuariosbundle_usuario';
    }
}
