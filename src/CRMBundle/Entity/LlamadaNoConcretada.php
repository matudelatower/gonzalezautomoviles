<?php

namespace CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UtilBundle\Entity\Base\BaseClass;

/**
 * LlamadaNoConcretada
 *
 * @ORM\Table(name="crm_llamadas_no_concretadas")
 * @ORM\Entity
 */
class LlamadaNoConcretada extends BaseClass {
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
	 * @ORM\Column(name="motivo", type="text")
	 */
	private $motivo;

	/**
	 * @ORM\ManyToOne(targetEntity="CRMBundle\Entity\Encuesta")
	 * @ORM\JoinColumn(name="encuesta_id", referencedColumnName="id")
	 */
	private $encuesta;

	/**
	 * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Vehiculo")
	 * @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id")
	 */
	private $vehiculo;


	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set motivo
	 *
	 * @param string $motivo
	 *
	 * @return LlamadaNoConcretada
	 */
	public function setMotivo( $motivo ) {
		$this->motivo = $motivo;

		return $this;
	}

	/**
	 * Get motivo
	 *
	 * @return string
	 */
	public function getMotivo() {
		return $this->motivo;
	}

    /**
     * Set encuesta
     *
     * @param \CRMBundle\Entity\Encuesta $encuesta
     *
     * @return LlamadaNoConcretada
     */
    public function setEncuesta(\CRMBundle\Entity\Encuesta $encuesta = null)
    {
        $this->encuesta = $encuesta;

        return $this;
    }

    /**
     * Get encuesta
     *
     * @return \CRMBundle\Entity\Encuesta
     */
    public function getEncuesta()
    {
        return $this->encuesta;
    }

    /**
     * Set vehiculo
     *
     * @param \VehiculosBundle\Entity\Vehiculo $vehiculo
     *
     * @return LlamadaNoConcretada
     */
    public function setVehiculo(\VehiculosBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \VehiculosBundle\Entity\Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return LlamadaNoConcretada
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     *
     * @return LlamadaNoConcretada
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return LlamadaNoConcretada
     */
    public function setCreadoPor(\UsuariosBundle\Entity\Usuario $creadoPor = null)
    {
        $this->creadoPor = $creadoPor;

        return $this;
    }

    /**
     * Set actualizadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $actualizadoPor
     *
     * @return LlamadaNoConcretada
     */
    public function setActualizadoPor(\UsuariosBundle\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }
}
