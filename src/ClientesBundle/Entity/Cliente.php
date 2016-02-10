<?php

namespace ClientesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Cliente
 *
 * @ORM\Table(name="clientes")
 * @ORM\Entity(repositoryClass="ClientesBundle\Entity\Repository\ClienteRepository")
 */
class Cliente
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
     * @var boolean
     *
     * @ORM\Column(name="foraneo", type="boolean", nullable=true)
     */
    private $foraneo;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="reventa", type="boolean", nullable=true)
     */
    private $reventa;

    /**
     * @ORM\OneToMany(targetEntity="PersonasBundle\Entity\PersonaTipo", mappedBy="cliente", cascade={"persist"})
     *
     */
    private $personaTipo;

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
     * Set foraneo
     *
     * @param boolean $foraneo
     *
     * @return Cliente
     */
    public function setForaneo($foraneo)
    {
        $this->foraneo = $foraneo;

        return $this;
    }

    /**
     * Get foraneo
     *
     * @return boolean
     */
    public function getForaneo()
    {
        return $this->foraneo;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Cliente
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
     * @return Cliente
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
     * @return Cliente
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
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return Cliente
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
     * @return Cliente
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
    
    public function __toString() {
        return $this->personaTipo->first()->getPersona()->__toString();
    }

    /**
     * Set reventa
     *
     * @param boolean $reventa
     *
     * @return Cliente
     */
    public function setReventa($reventa)
    {
        $this->reventa = $reventa;

        return $this;
    }

    /**
     * Get reventa
     *
     * @return boolean
     */
    public function getReventa()
    {
        return $this->reventa;
    }
}
