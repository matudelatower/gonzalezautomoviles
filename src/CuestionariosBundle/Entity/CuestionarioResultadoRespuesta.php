<?php

namespace CuestionariosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CuestionarioResultadoRespuesta
 *
 * @ORM\Table(name="cuestionarios_resultado_respuestas")
 * @ORM\Entity
 */
class CuestionarioResultadoRespuesta
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
     * @ORM\Column(name="texto_respuesta", type="string", length=255)
     */
    private $textoRespuesta;


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
     * @ORM\ManyToOne(targetEntity="CuestionariosBundle\Entity\CuestionarioResultadoCabecera",inversedBy="cuestionarioResultadoRespuestas", cascade={"persist"})
     * @ORM\JoinColumn(name="resultado_cabecera_id", referencedColumnName="id")
     */
    private $resultadoCabecera;

     
     /**
     * @ORM\OneToMany(targetEntity="CuestionariosBundle\Entity\PreguntaResultadoRespuesta", mappedBy="resultadoRespuesta", cascade={"remove"})
     *
     */
    private $preguntaResultadoRespuestas;
    
    
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
     * Set textoRespuesta
     *
     * @param string $textoRespuesta
     *
     * @return CuestionarioResultadoRespuesta
     */
    public function setTextoRespuesta($textoRespuesta)
    {
        $this->textoRespuesta = $textoRespuesta;

        return $this;
    }

    /**
     * Get textoRespuesta
     *
     * @return string
     */
    public function getTextoRespuesta()
    {
        return $this->textoRespuesta;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return CuestionarioResultadoRespuesta
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
     * @return CuestionarioResultadoRespuesta
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
     * @return CuestionarioResultadoRespuesta
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
     * @return CuestionarioResultadoRespuesta
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
     * Set resultadoCabecera
     *
     * @param \CuestionariosBundle\Entity\CuestionarioResultadoCabecera $resultadoCabecera
     *
     * @return CuestionarioResultadoRespuesta
     */
    public function setResultadoCabecera(\CuestionariosBundle\Entity\CuestionarioResultadoCabecera $resultadoCabecera = null)
    {
        $this->resultadoCabecera = $resultadoCabecera;

        return $this;
    }

    /**
     * Get resultadoCabecera
     *
     * @return \CuestionariosBundle\Entity\CuestionarioResultadoCabecera
     */
    public function getResultadoCabecera()
    {
        return $this->resultadoCabecera;
    }
}
