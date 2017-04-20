<?php

namespace CRMBundle\Form\Filter;

use Doctrine\ORM\EntityRepository;
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
			->add( 'cliente',
				'jqueryautocomplete',
				array(
					'label'         => 'Cliente (Por Apellido)',
					'class'         => 'ClientesBundle:Cliente',
					'search_method' => 'getClienteByApellido',
					'required'      => false,
					'route_name'    => 'get_cliente_by_apellido',
				) )
			->add( 'rango',
				'text',
				array(
					'required' => false,
					'attr'     => array( 'class' => 'daterange' )
				) )
			->add( 'tipoVenta',
				'entity',
				array(
					'class'         => 'VehiculosBundle:TipoVentaEspecial',
					'choice_label'  => 'nombre',
					'required'      => false,
					'query_builder' => function ( EntityRepository $er ) {

						$slugArray = array( 'venta-especial-propia', 'convencional', 'plan-de-ahorro-propio' );

						return $er->createQueryBuilder( 'tv' )
						          ->where( 'tv.slug in (:slugs)' )
						          ->setParameter( 'slugs', array_values($slugArray) )
							;
					}
				) )
		;
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
