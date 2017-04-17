<?php

namespace CRMBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncuestaType extends AbstractType {
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
			->add( 'nombre' )
			->add( 'descripcion' )
			->add( 'textoEncuesta' )
			->add( 'activo' )
			->add( 'preguntas',
				$type,
				array(
					'type'           => new EncuestaPreguntaType(),
					'allow_add'      => true,
					'by_reference'   => false,
					'prototype_name' => '__ep__',
					'options'  => array(
						'edit' => $options['edit'],
					),
				) );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'CRMBundle\Entity\Encuesta',
			'edit'       => false
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'crmbundle_encuesta';
	}
}
