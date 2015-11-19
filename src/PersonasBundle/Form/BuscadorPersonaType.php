<?php

namespace PersonasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BuscadorPersonaType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'tipoDocumento',
				'entity',
				array(
					'class' => 'PersonasBundle\Entity\TipoDocumento',
//					'required'=>false,
				) )
			->add( 'numeroDocumento',
				'text',
				array(
					'required' => true
				) );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'csrf_protection' => false,
//			'required'        => false
		) );
	}

	public function getName() {
		return 'personas_bundle_buscador_persona_type';
	}
}
