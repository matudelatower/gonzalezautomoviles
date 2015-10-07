<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DanioVehiculo
 *
 * @ORM\Table(name="danios_vehiculo")
 * @ORM\Entity
 */
class DanioVehiculo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_orden_arreglo", type="string", length=255)
     */
    private $numeroOrdenArreglo;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;


    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Vehiculo")
     * @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id")
     */
    private $vehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\TipoDanio")
     * @ORM\JoinColumn(name="tipo_danio_id", referencedColumnName="id")
     */
    private $tipoDanio;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return DanioVehiculo
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set numeroOrdenArreglo
     *
     * @param string $numeroOrdenArreglo
     *
     * @return DanioVehiculo
     */
    public function setNumeroOrdenArreglo($numeroOrdenArreglo)
    {
        $this->numeroOrdenArreglo = $numeroOrdenArreglo;

        return $this;
    }

    /**
     * Get numeroOrdenArreglo
     *
     * @return string
     */
    public function getNumeroOrdenArreglo()
    {
        return $this->numeroOrdenArreglo;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return DanioVehiculo
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set vehiculo
     *
     * @param \VehiculosBundle\Entity\Vehiculo $vehiculo
     *
     * @return DanioVehiculo
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
     * Set tipoDanio
     *
     * @param \VehiculosBundle\Entity\TipoDanio $tipoDanio
     *
     * @return DanioVehiculo
     */
    public function setTipoDanio(\VehiculosBundle\Entity\TipoDanio $tipoDanio = null)
    {
        $this->tipoDanio = $tipoDanio;

        return $this;
    }

    /**
     * Get tipoDanio
     *
     * @return \VehiculosBundle\Entity\TipoDanio
     */
    public function getTipoDanio()
    {
        return $this->tipoDanio;
    }
}
