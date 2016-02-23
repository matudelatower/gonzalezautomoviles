<?php

namespace CuestionariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EncuestaPregunta
 *
 * @ORM\Table(name="encuesta_preguntas")
 * @ORM\Entity
 */
class EncuestaPregunta
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
     * @var text
     *
     * @ORM\Column(name="pregunta", type="text", length=255)
     */
    private $pregunta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer")
     */
    private $orden;
    
    /**
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\EncuestaTipoPregunta")
     * @ORM\JoinColumn(name="encuesta_tipo_pregunta_id", referencedColumnName="id")
     */
    private $encuestaTipoPregunta;
    
    /**
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\Encuesta")
     * @ORM\JoinColumn(name="encuesta_id", referencedColumnName="id")
     */
    private $encuesta;

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
     * @ORM\OneToMany(targetEntity="CuestionariosBundle\Entity\EncuestaOpcionRespuesta", mappedBy="encuestaPregunta")
     *
     */
    private $opcionesRespuestas;

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
     * Set pregunta
     *
     * @param string $pregunta
     *
     * @return EncuestaPregunta
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return EncuestaPregunta
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return EncuestaPregunta
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
     * @return EncuestaPregunta
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
     * @return EncuestaPregunta
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
     * @return EncuestaPregunta
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
     * @return EncuestaPregunta
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
     * Set encuestaTipoPregunta
     *
     * @param \CuestionariosBundle\Entity\EncuestaTipoPregunta $encuestaTipoPregunta
     *
     * @return EncuestaPregunta
     */
    public function setEncuestaTipoPregunta(\CuestionariosBundle\Entity\EncuestaTipoPregunta $encuestaTipoPregunta = null)
    {
        $this->encuestaTipoPregunta = $encuestaTipoPregunta;

        return $this;
    }

    /**
     * Get encuestaTipoPregunta
     *
     * @return \CuestionariosBundle\Entity\EncuestaTipoPregunta
     */
    public function getEncuestaTipoPregunta()
    {
        return $this->encuestaTipoPregunta;
    }

    /**
     * Set encuesta
     *
     * @param \CuestionariosBundle\Entity\Encuesta $encuesta
     *
     * @return EncuestaPregunta
     */
    public function setEncuesta(\CuestionariosBundle\Entity\Encuesta $encuesta = null)
    {
        $this->encuesta = $encuesta;

        return $this;
    }

    /**
     * Get encuesta
     *
     * @return \CuestionariosBundle\Entity\Encuesta
     */
    public function getEncuesta()
    {
        return $this->encuesta;
    }
    
    public function __toString() {
        return $this->pregunta;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->opcionesRespuestas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add opcionesRespuesta
     *
     * @param \CuestionariosBundle\Entity\EncuestaOpcionRespuesta $opcionesRespuesta
     *
     * @return EncuestaPregunta
     */
    public function addOpcionesRespuesta(\CuestionariosBundle\Entity\EncuestaOpcionRespuesta $opcionesRespuesta)
    {
        $this->opcionesRespuestas[] = $opcionesRespuesta;

        return $this;
    }

    /**
     * Remove opcionesRespuesta
     *
     * @param \CuestionariosBundle\Entity\EncuestaOpcionRespuesta $opcionesRespuesta
     */
    public function removeOpcionesRespuesta(\CuestionariosBundle\Entity\EncuestaOpcionRespuesta $opcionesRespuesta)
    {
        $this->opcionesRespuestas->removeElement($opcionesRespuesta);
    }

    /**
     * Get opcionesRespuestas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOpcionesRespuestas()
    {
        return $this->opcionesRespuestas;
    }
}
