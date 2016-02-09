<?php

namespace PersonasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Empleado
 *
 * @ORM\Table(name="empleados")
 * @ORM\Entity(repositoryClass="PersonasBundle\Entity\EmpleadoRepository")
 */
class Empleado
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
     * @ORM\OneToMany(targetEntity="PersonasBundle\Entity\PersonaTipo", mappedBy="empleado", cascade={"persist"})
     *
     */
    private $personaTipo;
    
    /**
     * @ORM\OneToMany(targetEntity="PersonasBundle\Entity\EmpleadoCategoria", mappedBy="empleado", cascade={"persist"})
     *
     */
    private $empleadoCategoria;

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
        $this->personaTipo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->empleadoCategoria = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Empleado
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
     * @return Empleado
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
     * Add personaTipo
     *
     * @param \PersonasBundle\Entity\PersonaTipo $personaTipo
     *
     * @return Empleado
     */
    public function addPersonaTipo(\PersonasBundle\Entity\PersonaTipo $personaTipo)
    {
        $this->personaTipo[] = $personaTipo;

        return $this;
    }

    /**
     * Remove personaTipo
     *
     * @param \PersonasBundle\Entity\PersonaTipo $personaTipo
     */
    public function removePersonaTipo(\PersonasBundle\Entity\PersonaTipo $personaTipo)
    {
        $this->personaTipo->removeElement($personaTipo);
    }

    /**
     * Get personaTipo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonaTipo()
    {
        return $this->personaTipo;
    }

    /**
     * Add empleadoCategorium
     *
     * @param \PersonasBundle\Entity\EmpleadoCategoria $empleadoCategorium
     *
     * @return Empleado
     */
    public function addEmpleadoCategorion(\PersonasBundle\Entity\EmpleadoCategoria $empleadoCategorium)
    {
        $this->empleadoCategoria[] = $empleadoCategorium;

        return $this;
    }

    /**
     * Remove empleadoCategorium
     *
     * @param \PersonasBundle\Entity\EmpleadoCategoria $empleadoCategorium
     */
    public function removeEmpleadoCategorion(\PersonasBundle\Entity\EmpleadoCategoria $empleadoCategorium)
    {
        $this->empleadoCategoria->removeElement($empleadoCategorium);
    }

    /**
     * Get empleadoCategoria
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmpleadoCategoria()
    {
        return $this->empleadoCategoria;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return Empleado
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
     * @return Empleado
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

    /**
     * Add empleadoCategorium
     *
     * @param \PersonasBundle\Entity\EmpleadoCategoria $empleadoCategorium
     *
     * @return Empleado
     */
    public function addEmpleadoCategorium(\PersonasBundle\Entity\EmpleadoCategoria $empleadoCategorium)
    {
        $this->empleadoCategoria[] = $empleadoCategorium;

        return $this;
    }

    /**
     * Remove empleadoCategorium
     *
     * @param \PersonasBundle\Entity\EmpleadoCategoria $empleadoCategorium
     */
    public function removeEmpleadoCategorium(\PersonasBundle\Entity\EmpleadoCategoria $empleadoCategorium)
    {
        $this->empleadoCategoria->removeElement($empleadoCategorium);
    }
    
    public function __toString() {
        return $this->personaTipo->first()->getPersona()->__toString();
    }
}
