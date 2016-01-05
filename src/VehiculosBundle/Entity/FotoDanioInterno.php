<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * FotoDanioInterno
 *
 * @ORM\Table(name="fotos_danios_interno")
 * @ORM\Entity
 */
class FotoDanioInterno {

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
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="DanioVehiculoInterno", inversedBy="fotoDanioInterno")
     * @ORM\JoinColumn(name="danio_vehiculo_interno_id", referencedColumnName="id")
     */
    private $danioVehiculoInterno;

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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return FotoDanioInterno
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return FotoDanioInterno
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
     * @return FotoDanioInterno
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
     * Set danioVehiculoInterno
     *
     * @param \VehiculosBundle\Entity\DanioVehiculoInterno $danioVehiculoInterno
     *
     * @return FotoDanioInterno
     */
    public function setDanioVehiculoInterno(\VehiculosBundle\Entity\DanioVehiculoInterno $danioVehiculoInterno = null) {
        $this->danioVehiculoInterno = $danioVehiculoInterno;

        return $this;
    }

    /**
     * Get danioVehiculoInterno
     *
     * @return \VehiculosBundle\Entity\DanioVehiculoInterno
     */
    public function getDanioVehiculoInterno() {
        return $this->danioVehiculoInterno;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return FotoDanioInterno
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
     * @return FotoDanioInterno
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

}
