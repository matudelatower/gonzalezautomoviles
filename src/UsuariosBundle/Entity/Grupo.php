<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 7/10/15
 * Time: 12:14 PM
 */

namespace UsuariosBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 */
class Grupo extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\OneToMany(targetEntity="UsuariosBundle\Entity\PermisoAplicacion", mappedBy="grupo",cascade={"persist","remove"})
     */
    private $permisoAplicacion;

    /**
     * @ORM\OneToMany(targetEntity="UsuariosBundle\Entity\PermisoEspecialGrupo", mappedBy="grupo",cascade={"persist","remove"})
     */
    private $permisoEspecialGrupo;

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

    public function __toString()
    {
        return $this->name;
    }

    

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Grupo
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
     * @return Grupo
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
     * Add permisoAplicacion
     *
     * @param \UsuariosBundle\Entity\PermisoAplicacion $permisoAplicacion
     *
     * @return Grupo
     */
    public function addPermisoAplicacion(\UsuariosBundle\Entity\PermisoAplicacion $permisoAplicacion)
    {
        $this->permisoAplicacion[] = $permisoAplicacion;

        return $this;
    }

    /**
     * Remove permisoAplicacion
     *
     * @param \UsuariosBundle\Entity\PermisoAplicacion $permisoAplicacion
     */
    public function removePermisoAplicacion(\UsuariosBundle\Entity\PermisoAplicacion $permisoAplicacion)
    {
        $this->permisoAplicacion->removeElement($permisoAplicacion);
    }

    /**
     * Get permisoAplicacion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPermisoAplicacion()
    {

        $collection = $this->permisoAplicacion;
        $iterator = $collection->getIterator();
        $iterator->uasort(function ($a, $b) {
            return ($a->getItemAplicativo()->__toString() < $b->getItemAplicativo()->__toString()) ? -1 : 1;
        });
        $collection = new ArrayCollection(iterator_to_array($iterator));
        return $collection;

//        return $this->permisoAplicacion;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return Grupo
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
     * @return Grupo
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
     * Add permisoEspecialGrupo
     *
     * @param \UsuariosBundle\Entity\PermisoEspecialGrupo $permisoEspecialGrupo
     *
     * @return Grupo
     */
    public function addPermisoEspecialGrupo(\UsuariosBundle\Entity\PermisoEspecialGrupo $permisoEspecialGrupo)
    {
        $this->permisoEspecialGrupo[] = $permisoEspecialGrupo;

        return $this;
    }

    /**
     * Remove permisoEspecialGrupo
     *
     * @param \UsuariosBundle\Entity\PermisoEspecialGrupo $permisoEspecialGrupo
     */
    public function removePermisoEspecialGrupo(\UsuariosBundle\Entity\PermisoEspecialGrupo $permisoEspecialGrupo)
    {
        $this->permisoEspecialGrupo->removeElement($permisoEspecialGrupo);
    }

    /**
     * Get permisoEspecialGrupo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPermisoEspecialGrupo()
    {
        return $this->permisoEspecialGrupo;
    }
}
