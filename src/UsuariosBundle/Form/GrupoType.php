<?php

namespace UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GrupoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'roles',
            'choice',
            array(
                'choices' => array(
                    'ROLE_ADMIN' => 'Administrador',
                    'ROLE_ADMINISTRACION' => 'Administracion',
                    'ROLE_VENTA' => 'Venta',
                    'ROLE_GERENCIA' => 'Gerencia',
                ),
                'multiple' => true,
            )
        )
            ->add(
                'permisoAplicacion',
                'bootstrapcollection',
                array(
                    'type' => new PermisoAplicacionType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => true,
                )
            )
            ->add(
                'permisoEspecialGrupo',
                'bootstrapcollection',
                array(
                    'type' => new PermisoEspecialGrupoType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => true,
                )
            )

        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'UsuariosBundle\Entity\Grupo'
            )
        );
    }

    public function getParent()
    {
        return 'fos_user_group';
    }

    public function getName()
    {
        return 'usuarios_bundle_grupo_type';
    }
}
