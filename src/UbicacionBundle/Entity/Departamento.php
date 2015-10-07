<?php

namespace UbicacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Departamento
 *
 * @ORM\Table(name="departamentos")
 * @ORM\Entity
 */
class Departamento {

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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255, nullable=true)
     */
    private $codigo;

    /** @ORM\ManyToOne(targetEntity="Provincia", inversedBy="departamento")
     *  @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
     */
    private $provincia;

    /**
     * @ORM\OneToMany(targetEntity="Localidad", mappedBy="departamento")
     */
    private $localidad;

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

    public function __toString() {
        return $this->descripcion;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->localidad = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Departamento
     */
    public function setDescripcion($descripcion) {
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
     * Set codigo
     *
     * @param string $codigo
     * @return Departamento
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
     * Set creado
     *
     * @param \DateTime $creado
     * @return Departamento
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
     * @return Departamento
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
     * Set provincia
     *
     * @param \UbicacionBundle\Entity\Provincia $provincia
     * @return Departamento
     */
    public function setProvincia(\UbicacionBundle\Entity\Provincia $provincia = null) {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return \UbicacionBundle\Entity\Provincia
     */
    public function getProvincia() {
        return $this->provincia;
    }

    /**
     * Add localidad
     *
     * @param \UbicacionBundle\Entity\Localidad $localidad
     * @return Departamento
     */
    public function addLocalidad(\UbicacionBundle\Entity\Localidad $localidad) {
        $this->localidad[] = $localidad;

        return $this;
    }

    /**
     * Remove localidad
     *
     * @param \UbicacionBundle\Entity\Localidad $localidad
     */
    public function removeLocalidad(\UbicacionBundle\Entity\Localidad $localidad) {
        $this->localidad->removeElement($localidad);
    }

    /**
     * Get localidad
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocalidad() {
        return $this->localidad;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     * @return Departamento
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
     * @return Departamento
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
