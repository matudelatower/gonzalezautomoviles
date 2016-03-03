<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CheckControlInternoResultadoCabecera
 *
 * @ORM\Table(name="check_control_interno_resultado_cabeceras")
 * @ORM\Entity
 */
class CheckControlInternoResultadoCabecera {

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
     * @ORM\Column(name="observacion", type="string", length=255, nullable=true)
     */
    private $observacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="firmado", type="boolean")
     */
    private $firmado;
     


    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Vehiculo")
     * @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id")
     */
    private $vehiculo;

    /**
     * @ORM\OneToMany(targetEntity="VehiculosBundle\Entity\CheckControlInternoResultadoRespuesta", mappedBy="checkControlInternoResultadoCabecera",cascade={"remove", "persist"})
     *
     */
    private $checkControlInternoResultadoRespuesta;

   
    

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
     * Constructor
     */
    public function __construct()
    {
        $this->checkControlInternoResultadoRespuesta = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set observacion
     *
     * @param string $observacion
     *
     * @return CheckControlInternoResultadoCabecera
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set firmado
     *
     * @param boolean $firmado
     *
     * @return CheckControlInternoResultadoCabecera
     */
    public function setFirmado($firmado)
    {
        $this->firmado = $firmado;

        return $this;
    }

    /**
     * Get firmado
     *
     * @return boolean
     */
    public function getFirmado()
    {
        return $this->firmado;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return CheckControlInternoResultadoCabecera
     */
    public function setCreado($creado)
    {
        $this->creado = $creado;

        return $this;
    }

    /**
     * Get creado
     *
     * @return \DateTime
     */
    public function getCreado()
    {
        return $this->creado;
    }

    /**
     * Set actualizado
     *
     * @param \DateTime $actualizado
     *
     * @return CheckControlInternoResultadoCabecera
     */
    public function setActualizado($actualizado)
    {
        $this->actualizado = $actualizado;

        return $this;
    }

    /**
     * Get actualizado
     *
     * @return \DateTime
     */
    public function getActualizado()
    {
        return $this->actualizado;
    }

    /**
     * Set vehiculo
     *
     * @param \VehiculosBundle\Entity\Vehiculo $vehiculo
     *
     * @return CheckControlInternoResultadoCabecera
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
     * Add checkControlInternoResultadoRespuestum
     *
     * @param \VehiculosBundle\Entity\CheckControlInternoResultadoRespuesta $checkControlInternoResultadoRespuestum
     *
     * @return CheckControlInternoResultadoCabecera
     */
    public function addCheckControlInternoResultadoRespuestum(\VehiculosBundle\Entity\CheckControlInternoResultadoRespuesta $checkControlInternoResultadoRespuestum)
    {
        $this->checkControlInternoResultadoRespuesta[] = $checkControlInternoResultadoRespuestum;

        return $this;
    }

    /**
     * Remove checkControlInternoResultadoRespuestum
     *
     * @param \VehiculosBundle\Entity\CheckControlInternoResultadoRespuesta $checkControlInternoResultadoRespuestum
     */
    public function removeCheckControlInternoResultadoRespuestum(\VehiculosBundle\Entity\CheckControlInternoResultadoRespuesta $checkControlInternoResultadoRespuestum)
    {
        $this->checkControlInternoResultadoRespuesta->removeElement($checkControlInternoResultadoRespuestum);
    }

    /**
     * Get checkControlInternoResultadoRespuesta
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCheckControlInternoResultadoRespuesta()
    {
        return $this->checkControlInternoResultadoRespuesta;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return CheckControlInternoResultadoCabecera
     */
    public function setCreadoPor(\UsuariosBundle\Entity\Usuario $creadoPor = null)
    {
        $this->creadoPor = $creadoPor;

        return $this;
    }

    /**
     * Get creadoPor
     *
     * @return \UsuariosBundle\Entity\Usuario
     */
    public function getCreadoPor()
    {
        return $this->creadoPor;
    }

    /**
     * Set actualizadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $actualizadoPor
     *
     * @return CheckControlInternoResultadoCabecera
     */
    public function setActualizadoPor(\UsuariosBundle\Entity\Usuario $actualizadoPor = null)
    {
        $this->actualizadoPor = $actualizadoPor;

        return $this;
    }

    /**
     * Get actualizadoPor
     *
     * @return \UsuariosBundle\Entity\Usuario
     */
    public function getActualizadoPor()
    {
        return $this->actualizadoPor;
    }
}
