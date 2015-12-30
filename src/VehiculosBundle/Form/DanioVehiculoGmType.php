<?php

namespace VehiculosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DanioVehiculoGmType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
//            ->add('numeroOrdenArreglo')
//            ->add('solucionado')
//            ->add('vehiculo')
			->add( 'tipoDanio',
				'jqueryautocomplete',
				array(
					'class'         => 'VehiculosBundle:TipoDanioGm',
					'property'      => 'descripcion',
					'search_method' => 'getByLike',
//                'required'      => true,
//                'route_name'    => 'get_cliente_by_dni'
				) )
			->add( 'codigoDanio',
				'jqueryautocomplete',
				array(
					'class'         => 'VehiculosBundle:CodigoDanioGm',
					'property'      => 'descripcion',
					'search_method' => 'getByLike',
//                'required'      => true,
//                'route_name'    => 'get_cliente_by_dni'
				) )
			->add( 'gravedadDanio' )
//			->add( 'fotoDanio', new FotoDanioGmType() )

			->add( 'fotoDanio',
				'collection',
				array(
					'type'           => new FotoDanioGmType(),
					'allow_add'      => true,
					'allow_delete'   => true,
					'prototype_name' => '__foto__'
				) )
			->add( 'tipoEstadoDanioGm' );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'VehiculosBundle\Entity\DanioVehiculoGm'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'vehiculosbundle_daniovehiculogm';
	}
}
