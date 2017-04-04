<?php

namespace CRMBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncuestaPreguntaType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		
		$type = 'bootstrapcollection';
		if ( $options['edit'] ) {
			$type = 'collection';
		}
		
		$builder
			->add( 'pregunta' )
			->add( 'orden' )
			->add( 'cssClass')
			->add( 'encuestaTipoPregunta' )
			->add( 'ipc' )
//			->add( 'activo' )
			->add( 'opcionesRespuestas',
				$type,
				array(
					'type'           => new EncuestaOpcionRespuestaType(),
					'allow_add'      => true,
					'allow_delete'   => true,
					'by_reference'   => false,
					'prototype_name' => '__or__'
				) );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'CRMBundle\Entity\EncuestaPregunta',
			'edit'       => false
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'crmbundle_encuestapregunta';
	}
}
