<?php

namespace PersonasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'nombre' )
			->add( 'apellido' )
			->add( 'tipoDocumento' )
			->add( 'numeroDocumento' )
			->add( 'telefono' )
			->add( 'celular' )
			->add( 'mail' )
			->add( 'web' )
			->add( 'fechaNacimiento',
				'date',
				array(
					'widget' => 'single_text',
					'format' => 'dd-MM-yyyy',
					'attr'   => array(
						'class' => 'datepicker',
					),
//                'required'=>false

				) )
			->add( 'calle' )
			->add( 'numeroCalle' )
			->add( 'barrio' );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'PersonasBundle\Entity\Persona'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'personasbundle_persona';
	}
}
