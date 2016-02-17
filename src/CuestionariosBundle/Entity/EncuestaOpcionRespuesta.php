<?php

namespace CuestionariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EncuestaOpcionRespuesta
 *
 * @ORM\Table(name="encuesta_opciones_respuestas")
 * @ORM\Entity
 */
class EncuestaOpcionRespuesta {

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
     * @ORM\Column(name="texto_opcion", type="string", length=255)
     */
    private $textoOpcion;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="orden", type="integer", nullable=true)
     */
    private $orden;
    
    /**
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\EncuestaPregunta")
     * @ORM\JoinColumn(name="encuesta_pregunta_id", referencedColumnName="id")
     */
    private $encuestaPregunta;

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
     * Set textoOpcion
     *
     * @param string $textoOpcion
     *
     * @return EncuestaOpcionRespuesta
     */
    public function setTextoOpcion($textoOpcion) {
        $this->textoOpcion = $textoOpcion;

        return $this;
    }

    /**
     * Get textoOpcion
     *
     * @return string
     */
    public function getTextoOpcion() {
        return $this->textoOpcion;
    }


    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return EncuestaOpcionRespuesta
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
     * @return EncuestaOpcionRespuesta
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
     * @return EncuestaOpcionRespuesta
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
     * @return EncuestaOpcionRespuesta
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
     * @return EncuestaOpcionRespuesta
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
     * Set orden
     *
     * @param integer $orden
     *
     * @return EncuestaOpcionRespuesta
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
