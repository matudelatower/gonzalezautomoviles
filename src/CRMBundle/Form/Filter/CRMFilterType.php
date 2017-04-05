<?php

namespace CRMBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use VehiculosBundle\Form\EventListener\AddAnioCodigoVersionFieldSubscriber;

class CRMFilterType extends AbstractType {

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
			->add( 'modelo',
				'entity',
				array(
					'class'        => 'VehiculosBundle:NombreModelo',
					'choice_label' => 'nombre',
					'required'     => false,
					'attr'         => array( 'class' => 'modelo' ),
				) )
			->add( 'tipoVentaEspecial',
				'entity',
				array(
					'class'        => 'VehiculosBundle:TipoVentaEspecial',
					'choice_label' => 'nombre',
					'required'     => false,
				) )
			->add( 'rango',
				'text',
				array(
					'required' => false,
					'attr'     => array( 'class' => 'daterange' )
				) )
			->add( 'numeroDocumento',
				'text',
				array(
					'required' => false
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
			->add( 'vendedor',
				'jqueryautocomplete',
				array(
					'label'         => 'Vendedor (Por Apellido)',
					'class'         => 'PersonasBundle:Empleado',
					'search_method' => 'getEmpleadoByApellido',
					'required'      => true,
					'route_name'    => 'get_empleado_by_apellido'
				) )
			->add( 'registrosPaginador',
				'choice',
				array(
					'data'    => '10',
					'choices' => array(
						'5'   => '5',
						'10'  => '10',
						'20'  => '20',
						'30'  => '30',
						'40'  => '40',
						'50'  => '50',
						'60'  => '60',
						'70'  => '70',
						'80'  => '80',
						'90'  => '90',
						'100' => '100',
					),
					"attr"    => array( "onchange" => 'document.form_listado.submit()' )
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
		return 'crmbundle_vehiculo_filter';
	}

}
