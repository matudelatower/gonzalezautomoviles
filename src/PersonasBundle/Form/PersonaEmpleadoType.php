<?php

namespace PersonasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UsuariosBundle\Form\UsuarioType;

class PersonaEmpleadoType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add('persona', new PersonaType())
			->add('empleado', new EmpleadoType())
			->add('usuario', new UsuarioType())
		;

	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'PersonasBundle\Entity\PersonaTipo'
		) );
	}


//	public function getParent() {
//		return 'personasbundle_persona';
//	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'personasbundle_persona_empleado';
	}
}
