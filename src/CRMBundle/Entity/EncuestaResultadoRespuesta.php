<?php

namespace CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UtilBundle\Entity\Base\BaseClass;

/**
 * EncuestaResultadoRespuesta
 *
 * @ORM\Table(name="crm_encuesta_resultados_respuestas")
 * @ORM\Entity()
 */
class EncuestaResultadoRespuesta extends BaseClass
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
     * @ORM\ManyToOne(targetEntity="CRMBundle\Entity\EncuestaPregunta")
     * @ORM\JoinColumn(name="encuesta_pregunta_id", referencedColumnName="id")
     * @ORM\OrderBy({"orden" = "ASC"})
     */
    private $encuestaPregunta;
    
    /**
     * @ORM\ManyToOne(targetEntity="CRMBundle\Entity\EncuestaOpcionRespuesta")
     * @ORM\JoinColumn(name="encuesta_opcion_respuesta_id", referencedColumnName="id")
     * @ORM\OrderBy({"orden" = "ASC"})
     */
    private $encuestaOpcionRespuesta;
    
    /**
     * @ORM\ManyToOne(targetEntity="CRMBundle\Entity\EncuestaResultadoCabecera", inversedBy="encuestaResultadoRespuesta",cascade={"persist"})
     * @ORM\JoinColumn(name="encuesta_resultado_cabecera_id", referencedColumnName="id")
     */
    private $encuestaResultadoCabecera;



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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return EncuestaResultadoRespuesta
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Set fechaActualizacion
     *
     * @param \DateTime $fechaActualizacion
     *
     * @return EncuestaResultadoRespuesta
     */
    public function setFechaActualizacion($fechaActualizacion)
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    /**
     * Set encuestaPregunta
     *
     * @param \CRMBundle\Entity\EncuestaPregunta $encuestaPregunta
     *
     * @return EncuestaResultadoRespuesta
     */
    public function setEncuestaPregunta(\CRMBundle\Entity\EncuestaPregunta $encuestaPregunta = null)
    {
        $this->encuestaPregunta = $encuestaPregunta;

        return $this;
    }

    /**
     * Get encuestaPregunta
     *
     * @return \CRMBundle\Entity\EncuestaPregunta
     */
    public function getEncuestaPregunta()
    {
        return $this->encuestaPregunta;
    }

    /**
     * Set encuestaOpcionRespuesta
     *
     * @param \CRMBundle\Entity\EncuestaOpcionRespuesta $encuestaOpcionRespuesta
     *
     * @return EncuestaResultadoRespuesta
     */
    public function setEncuestaOpcionRespuesta(\CRMBundle\Entity\EncuestaOpcionRespuesta $encuestaOpcionRespuesta = null)
    {
        $this->encuestaOpcionRespuesta = $encuestaOpcionRespuesta;

        return $this;
    }

    /**
     * Get encuestaOpcionRespuesta
     *
     * @return \CRMBundle\Entity\EncuestaOpcionRespuesta
     */
    public function getEncuestaOpcionRespuesta()
    {
        return $this->encuestaOpcionRespuesta;
    }

    /**
     * Set encuestaResultadoCabecera
     *
     * @param \CRMBundle\Entity\EncuestaResultadoCabecera $encuestaResultadoCabecera
     *
     * @return EncuestaResultadoRespuesta
     */
    public function setEncuestaResultadoCabecera(\CRMBundle\Entity\EncuestaResultadoCabecera $encuestaResultadoCabecera = null)
    {
        $this->encuestaResultadoCabecera = $encuestaResultadoCabecera;

        return $this;
    }

    /**
     * Get encuestaResultadoCabecera
     *
     * @return \CRMBundle\Entity\EncuestaResultadoCabecera
     */
    public function getEncuestaResultadoCabecera()
    {
        return $this->encuestaResultadoCabecera;
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
}
