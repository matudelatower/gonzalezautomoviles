<?php

namespace UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermisoEspecialGrupoType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'permisoEspecial',
				'jqueryautocomplete',
				array(
					'class'         => 'UsuariosBundle:PermisoEspecial',
					'search_method' => 'getByLike',
					'property' => 'descripcion',
					'required'      => true,
				) );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'UsuariosBundle\Entity\PermisoEspecialGrupo'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'usuariosbundle_permisoespecialgrupo';
	}
}
