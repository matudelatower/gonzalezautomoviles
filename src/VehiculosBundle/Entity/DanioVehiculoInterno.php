<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * DanioVehiculoInterno
 *
 * @ORM\Table(name="danios_vehiculos_interno")
 * @ORM\Entity
 */
class DanioVehiculoInterno {

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
     * @ORM\Column(name="numero_orden_arreglo", type="string", length=255, nullable=true)
     */
    private $numeroOrdenArreglo;

    /**
     * @var string
     *
     * @ORM\Column(name="detalle", type="text", nullable=true)
     */
    private $detalle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="solucionado", type="boolean", nullable=true)
     */
    private $solucionado;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\TipoDanioInterno")
     * @ORM\JoinColumn(name="tipo_danio_interno_id", referencedColumnName="id")
     */
    private $tipoDanioInterno;

    /**
     *
     * @ORM\OneToMany(targetEntity="VehiculosBundle\Entity\FotoDanioInterno", mappedBy="danioVehiculoInterno", cascade={"persist"})
     */
    private $fotoDanioInterno;

    /**
     * @var datetime $creado
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="creado", type="datetime")
     */
    private $creado;

    /**
     * @var datetime $actualizado
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="actualizado",type="datetime")
     */
    private $actualizado;

    /**
     * @var integer $creadoPor
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="UsuariosBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="creado_por", referencedColumnName="id", nullable=true)
     */
    private $creadoPor;

    /**
     * @var integer $actualizadoPor
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="UsuariosBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="actualizado_por", referencedColumnName="id", nullable=true)
     */
    private $actualizadoPor;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Vehiculo", inversedBy="danioVehiculoInterno")
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
     * Set numeroOrdenArreglo
     *
     * @param string $numeroOrdenArreglo
     *
     * @return DanioVehiculoInterno
     */
    public function setNumeroOrdenArreglo($numeroOrdenArreglo) {
        $this->numeroOrdenArreglo = $numeroOrdenArreglo;

        return $this;
    }

    /**
     * Get numeroOrdenArreglo
     *
     * @return string
     */
    public function getNumeroOrdenArreglo() {
        return $this->numeroOrdenArreglo;
    }

    /**
     * Set detalle
     *
     * @param string $detalle
     *
     * @return DanioVehiculoInterno
     */
    public function setDetalle($detalle) {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return string
     */
    public function getDetalle() {
        return $this->detalle;
    }

    /**
     * Set solucionado
     *
     * @param boolean $solucionado
     *
     * @return DanioVehiculoInterno
     */
    public function setSolucionado($solucionado) {
        $this->solucionado = $solucionado;

        return $this;
    }

    /**
     * Get solucionado
     *
     * @return boolean
     */
    public function getSolucionado() {
        return $this->solucionado;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->fotoDanioInterno = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return DanioVehiculoInterno
     */
    public function setCreado($creado) {
        $this->creado = $creado;

        return $this;
    }

    /**
     * Get creado
     *
     * @return \DateTime
     */
    public function getCreado() {
        return $this->creado;
    }

    /**
     * Set actualizado
     *
     * @param \DateTime $actualizado
     *
     * @return DanioVehiculoInterno
     */
    public function setActualizado($actualizado) {
        $this->actualizado = $actualizado;

        return $this;
    }

    /**
     * Get actualizado
     *
     * @return \DateTime
     */
    public function getActualizado() {
        return $this->actualizado;
    }

    /**
     * Set tipoDanioInterno
     *
     * @param \VehiculosBundle\Entity\TipoDanioInterno $tipoDanioInterno
     *
     * @return DanioVehiculoInterno
     */
    public function setTipoDanioInterno(\VehiculosBundle\Entity\TipoDanioInterno $tipoDanioInterno = null) {
        $this->tipoDanioInterno = $tipoDanioInterno;

        return $this;
    }

    /**
     * Get tipoDanioInterno
     *
     * @return \VehiculosBundle\Entity\TipoDanioInterno
     */
    public function getTipoDanioInterno() {
        return $this->tipoDanioInterno;
    }

    /**
     * Add fotoDanioInterno
     *
     * @param \VehiculosBundle\Entity\FotoDanioInterno $fotoDanioInterno
     *
     * @return DanioVehiculoInterno
     */
    public function addFotoDanioInterno(\VehiculosBundle\Entity\FotoDanioInterno $fotoDanioInterno) {
        $this->fotoDanioInterno[] = $fotoDanioInterno;

        return $this;
    }

    /**
     * Remove fotoDanioInterno
     *
     * @param \VehiculosBundle\Entity\FotoDanioInterno $fotoDanioInterno
     */
    public function removeFotoDanioInterno(\VehiculosBundle\Entity\FotoDanioInterno $fotoDanioInterno) {
        $this->fotoDanioInterno->removeElement($fotoDanioInterno);
    }

    /**
     * Get fotoDanioInterno
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFotoDanioInterno() {
        return $this->fotoDanioInterno;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return DanioVehiculoInterno
     */
    public function setCreadoPor(\UsuariosBundle\Entity\Usuario $creadoPor = null) {
        $this->creadoPor = $creadoPor;

        return $this;
    }

    /**
     * Get creadoPor
     *
     * @return \UsuariosBundle\Entity\Usuario
     */
    public function getCreadoPor() {
        return $this->creadoPor;
    }

    /**
     * Set actualizadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $actualizadoPor
     *
     * @return DanioVehiculoInterno
     */
    public function setActualizadoPor(\UsuariosBundle\Entity\Usuario $actualizadoPor = null) {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }

    /**
     * Get actualizadoPor
     *
     * @return \UsuariosBundle\Entity\Usuario
     */
    public function getActualizadoPor() {
        return $this->actualizadoPor;
    }


    /**
     * Set vehiculo
     *
     * @param \VehiculosBundle\Entity\Vehiculo $vehiculo
     *
     * @return DanioVehiculoInterno
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
}
