<?php

namespace PersonasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PersonaTipo
 *
 * @ORM\Table(name="persona_tipos")
 * @ORM\Entity
 */
class PersonaTipo
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
     * @ORM\ManyToOne(targetEntity="PersonasBundle\Entity\Persona", inversedBy="personaTipo", cascade={"persist"})
     * @ORM\JoinColumn(name="persona_id", referencedColumnName="id")
     */
    private $persona;

    /**
     * @ORM\ManyToOne(targetEntity="ClientesBundle\Entity\Cliente", inversedBy="personaTipo")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id", nullable=true)
     */
    private $cliente;


    /**
     * @ORM\ManyToOne(targetEntity="PersonasBundle\Entity\Empleado", inversedBy="personaTipo", cascade={"persist"})
     * @ORM\JoinColumn(name="empleado_id", referencedColumnName="id", nullable=true)
     */
    private $empleado;

    /**
     * @ORM\ManyToOne(targetEntity="EmpresasBundle\Entity\Sucursal")
     * @ORM\JoinColumn(name="sucursal_id", referencedColumnName="id")
     */
    private $sucursal;

    /**
     * @ORM\ManyToOne(targetEntity="UsuariosBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=true)
     */
    private $usuario;
    

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
     * @return PersonaTipo
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
     * @return PersonaTipo
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
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return PersonaTipo
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
     * @return PersonaTipo
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
     * Set persona
     *
     * @param \PersonasBundle\Entity\Persona $persona
     *
     * @return PersonaTipo
     */
    public function setPersona(\PersonasBundle\Entity\Persona $persona = null)
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * Get persona
     *
     * @return \PersonasBundle\Entity\Persona
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * Set cliente
     *
     * @param \ClientesBundle\Entity\Cliente $cliente
     *
     * @return PersonaTipo
     */
    public function setCliente(\ClientesBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \ClientesBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set empleado
     *
     * @param \PersonasBundle\Entity\Empleado $empleado
     *
     * @return PersonaTipo
     */
    public function setEmpleado(\PersonasBundle\Entity\Empleado $empleado = null)
    {
        $this->empleado = $empleado;

        return $this;
    }

    /**
     * Get empleado
     *
     * @return \PersonasBundle\Entity\Empleado
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }

    /**
     * Set sucursal
     *
     * @param \EmpresasBundle\Entity\Sucursal $sucursal
     *
     * @return PersonaTipo
     */
    public function setSucursal(\EmpresasBundle\Entity\Sucursal $sucursal = null)
    {
        $this->sucursal = $sucursal;

        return $this;
    }

    /**
     * Get sucursal
     *
     * @return \EmpresasBundle\Entity\Sucursal
     */
    public function getSucursal()
    {
        return $this->sucursal;
    }

    /**
     * Set usuario
     *
     * @param \UsuariosBundle\Entity\Usuario $usuario
     *
     * @return PersonaTipo
     */
    public function setUsuario(\UsuariosBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \UsuariosBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
