<?php

namespace UsuariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PermisoEspecialGrupo
 *
 * @ORM\Table(name="permisos_especial_grupo")
 * @ORM\Entity
 */
class PermisoEspecialGrupo {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/** @ORM\ManyToOne(targetEntity="UsuariosBundle\Entity\Grupo",inversedBy="permisoEspecialGrupo",cascade={"persist"})
	 * @ORM\JoinColumn(name="grupo_id", referencedColumnName="id")
	 */
	private $grupo;

	/** @ORM\ManyToOne(targetEntity="UsuariosBundle\Entity\PermisoEspecial",inversedBy="permisoEspecialGrupo",cascade={"persist"})
	 * @ORM\JoinColumn(name="permiso_especial_id", referencedColumnName="id")
	 */
	private $permisoEspecial;

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
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return PermisoEspecialGrupo
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
     * @return PermisoEspecialGrupo
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
     * Set grupo
     *
     * @param \UsuariosBundle\Entity\Grupo $grupo
     *
     * @return PermisoEspecialGrupo
     */
    public function setGrupo(\UsuariosBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \UsuariosBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
     * Set permisoEspecial
     *
     * @param \UsuariosBundle\Entity\PermisoEspecial $permisoEspecial
     *
     * @return PermisoEspecialGrupo
     */
    public function setPermisoEspecial(\UsuariosBundle\Entity\PermisoEspecial $permisoEspecial = null)
    {
        $this->permisoEspecial = $permisoEspecial;

        return $this;
    }

    /**
     * Get permisoEspecial
     *
     * @return \UsuariosBundle\Entity\PermisoEspecial
     */
    public function getPermisoEspecial()
    {
        return $this->permisoEspecial;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return PermisoEspecialGrupo
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
     * @return PermisoEspecialGrupo
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
