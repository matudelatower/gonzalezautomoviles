<?php

namespace VehiculosBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReporteAgendaEntregasFilterType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ) {

		$builder->add( 'rango',
			'text',
			array(
				'attr' => array( 'class' => 'daterange' )
			) );
//		        ->add( 'vendedor',
//			        'jqueryautocomplete',
//			        array(
//				        'label'         => 'Vendedor (Por Apellido)',
//				        'class'         => 'PersonasBundle:Empleado',
////					'property'      => 'nombreCompleto',
//				        'search_method' => 'getEmpleadoByApellido',
//				        'required'      => false,
//				        'route_name'    => 'get_empleado_by_apellido'
//			        ) );
	}

	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'csrf_protection' => false
		) );
	}

	public function getName() {
		return 'vehiculos_bundle_reporte_agenda_entregas_filter_type';
	}
}
