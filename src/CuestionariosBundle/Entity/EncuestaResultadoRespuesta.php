<?php

namespace CuestionariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EncuestaResultadoRespuesta
 *
 * @ORM\Table(name="encuesta_resultados_respuestas")
 * @ORM\Entity(repositoryClass="CuestionariosBundle\Entity\Repository\EncuestaResultadoRespuestaRepository")
 */
class EncuestaResultadoRespuesta
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
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\EncuestaPregunta")
     * @ORM\JoinColumn(name="encuesta_pregunta_id", referencedColumnName="id")
     */
    private $encuestaPregunta;
    
    /**
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\EncuestaOpcionRespuesta")
     * @ORM\JoinColumn(name="encuesta_opcion_respuesta_id", referencedColumnName="id")
     * @ORM\OrderBy({"orden" = "ASC"})
     */
    private $encuestaOpcionRespuesta;
    
    /**
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\EncuestaResultadoCabecera", cascade={"persist"})
     * @ORM\JoinColumn(name="encuesta_resultado_cabecera_id", referencedColumnName="id")
     */
    private $encuestaResultadoCabecera;

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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return EncuestaResultadoRespuesta
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
     * @return EncuestaResultadoRespuesta
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
     * @return EncuestaResultadoRespuesta
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
     * @return EncuestaResultadoRespuesta
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
     * Set encuestaPregunta
     *
     * @param \CuestionariosBundle\Entity\EncuestaPregunta $encuestaPregunta
     *
     * @return EncuestaResultadoRespuesta
     */
    public function setEncuestaPregunta(\CuestionariosBundle\Entity\EncuestaPregunta $encuestaPregunta = null)
    {
        $this->encuestaPregunta = $encuestaPregunta;

        return $this;
    }

    /**
     * Get encuestaPregunta
     *
     * @return \CuestionariosBundle\Entity\EncuestaPregunta
     */
    public function getEncuestaPregunta()
    {
        return $this->encuestaPregunta;
    }

    /**
     * Set encuestaOpcionRespuesta
     *
     * @param \CuestionariosBundle\Entity\EncuestaOpcionRespuesta $encuestaOpcionRespuesta
     *
     * @return EncuestaResultadoRespuesta
     */
    public function setEncuestaOpcionRespuesta(\CuestionariosBundle\Entity\EncuestaOpcionRespuesta $encuestaOpcionRespuesta = null)
    {
        $this->encuestaOpcionRespuesta = $encuestaOpcionRespuesta;

        return $this;
    }

    /**
     * Get encuestaOpcionRespuesta
     *
     * @return \CuestionariosBundle\Entity\EncuestaOpcionRespuesta
     */
    public function getEncuestaOpcionRespuesta()
    {
        return $this->encuestaOpcionRespuesta;
    }

    /**
     * Set encuestaResultadoCabecera
     *
     * @param \CuestionariosBundle\Entity\EncuestaResultadoCabecera $encuestaResultadoCabecera
     *
     * @return EncuestaResultadoRespuesta
     */
    public function setEncuestaResultadoCabecera(\CuestionariosBundle\Entity\EncuestaResultadoCabecera $encuestaResultadoCabecera = null)
    {
        $this->encuestaResultadoCabecera = $encuestaResultadoCabecera;

        return $this;
    }

    /**
     * Get encuestaResultadoCabecera
     *
     * @return \CuestionariosBundle\Entity\EncuestaResultadoCabecera
     */
    public function getEncuestaResultadoCabecera()
    {
        return $this->encuestaResultadoCabecera;
    }
}
