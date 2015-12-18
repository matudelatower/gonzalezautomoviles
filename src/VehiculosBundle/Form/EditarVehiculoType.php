<?php

namespace VehiculosBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditarVehiculoType extends AbstractType {
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'documento' )
			->add( 'vin' )
			->add( 'chasis' )
			->add( 'modelo',
				'entity',
				array(
					'class'         => 'VehiculosBundle:CodigoModelo',
					'attr'          => array(
						'class' => 'select2'
					),
					'query_builder' => function ( EntityRepository $er ) {
						return $er->createQueryBuilder( 'cm' )
						          ->where( 'cm.activo = true' );
					},
				)
			)
			->add( 'colorExterno' )
			->add( 'motor' )
			->add( 'importe' )
			->add( 'impuestos' )
			->add( 'numeroPedido' )
			->add( 'tipoVentaEspecial' )
			->add( 'numeroGrupo',
				'text',
				array(
					'label_attr' => array( 'class' => 'hidden tipo-venta-especial-field' ),
					'attr'       => array( 'class' => 'hidden tipo-venta-especial-field' )
				) )
			->add( 'numeroOrden',
				'text',
				array(
					'label_attr' => array( 'class' => 'hidden tipo-venta-especial-field' ),
					'attr'       => array( 'class' => 'hidden tipo-venta-especial-field' )
				) )
			->add( 'numeroSolicitud',
				'text',
				array(
					'label_attr' => array( 'class' => 'hidden tipo-venta-especial-field' ),
					'attr'       => array( 'class' => 'hidden tipo-venta-especial-field' )
				) )
			->add( 'cliente',
				'jqueryautocomplete',
				array(
					'class'         => 'ClientesBundle:Cliente',
//					'choice_label'      => 'nombreCompleto',
					'search_method' => 'getClienteByDni',
					'required'      => false,
					'route_name'    => 'get_cliente_by_dni',
//					'route_name'    => "buscarPersonaConDominio",
//					'class'         => 'PersonaBundle:Persona',
//					'property'      => 'nombreCompleto',
//					'search_method' => 'getEmpadronadoresPorSector',
					'label_attr'    => array( 'class' => 'hidden tipo-venta-especial-field' ),
					'attr'          => array( 'class' => 'hidden tipo-venta-especial-field' )
				) )
			->add( 'remito', new RemitoType() )
			->add( 'codigoLlave' )
			->add( 'codigoRadio' )
			->add( 'kmIngreso' )
			->add( 'codigoSeguridad' )
			->add( 'transportista' )
			->add( 'danioVehiculoGm',
				'bootstrapcollection',
				array(
					'type'           => new DanioVehiculoGmType(),
					'allow_add'      => true,
					'allow_delete'   => true,
					'prototype_name' => '__daniovehiculo__',
				) );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'data_class' => 'VehiculosBundle\Entity\Vehiculo'
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'vehiculosbundle_alta_vehiculo';
	}
}
