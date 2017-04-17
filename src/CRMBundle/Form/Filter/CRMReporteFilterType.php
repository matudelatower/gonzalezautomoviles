<?php

namespace CRMBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Form\EventListener\AddAnioCodigoVersionFieldSubscriber;

class CRMReporteFilterType extends AbstractType {

	private $em;

	public function __construct( $em = null ) {
		$this->em = $em;
	}

	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm( FormBuilderInterface $builder, array $options ) {

		$builder
			->add( 'vendedor',
				'jqueryautocomplete',
				array(
					'label'         => 'Vendedor (Por Apellido)',
					'class'         => 'PersonasBundle:Empleado',
					'search_method' => 'getEmpleadoByApellido',
					'required'      => false,
					'route_name'    => 'get_empleado_by_apellido'
				) )
			->add( 'rango',
				'text',
				array(
					'required' => false,
					'attr'     => array( 'class' => 'daterange' )
				) );
	}

	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions( OptionsResolver $resolver ) {
		$resolver->setDefaults( array(
			'csrf_protection' => false
		) );
	}

	/**
	 * @return string
	 */
	public function getName() {
		return 'crmbundle_reporte_filter';
	}

}
