<?php

namespace CRMBundle\Form\Model;

use Doctrine\ORM\EntityManager;

/**
 * Created by PhpStorm.
 * User: matias
 * Date: 6/10/15
 * Time: 5:07 PM
 */
class EncuestaParameter {
	protected $data;
	protected $calculables;
	protected $agrupador;

	/**
	 * @return mixed
	 */
	public function getAgrupador() {
		return $this->agrupador;
	}

	/**
	 * @param mixed $agrupador
	 */
	public function setAgrupador( $agrupador ) {
		$this->agrupador = $agrupador;
	}

	/**
	 * @return array
	 */
	public function getCalculables() {
		return $this->calculables;
	}

	/**
	 * @param array $calculables
	 */
	public function setCalculables( $calculables ) {
		$this->calculables = $calculables;
	}

	public function __construct( $parameters, EntityManager $entityManager, $edit = false, $extraParams = null ) {
		if ( $edit == false ) {

			foreach ( $parameters as $k => $value ) {

				$buildField = $this->buildField( $entityManager, $value );
				$name       = $buildField['name'];

				$this->{$name} = "";
			}
		} else {
			$resultadoCabecera = $entityManager->getRepository( 'CRMBundle:CuestionarioResultadoCabecera' )->findOneByVehiculo( $extraParams['vehiculo'] );
			foreach ( $parameters as $k => $value ) {

				$buildField = $this->buildField( $entityManager, $value );
				$name       = $buildField['name'];
				$widgetType = $buildField['widgetType'];


				$resultadoRespuesta = $entityManager->getRepository( 'CRMBundle:PreguntaResultadoRespuesta' )->getRespuesta(
					$value,
					$resultadoCabecera
				);

				$pValue = false;

				if ( count( $resultadoRespuesta ) > 0 ) {
					if ( $widgetType == 'choice' ) {
						$pValue = $resultadoRespuesta->getResultadoRespuesta()->getId();
					} elseif ( $widgetType == 'checkbox' ) {
						$pValue = $resultadoRespuesta[0]->getResultadoRespuesta()->getTextoRespuesta();
						if ( $pValue == '1' ) {
							$pValue = true;
						} else {
							$pValue = false;
						}
					}
				}

				$this->data[ $name ]['value'] = $pValue;
				$this->{$name}                = $pValue;

			}
		}
	}

	/**
	 * @param $entityManager
	 * @param $value es un objeto campo
	 *
	 * @return array con nombre de widget y el tipo
	 */
	private function buildField( $entityManager, $value ) {
		/* @var $value \CRMBundle\Entity\EncuestaPregunta */
		$name = $value->getId();

//        $this->agrupador[$name] = $value->getAgrupadorCampo()->first()->getAgrupador();

		$choice = null;
		$attr   = array();

		if ( $value->getEncuestaTipoPregunta() === null ) {
			$widgetType = 'text';
		} else {
			$widgetType = $value->getEncuestaTipoPregunta()->getWidgetType();
			if ( in_array( $value->getEncuestaTipoPregunta()->getWidgetType(), array( 'radio', 'select' ) )
			) {
				$widgetType = 'choice';
				$choice     = $value->getEncuestaTipoPregunta()->getWidgetType();
				if ( $choice == 'radio' ) {
					$attr = array(
						'label_attr' => array(
							'class' => 'radio-inline'
						)
					);
				}
			}

		}

		$this->data[ $name ] = array(
			"type"     => $widgetType,
			"label"    => $value->getPregunta(),
			"value"    => false,
			"required" => false,
			$attr

//            "required" => $value->getRequerido() ? true : false,
		);

		if ( $widgetType == 'choice' ) {
			foreach ( $value->getOpcionesRespuestas()->toArray() as $opcion ) {
				$this->data[ $name ]['choices'][ $opcion->getId() ] = $opcion->getTextoOpcion();
			}

			$this->data[ $name ]['expanded'] = true;
			$this->data[ $name ]['multiple'] = false;

			if ( $choice == 'radio' ) {
				$this->data[ $name ]['expanded'] = true;
				$this->data[ $name ]['multiple'] = false;
			} elseif ( $choice == 'select' ) {
				$this->data[ $name ]['expanded'] = false;
				$this->data[ $name ]['multiple'] = false;
			}

		}
//                si es campo fecha
		if ( $widgetType == 'date' ) {
			$this->data[ $name ]['widget'] = $value->getTipoCampo()->getSymfonyType()->getWidget();
			$this->data[ $name ]['input']  = $value->getTipoCampo()->getSymfonyType()->getInput();
			$this->data[ $name ]['format'] = $value->getTipoCampo()->getSymfonyType()->getFormat();
			$this->data[ $name ]['attr']   = $value->getTipoCampo()->getSymfonyType()->getAttr();

		}

		$this->data[ $name ]['attr'] = array();
//        if ($value->getFuncionNombre()) {
//            $this->calculables[$value->getId()] = array(
//                'nombreFuncion' => $value->getFuncionNombre(),
//                'evento' => $value->getEvento()->getSlug(),
//                'textoAyuda' => $value->getDescripcion(),
//            );
//        }

		return array(
			'name'       => $name,
			'widgetType' => $widgetType
		);
	}

	public function get() {
		return $this->data;
	}
}