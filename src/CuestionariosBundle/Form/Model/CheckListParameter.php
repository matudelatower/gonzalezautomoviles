<?php
namespace CuestionariosBundle\Form\Model;

use Doctrine\ORM\EntityManager;

/**
 * Created by PhpStorm.
 * User: matias
 * Date: 6/10/15
 * Time: 5:07 PM
 */
class CheckListParameter {
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

	public function __construct( $parameters, EntityManager $entityManager, $edit = false, $extraParams ) {
		if ( $edit == false ) {

			foreach ( $parameters as $k => $value ) {

				$buildField = $this->buildField( $entityManager, $value );
				$name       = $buildField['name'];

				$this->{$name} = "";
			}
		} else {
			$resultadoCabecera = $entityManager->getRepository( 'CuestionariosBundle:CuestionarioResultadoCabecera' )->findOneByVehiculo( $extraParams['vehiculo'] );
			foreach ( $parameters as $k => $value ) {

				$buildField = $this->buildField( $entityManager, $value );
				$name       = $buildField['name'];
				$widgetType = $buildField['widgetType'];


				$resultadoRespuesta = $entityManager->getRepository( 'CuestionariosBundle:PreguntaResultadoRespuesta' )->getRespuesta(
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
		/* @var $value \CuestionariosBundle\Entity\CuestionarioPregunta */
		$name = $value->getId();

//        $this->agrupador[$name] = $value->getAgrupadorCampo()->first()->getAgrupador();


		if ( $value->getTipoPregunta() === null ) {
			$widgetType = 'text';
		} else {
			$widgetType = $value->getTipoPregunta()->getWidgetType();
		}

		$this->data[ $name ] = array(
			"type"     => $widgetType,
			"label"    => $value->getTextoPregunta(),
			"value"    => false,
			"required" => false,
//            "required" => $value->getRequerido() ? true : false,
		);

//        if ($value->getFuenteDatos()) {
//            $class = $value->getFuenteDatos()->getBundle().":".$value->getFuenteDatos()->getClass();
//            $method = $value->getFuenteDatos()->getMetodo();
//            $property = $value->getFuenteDatos()->getPropiedad();
//            if ($widgetType == 'choice') {
//                $entities = $entityManager->getRepository($class)->$method('%%');
//                foreach ($entities as $entity) {
//                    $this->data[$name]['choices'][$entity['id']] = $entity[$property];
//                }
//            }
//            $this->data[$name]['property'] = $property;
//            $this->data[$name]['class'] = $class;
//
//
//        }

//        if ($widgetType == 'checkbox') {
//
//            $this->data[$name]['expanded'] = $value->getTipoCampo()->getSymfonyType()->getExpanded();
//
//
//        }

		if ( $widgetType == 'choice' ) {
			foreach ( $value->getOpcionesCampo()->toArray() as $opcion ) {
				$this->data[ $name ]['choices'][ $opcion->getId() ] = $opcion->getDescripcion();
			}
			$this->data[ $name ]['expanded'] = $value->getTipoCampo()->getSymfonyType()->getExpanded();
			$this->data[ $name ]['multiple'] = $value->getTipoCampo()->getSymfonyType()->getMultiple();

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