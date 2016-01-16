<?php

namespace PersonasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpleadoType extends AbstractType {

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'empleadoCategoria',
				'bootstrapcollection',
				array(
					'type'         => new EmpleadoCategoriaType(),
					'allow_add'    => true,
					'allow_delete' => true,
					'by_reference' => true,
				) );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'PersonasBundle\Entity\Empleado'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'personasbundle_empleado';
	}

}
