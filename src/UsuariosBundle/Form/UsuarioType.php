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
                'plain_password', 'repeated',
                array(
                    'type' => 'password',
                    'invalid_message' => 'Las Contraseñas no coinciden',
                    'required' => false,
                    'translation_domain'=>'FOSUserBundle',
                    'first_options'  => array('label' => 'Nueva Contraseña'),
                    'second_options' => array('label' => 'Confirmar nueva Contraseña')
                )

            )
            ->add(
                'enabled',
                'checkbox',
                array(
                    'label' => 'Activo',
                    'value' => false,
                    'required'=>false,
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
