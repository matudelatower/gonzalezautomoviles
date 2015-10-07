<?php

namespace CuestionariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CuestionarioPregunta
 *
 * @ORM\Table(name="cuestionario_preguntas")
 * @ORM\Entity
 */
class CuestionarioPregunta
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
     * @ORM\Column(name="texto_pregunta", type="string", length=255)
     */
    private $textoPregunta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;


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
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\CuestionarioCategoria", inversedBy="preguntas")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    private $categoria;

    /**
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\TipoPregunta")
     * @ORM\JoinColumn(name="tipo_pregunta_id", referencedColumnName="id")
     */
    private $tipoPregunta;

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
     * Set textoPregunta
     *
     * @param string $textoPregunta
     *
     * @return CuestionarioPregunta
     */
    public function setTextoPregunta($textoPregunta)
    {
        $this->textoPregunta = $textoPregunta;

        return $this;
    }

    /**
     * Get textoPregunta
     *
     * @return string
     */
    public function getTextoPregunta()
    {
        return $this->textoPregunta;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CuestionarioPregunta
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
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return CuestionarioPregunta
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
     * @return CuestionarioPregunta
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
     * @return CuestionarioPregunta
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
     * @return CuestionarioPregunta
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
     * Set categoria
     *
     * @param \CuestionariosBundle\Entity\CuestionarioCategoria $categoria
     *
     * @return CuestionarioPregunta
     */
    public function setCategoria(\CuestionariosBundle\Entity\CuestionarioCategoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \CuestionariosBundle\Entity\CuestionarioCategoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set tipoPregunta
     *
     * @param \CuestionariosBundle\Entity\TipoPregunta $tipoPregunta
     *
     * @return CuestionarioPregunta
     */
    public function setTipoPregunta(\CuestionariosBundle\Entity\TipoPregunta $tipoPregunta = null)
    {
        $this->tipoPregunta = $tipoPregunta;

        return $this;
    }

    /**
     * Get tipoPregunta
     *
     * @return \CuestionariosBundle\Entity\TipoPregunta
     */
    public function getTipoPregunta()
    {
        return $this->tipoPregunta;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return CuestionarioPregunta
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
}
