<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CodigoModelo
 *
 * @ORM\Table(name="codigos_modelo")
 * @ORM\Entity(repositoryClass="VehiculosBundle\Entity\Repository\CodigoModeloRepository")
 */
class CodigoModelo {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio", type="integer")
     */
    private $anio;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=255)
     */
    private $version;

    /**
     * @var $activo
     *
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo = true;

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
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\NombreModelo")
     * @ORM\OrderBy({"nombre" = "ASC"})
     * @ORM\JoinColumn(name="nombre_modelo_id", referencedColumnName="id",nullable=false)
     */
    private $nombreModelo;

    public function __toString() {
        return $this->getNombreModelo()->getNombre() . " | " . $this->anio . " | " . $this->codigo . " | " . $this->version;
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
     * Set anio
     *
     * @param integer $anio
     *
     * @return CodigoModelo
     */
    public function setAnio($anio) {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return integer
     */
    public function getAnio() {
        return $this->anio;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return CodigoModelo
     */
    public function setCodigo($codigo) {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo() {
        return $this->codigo;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return CodigoModelo
     */
    public function setVersion($version) {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion() {
        return $this->version;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CodigoModelo
     */
    public function setActivo($activo) {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo() {
        return $this->activo;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return CodigoModelo
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
     * @return CodigoModelo
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
     * @return CodigoModelo
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
     * @return CodigoModelo
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
     * Set nombreModelo
     *
     * @param \VehiculosBundle\Entity\NombreModelo $nombreModelo
     *
     * @return CodigoModelo
     */
    public function setNombreModelo(\VehiculosBundle\Entity\NombreModelo $nombreModelo = null) {
        $this->nombreModelo = $nombreModelo;

        return $this;
    }

    /**
     * Get nombreModelo
     *
     * @return \VehiculosBundle\Entity\NombreModelo
     */
    public function getNombreModelo() {
        return $this->nombreModelo;
    }

}
