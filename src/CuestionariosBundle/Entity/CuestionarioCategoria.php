<?php

namespace CuestionariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CuestionarioCategoria
 *
 * @ORM\Table(name="cuestionario_categorias")
 * @ORM\Entity(repositoryClass="CuestionarioCategoriaRepository")
 */
class CuestionarioCategoria
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255,nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255,nullable=true)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean",nullable=true)
     */
    private $activo;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;


    /**
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\Cuestionario")
     * @ORM\JoinColumn(name="cuestionario_id", referencedColumnName="id")
     */
    private $cuestionario;

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
     * @ORM\OneToMany(targetEntity="CuestionariosBundle\Entity\CuestionarioPregunta", mappedBy="categoria",cascade={"remove", "persist"})
     *
     */
    private $preguntas;


    public function __toString()
    {
        return $this->nombre;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CuestionarioCategoria
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CuestionarioCategoria
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     *
     * @return CuestionarioCategoria
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return CuestionarioCategoria
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CuestionarioCategoria
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return CuestionarioCategoria
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return CuestionarioCategoria
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
     * @return CuestionarioCategoria
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
     * Set cuestionario
     *
     * @param \CuestionariosBundle\Entity\Cuestionario $cuestionario
     *
     * @return CuestionarioCategoria
     */
    public function setCuestionario(\CuestionariosBundle\Entity\Cuestionario $cuestionario = null)
    {
        $this->cuestionario = $cuestionario;

        return $this;
    }

    /**
     * Get cuestionario
     *
     * @return \CuestionariosBundle\Entity\Cuestionario
     */
    public function getCuestionario()
    {
        return $this->cuestionario;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return CuestionarioCategoria
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
     * @return CuestionarioCategoria
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
     * Add pregunta
     *
     * @param \CuestionariosBundle\Entity\CuestionarioPregunta $pregunta
     *
     * @return CuestionarioCategoria
     */
    public function addPregunta(\CuestionariosBundle\Entity\CuestionarioPregunta $pregunta)
    {
        $this->preguntas[] = $pregunta;

        return $this;
    }

    /**
     * Remove pregunta
     *
     * @param \CuestionariosBundle\Entity\CuestionarioPregunta $pregunta
     */
    public function removePregunta(\CuestionariosBundle\Entity\CuestionarioPregunta $pregunta)
    {
        $this->preguntas->removeElement($pregunta);
    }

    /**
     * Get preguntas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }
}
