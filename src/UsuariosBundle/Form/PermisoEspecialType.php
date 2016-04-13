<?php

namespace UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PermisoEspecialType extends AbstractType {

	private $appManager;

	public function __construct( $appManager ) {
		$this->appManager = $appManager;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {

		$controllers = $this->appManager->getControllers();

		$choices = array();
		foreach ( $controllers as $key => $controller ) {
			$pos = strrpos( $key, "\\" );
			$id  = $pos === false ? $key : substr( $key, $pos + 1 );
			foreach ( $controller as $item ) {
				$choices[ $id . ':' . $item ] = $id . ':' . $item;
			}

		}

		$builder
			->add( 'descripcion' )
			->add( 'controller',
				'choice',
				array(
					'choices' => $choices,
					'attr'    => array( 'class' => 'select2' )
				) )
			->add( 'slug' );

		// ...
		$builder->addEventListener( FormEvents::PRE_SET_DATA,
			function ( FormEvent $event ) use ( $choices ) {
				$data = $event->getData();
				$form = $event->getForm();

				if ( null !== $data->getId() ) {
					$selected = $data->getController() . ':' . $data->getAction();
					$form->add( 'controller',
						'choice',
						array(
							'data'    => $selected,
							'choices' => $choices,
							'attr'    => array( 'class' => 'select2' )
						) );
				}
			} );

	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'UsuariosBundle\Entity\PermisoEspecial'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'usuariosbundle_permisoespecial';
	}
}
