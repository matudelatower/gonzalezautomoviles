<?php

namespace CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use UtilBundle\Entity\Base\BaseClass;

/**
 * Encuesta
 *
 * @ORM\Table(name="crm_encuestas")
 * @ORM\Entity(repositoryClass="CRMBundle\Repository\EncuestaRepository")
 */
class Encuesta extends BaseClass {
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
	 * @ORM\Column(name="nombre", type="string", length=255)
	 */
	private $nombre;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="descripcion", type="string", length=255)
	 */
	private $descripcion;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="slug", type="string", length=255)
	 * @Gedmo\Slug(fields={"nombre"})
	 */
	private $slug;

	/**
	 * @ORM\OneToMany(targetEntity="CRMBundle\Entity\EncuestaPregunta", mappedBy="encuesta", cascade={"persist", "remove"})
	 * @ORM\OrderBy({"orden"= "ASC"})
	 *
	 */
	private $preguntas;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="texto_encuesta", type="text", nullable=true)
	 */
	private $textoEncuesta;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="texto_cierre", type="text", nullable=true)
	 */
	private $textoCierre;

	public function __toString() {
		return $this->slug;
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
	 * Set nombre
	 *
	 * @param string $nombre
	 *
	 * @return Encuesta
	 */
	public function setNombre( $nombre ) {
		$this->nombre = $nombre;

		return $this;
	}

	/**
	 * Get nombre
	 *
	 * @return string
	 */
	public function getNombre() {
		return $this->nombre;
	}

	/**
	 * Set descripcion
	 *
	 * @param string $descripcion
	 *
	 * @return Encuesta
	 */
	public function setDescripcion( $descripcion ) {
		$this->descripcion = $descripcion;

		return $this;
	}

	/**
	 * Get descripcion
	 *
	 * @return string
	 */
	public function getDescripcion() {
		return $this->descripcion;
	}

	/**
	 * Set slug
	 *
	 * @param string $slug
	 *
	 * @return Encuesta
	 */
	public function setSlug( $slug ) {
		$this->slug = $slug;

		return $this;
	}

	/**
	 * Get slug
	 *
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}

	/**
	 * Set fechaCreacion
	 *
	 * @param \DateTime $fechaCreacion
	 *
	 * @return Encuesta
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
	 * @return Encuesta
	 */
	public function setFechaActualizacion( $fechaActualizacion ) {
		$this->fechaActualizacion = $fechaActualizacion;

		return $this;
	}

	/**
	 * Set creadoPor
	 *
	 * @param \UsuariosBundle\Entity\Usuario $creadoPor
	 *
	 * @return Encuesta
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
	 * @return Encuesta
	 */
	public function setActualizadoPor( \UsuariosBundle\Entity\Usuario $actualizadoPor = null ) {
		$this->actualizadoPor = $actualizadoPor;

		return $this;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Add pregunta
	 *
	 * @param \CRMBundle\Entity\EncuestaPregunta $pregunta
	 *
	 * @return Encuesta
	 */
	public function addPregunta( \CRMBundle\Entity\EncuestaPregunta $pregunta ) {
		$pregunta->setEncuesta( $this );
		$this->preguntas->add( $pregunta );

		return $this;
	}

	/**
	 * Remove pregunta
	 *
	 * @param \CRMBundle\Entity\EncuestaPregunta $pregunta
	 */
	public function removePregunta( \CRMBundle\Entity\EncuestaPregunta $pregunta ) {
		$this->preguntas->removeElement( $pregunta );
	}

	/**
	 * Get preguntas
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getPreguntas() {
		return $this->preguntas;
	}


    /**
     * Set textoEncuesta
     *
     * @param string $textoEncuesta
     *
     * @return Encuesta
     */
    public function setTextoEncuesta($textoEncuesta)
    {
        $this->textoEncuesta = $textoEncuesta;

        return $this;
    }

    /**
     * Get textoEncuesta
     *
     * @return string
     */
    public function getTextoEncuesta()
    {
        return $this->textoEncuesta;
    }

    /**
     * Set textoCierre
     *
     * @param string $textoCierre
     *
     * @return Encuesta
     */
    public function setTextoCierre($textoCierre)
    {
        $this->textoCierre = $textoCierre;

        return $this;
    }

    /**
     * Get textoCierre
     *
     * @return string
     */
    public function getTextoCierre()
    {
        return $this->textoCierre;
    }
}
