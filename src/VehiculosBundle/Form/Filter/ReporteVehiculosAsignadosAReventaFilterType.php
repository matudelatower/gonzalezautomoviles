<?php

namespace VehiculosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReporteVehiculosAsignadosAReventaFilterType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {
		$builder
			->add( 'reventa',
				'jqueryautocomplete',
				array(
					'class'         => 'ClientesBundle:Cliente',
					'search_method' => 'getClienteReventaByDni',
					'required'      => false,
					'route_name'    => 'get_cliente_by_dni',
					'attr'          => array( 'placeholder' => 'Ingrese DNI o CUIT' ),
				) )
			->add( 'facturado',
				'choice',
				array(
					'required' => false,
					'choices'  => array(
						1 => 'SI',
						2 => 'NO',
					)
				) )
			->add( 'diaInicio',
				'integer',
				array(
					'required' => false,
					'attr'     => array(
						'class'     => 'bfh-number',
						'min'       => '0',
						'step'      => '1',
						'data-bind' => 'value:replyNumber'
					)
				) )
			->add( 'diaFin',
				'integer',
				array(
					'required' => false,
					'attr'     => array(
						'class'     => 'bfh-number',
						'min'       => '0',
						'step'      => '1',
						'data-bind' => 'value:replyNumber'
					)
				) );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'csrf_protection' => false
		) );
	}

	public function getName() {
		return 'vehiculos_bundle_reporte_vehiculos_asignados_areventa_filter_type';
	}
}
