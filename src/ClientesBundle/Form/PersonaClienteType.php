<?php

namespace ClientesBundle\Form;

use ClientesBundle\Entity\Cliente;
use PersonasBundle\Form\PersonaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaClienteType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'persona', new PersonaType() )
			->add( 'cliente', new ClienteType() );

	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'PersonasBundle\Entity\PersonaTipo'
		) );
	}

	public function getName() {
		return 'clientes_bundle_persona_cliente_type';
	}
}
