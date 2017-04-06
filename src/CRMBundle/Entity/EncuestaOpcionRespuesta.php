<?php

namespace CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use UtilBundle\Entity\Base\BaseClass;

/**
 * EncuestaOpcionRespuesta
 *
 * @ORM\Table(name="crm_encuesta_opciones_respuestas")
 * @ORM\Entity
 */
class EncuestaOpcionRespuesta extends BaseClass {

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="texto_opcion", type="string", length=255)
	 */
	private $textoOpcion;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="orden", type="integer", nullable=true)
	 */
	private $orden;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="valor_literal", type="string", length=255, nullable=true)
	 */
	private $valorLiteral;

	/**
	 * @ORM\ManyToOne(targetEntity="CRMBundle\Entity\EncuestaPregunta" ,inversedBy="opcionesRespuestas")
	 * @ORM\JoinColumn(name="encuesta_pregunta_id", referencedColumnName="id")
	 */
	private $encuestaPregunta;

	public function __toString() {
		return $this->textoOpcion;
	}


	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set textoOpcion
	 *
	 * @param string $textoOpcion
	 *
	 * @return EncuestaOpcionRespuesta
	 */
	public function setTextoOpcion( $textoOpcion ) {
		$this->textoOpcion = $textoOpcion;

		return $this;
	}

	/**
	 * Get textoOpcion
	 *
	 * @return string
	 */
	public function getTextoOpcion() {
		return $this->textoOpcion;
	}

	/**
	 * Set orden
	 *
	 * @param integer $orden
	 *
	 * @return EncuestaOpcionRespuesta
	 */
	public function setOrden( $orden ) {
		$this->orden = $orden;

		return $this;
	}

	/**
	 * Get orden
	 *
	 * @return integer
	 */
	public function getOrden() {
		return $this->orden;
	}

	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return EncuestaOpcionRespuesta
	 */
	public function setFechaCreacion( $fechaCreacion ) {
		$this->fechaCreacion = $fechaCreacion;

		return $this;
	}

	/**
	 * Set fechaActualizacion
	 *
	 * @param \DateTime $fechaActualizacion
	 *
	 * @return EncuestaOpcionRespuesta
	 */
	public function setFechaActualizacion( $fechaActualizacion ) {
		$this->fechaActualizacion = $fechaActualizacion;

		return $this;
	}

	/**
	 * Set encuestaPregunta
	 *
	 * @param \CRMBundle\Entity\EncuestaPregunta $encuestaPregunta
	 *
	 * @return EncuestaOpcionRespuesta
	 */
	public function setEncuestaPregunta( \CRMBundle\Entity\EncuestaPregunta $encuestaPregunta = null ) {
		$this->encuestaPregunta = $encuestaPregunta;

		return $this;
	}

	/**
	 * Get encuestaPregunta
	 *
	 * @return \CRMBundle\Entity\EncuestaPregunta
	 */
	public function getEncuestaPregunta() {
		return $this->encuestaPregunta;
	}

	/**
	 * Set creadoPor
	 *
	 * @param \UsuariosBundle\Entity\Usuario $creadoPor
	 *
	 * @return EncuestaOpcionRespuesta
	 */
	public function setCreadoPor( \UsuariosBundle\Entity\Usuario $creadoPor = null ) {
		$this->creadoPor = $creadoPor;

		return $this;
	}

	/**
	 * Set actualizadoPor
	 *
	 * @param \UsuariosBundle\Entity\Usuario $actualizadoPor
	 *
	 * @return EncuestaOpcionRespuesta
	 */
	public function setActualizadoPor( \UsuariosBundle\Entity\Usuario $actualizadoPor = null ) {
		$this->actualizadoPor = $actualizadoPor;

		return $this;
	}

	/**
	 * Set valorLiteral
	 *
	 * @param string $valorLiteral
	 *
	 * @return EncuestaOpcionRespuesta
	 */
	public function setValorLiteral( $valorLiteral ) {
		$this->valorLiteral = $valorLiteral;

		return $this;
	}

	/**
	 * Get valorLiteral
	 *
	 * @return string
	 */
	public function getValorLiteral() {
		return $this->valorLiteral;
	}
}
