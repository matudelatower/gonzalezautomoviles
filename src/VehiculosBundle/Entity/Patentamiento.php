<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Patentamiento
 *
 * @ORM\Table(name="patentamientos")
 * @ORM\Entity
 */
class Patentamiento {

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
     * @ORM\Column(name="dominio", type="string", length=255, nullable=true)
     */
    private $dominio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="registro", type="string", length=255, nullable=true)
     */
    private $registro;

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
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\EstadoPatentamiento")
     * @ORM\JoinColumn(name="estado_patentamiento_id", referencedColumnName="id",nullable=true)
     */
    private $estadoPatentamiento;
    
    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\AgenteInicioPatente")
     * @ORM\JoinColumn(name="agente_inicio_patente_id", referencedColumnName="id",nullable=true)
     */
    private $agenteInicioPatente;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set dominio
     *
     * @param string $dominio
     *
     * @return Patentamiento
     */
    public function setDominio($dominio) {
        $this->dominio = $dominio;

        return $this;
    }

    /**
     * Get dominio
     *
     * @return string
     */
    public function getDominio() {
        return $this->dominio;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Patentamiento
     */
    public function setFecha($fecha) {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha() {
        return $this->fecha;
    }

    /**
     * Set registro
     *
     * @param string $registro
     *
     * @return Patentamiento
     */
    public function setRegistro($registro) {
        $this->registro = $registro;

        return $this;
    }

    /**
     * Get registro
     *
     * @return string
     */
    public function getRegistro() {
        return $this->registro;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Patentamiento
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
     * @return Patentamiento
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
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return Patentamiento
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
     * @return Patentamiento
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
     * Set estadoPatentamiento
     *
     * @param \VehiculosBundle\Entity\EstadoPatentamiento $estadoPatentamiento
     *
     * @return Patentamiento
     */
    public function setEstadoPatentamiento(\VehiculosBundle\Entity\EstadoPatentamiento $estadoPatentamiento = null) {
        $this->estadoPatentamiento = $estadoPatentamiento;

        return $this;
    }

    /**
     * Get estadoPatentamiento
     *
     * @return \VehiculosBundle\Entity\EstadoPatentamiento
     */
    public function getEstadoPatentamiento() {
        return $this->estadoPatentamiento;
    }


    /**
     * Set agenteInicioPatente
     *
     * @param \VehiculosBundle\Entity\AgenteInicioPatente $agenteInicioPatente
     *
     * @return Patentamiento
     */
    public function setAgenteInicioPatente(\VehiculosBundle\Entity\AgenteInicioPatente $agenteInicioPatente = null)
    {
        $this->agenteInicioPatente = $agenteInicioPatente;

        return $this;
    }

    /**
     * Get agenteInicioPatente
     *
     * @return \VehiculosBundle\Entity\AgenteInicioPatente
     */
    public function getAgenteInicioPatente()
    {
        return $this->agenteInicioPatente;
    }
}
