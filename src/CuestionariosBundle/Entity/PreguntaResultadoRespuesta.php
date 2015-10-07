<?php

namespace CuestionariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PreguntaResultadoRespuesta
 *
 * @ORM\Table(name="pregunta_resultado_respuestas")
 * @ORM\Entity
 */
class PreguntaResultadoRespuesta
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
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\CuestionarioResultadoRespuesta")
     * @ORM\JoinColumn(name="tipo_danio_id", referencedColumnName="id")
     */
    private $resultadoRespuesta;

    /**
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\CuestionarioPregunta")
     * @ORM\JoinColumn(name="pregunta_id", referencedColumnName="id")
     */
    private $pregunta;

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
     * @return PreguntaResultadoRespuesta
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
     * @return PreguntaResultadoRespuesta
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
     * @return PreguntaResultadoRespuesta
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
     * @return PreguntaResultadoRespuesta
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
     * Set resultadoRespuesta
     *
     * @param \CuestionariosBundle\Entity\CuestionarioResultadoRespuesta $resultadoRespuesta
     *
     * @return PreguntaResultadoRespuesta
     */
    public function setResultadoRespuesta(\CuestionariosBundle\Entity\CuestionarioResultadoRespuesta $resultadoRespuesta = null)
    {
        $this->resultadoRespuesta = $resultadoRespuesta;

        return $this;
    }

    /**
     * Get resultadoRespuesta
     *
     * @return \CuestionariosBundle\Entity\CuestionarioResultadoRespuesta
     */
    public function getResultadoRespuesta()
    {
        return $this->resultadoRespuesta;
    }

    /**
     * Set pregunta
     *
     * @param \CuestionariosBundle\Entity\CuestionarioPregunta $pregunta
     *
     * @return PreguntaResultadoRespuesta
     */
    public function setPregunta(\CuestionariosBundle\Entity\CuestionarioPregunta $pregunta = null)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return \CuestionariosBundle\Entity\CuestionarioPregunta
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }
}
