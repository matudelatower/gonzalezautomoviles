<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CheckControlInternoResultadoRespuesta
 *
 * @ORM\Table(name="check_control_interno_resultado_respuestas")
 * @ORM\Entity
 */
class CheckControlInternoResultadoRespuesta {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="respuesta", type="boolean")
     */
    private $respuesta;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\CheckControlInternoPregunta")
     * @ORM\JoinColumn(name="check_control_interno_pregunta_id", referencedColumnName="id")
     */
    private $checkControlInternoPregunta;
    
    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\CheckControlInternoResultadoCabecera")
     * @ORM\JoinColumn(name="check_control_interno_resultado_cabecera_id", referencedColumnName="id")
     */
    private $checkControlInternoResultadoCabecera;

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
     * Set respuesta
     *
     * @param boolean $respuesta
     *
     * @return CheckControlInternoResultadoRespuesta
     */
    public function setRespuesta($respuesta) {
        $this->respuesta = $respuesta;

        return $this;
    }

    /**
     * Get respuesta
     *
     * @return boolean
     */
    public function getRespuesta() {
        return $this->respuesta;
    }


    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return CheckControlInternoResultadoRespuesta
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
     * @return CheckControlInternoResultadoRespuesta
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
     * Set checkControlInternoPregunta
     *
     * @param \VehiculosBundle\Entity\CheckControlInternoPregunta $checkControlInternoPregunta
     *
     * @return CheckControlInternoResultadoRespuesta
     */
    public function setCheckControlInternoPregunta(\VehiculosBundle\Entity\CheckControlInternoPregunta $checkControlInternoPregunta = null)
    {
        $this->checkControlInternoPregunta = $checkControlInternoPregunta;

        return $this;
    }

    /**
     * Get checkControlInternoPregunta
     *
     * @return \VehiculosBundle\Entity\CheckControlInternoPregunta
     */
    public function getCheckControlInternoPregunta()
    {
        return $this->checkControlInternoPregunta;
    }

    /**
     * Set checkControlInternoResultadoCabecera
     *
     * @param \VehiculosBundle\Entity\CheckControlInternoResultadoCabecera $checkControlInternoResultadoCabecera
     *
     * @return CheckControlInternoResultadoRespuesta
     */
    public function setCheckControlInternoResultadoCabecera(\VehiculosBundle\Entity\CheckControlInternoResultadoCabecera $checkControlInternoResultadoCabecera = null)
    {
        $this->checkControlInternoResultadoCabecera = $checkControlInternoResultadoCabecera;

        return $this;
    }

    /**
     * Get checkControlInternoResultadoCabecera
     *
     * @return \VehiculosBundle\Entity\CheckControlInternoResultadoCabecera
     */
    public function getCheckControlInternoResultadoCabecera()
    {
        return $this->checkControlInternoResultadoCabecera;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return CheckControlInternoResultadoRespuesta
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
     * @return CheckControlInternoResultadoRespuesta
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
