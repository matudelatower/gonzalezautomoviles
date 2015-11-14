<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CheckControlInterno
 *
 * @ORM\Table(name="check_control_interno")
 * @ORM\Entity
 */
class CheckControlInterno
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
     * @var boolean
     *
     * @ORM\Column(name="tarjeta_inforcard", type="boolean", nullable=true)
     */
    private $tarjetaInfocard;

    /**
     * @var boolean
     *
     * @ORM\Column(name="manual_usuario", type="boolean", nullable=true)
     */
    private $manualUsuario;

    /**
     * @var boolean
     *
     * @ORM\Column(name="encendedor", type="boolean", nullable=true)
     */
    private $encendedor;

    /**
     * @var boolean
     *
     * @ORM\Column(name="alfombras", type="boolean", nullable=true)
     */
    private $alfombras;

    /**
     * @var boolean
     *
     * @ORM\Column(name="kit_seguridad", type="boolean", nullable=true)
     */
    private $kitSeguridad;

    /**
     * @var boolean
     *
     * @ORM\Column(name="rueda_auxilio", type="boolean", nullable=true)
     */
    private $ruedaAuxilio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="radio", type="boolean", nullable=true)
     */
    private $radio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="llave_ruedas", type="boolean", nullable=true)
     */
    private $llaveRuedas;

    /**
     * @var boolean
     *
     * @ORM\Column(name="control_alarma", type="boolean", nullable=true)
     */
    private $controlAlarma;

    /**
     * @var boolean
     *
     * @ORM\Column(name="manual_radio", type="boolean", nullable=true)
     */
    private $manualRadio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="gato", type="boolean", nullable=true)
     */
    private $gato;

    /**
     * @var boolean
     *
     * @ORM\Column(name="antena", type="boolean", nullable=true)
     */
    private $antena;

    /**
     * @var boolean
     *
     * @ORM\Column(name="llave", type="boolean", nullable=true)
     */
    private $llave;

    /**
     * @var string
     *
     * @ORM\Column(name="persona_entrego", type="string", length=255, nullable=true)
     */
    private $personaEntrego;


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
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Vehiculo", cascade={"persist"})
     * @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id")
     */
    private $vehiculo;

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
     * Set tarjetaInfocard
     *
     * @param boolean $tarjetaInfocard
     *
     * @return CheckControlInterno
     */
    public function setTarjetaInfocard($tarjetaInfocard)
    {
        $this->tarjetaInfocard = $tarjetaInfocard;

        return $this;
    }

    /**
     * Get tarjetaInfocard
     *
     * @return boolean
     */
    public function getTarjetaInfocard()
    {
        return $this->tarjetaInfocard;
    }

    /**
     * Set manualUsuario
     *
     * @param boolean $manualUsuario
     *
     * @return CheckControlInterno
     */
    public function setManualUsuario($manualUsuario)
    {
        $this->manualUsuario = $manualUsuario;

        return $this;
    }

    /**
     * Get manualUsuario
     *
     * @return boolean
     */
    public function getManualUsuario()
    {
        return $this->manualUsuario;
    }

    /**
     * Set encendedor
     *
     * @param boolean $encendedor
     *
     * @return CheckControlInterno
     */
    public function setEncendedor($encendedor)
    {
        $this->encendedor = $encendedor;

        return $this;
    }

    /**
     * Get encendedor
     *
     * @return boolean
     */
    public function getEncendedor()
    {
        return $this->encendedor;
    }

    /**
     * Set alfombras
     *
     * @param boolean $alfombras
     *
     * @return CheckControlInterno
     */
    public function setAlfombras($alfombras)
    {
        $this->alfombras = $alfombras;

        return $this;
    }

    /**
     * Get alfombras
     *
     * @return boolean
     */
    public function getAlfombras()
    {
        return $this->alfombras;
    }

    /**
     * Set kitSeguridad
     *
     * @param boolean $kitSeguridad
     *
     * @return CheckControlInterno
     */
    public function setKitSeguridad($kitSeguridad)
    {
        $this->kitSeguridad = $kitSeguridad;

        return $this;
    }

    /**
     * Get kitSeguridad
     *
     * @return boolean
     */
    public function getKitSeguridad()
    {
        return $this->kitSeguridad;
    }

    /**
     * Set ruedaAuxilio
     *
     * @param boolean $ruedaAuxilio
     *
     * @return CheckControlInterno
     */
    public function setRuedaAuxilio($ruedaAuxilio)
    {
        $this->ruedaAuxilio = $ruedaAuxilio;

        return $this;
    }

    /**
     * Get ruedaAuxilio
     *
     * @return boolean
     */
    public function getRuedaAuxilio()
    {
        return $this->ruedaAuxilio;
    }

    /**
     * Set radio
     *
     * @param boolean $radio
     *
     * @return CheckControlInterno
     */
    public function setRadio($radio)
    {
        $this->radio = $radio;

        return $this;
    }

    /**
     * Get radio
     *
     * @return boolean
     */
    public function getRadio()
    {
        return $this->radio;
    }

    /**
     * Set llaveRuedas
     *
     * @param boolean $llaveRuedas
     *
     * @return CheckControlInterno
     */
    public function setLlaveRuedas($llaveRuedas)
    {
        $this->llaveRuedas = $llaveRuedas;

        return $this;
    }

    /**
     * Get llaveRuedas
     *
     * @return boolean
     */
    public function getLlaveRuedas()
    {
        return $this->llaveRuedas;
    }

    /**
     * Set controlAlarma
     *
     * @param boolean $controlAlarma
     *
     * @return CheckControlInterno
     */
    public function setControlAlarma($controlAlarma)
    {
        $this->controlAlarma = $controlAlarma;

        return $this;
    }

    /**
     * Get controlAlarma
     *
     * @return boolean
     */
    public function getControlAlarma()
    {
        return $this->controlAlarma;
    }

    /**
     * Set manualRadio
     *
     * @param boolean $manualRadio
     *
     * @return CheckControlInterno
     */
    public function setManualRadio($manualRadio)
    {
        $this->manualRadio = $manualRadio;

        return $this;
    }

    /**
     * Get manualRadio
     *
     * @return boolean
     */
    public function getManualRadio()
    {
        return $this->manualRadio;
    }

    /**
     * Set gato
     *
     * @param boolean $gato
     *
     * @return CheckControlInterno
     */
    public function setGato($gato)
    {
        $this->gato = $gato;

        return $this;
    }

    /**
     * Get gato
     *
     * @return boolean
     */
    public function getGato()
    {
        return $this->gato;
    }

    /**
     * Set antena
     *
     * @param boolean $antena
     *
     * @return CheckControlInterno
     */
    public function setAntena($antena)
    {
        $this->antena = $antena;

        return $this;
    }

    /**
     * Get antena
     *
     * @return boolean
     */
    public function getAntena()
    {
        return $this->antena;
    }

    /**
     * Set llave
     *
     * @param boolean $llave
     *
     * @return CheckControlInterno
     */
    public function setLlave($llave)
    {
        $this->llave = $llave;

        return $this;
    }

    /**
     * Get llave
     *
     * @return boolean
     */
    public function getLlave()
    {
        return $this->llave;
    }

    /**
     * Set personaEntrego
     *
     * @param string $personaEntrego
     *
     * @return CheckControlInterno
     */
    public function setPersonaEntrego($personaEntrego)
    {
        $this->personaEntrego = $personaEntrego;

        return $this;
    }

    /**
     * Get personaEntrego
     *
     * @return string
     */
    public function getPersonaEntrego()
    {
        return $this->personaEntrego;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return CheckControlInterno
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
     * @return CheckControlInterno
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
     * @return CheckControlInterno
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
     * @return CheckControlInterno
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
     * Set vehiculo
     *
     * @param \VehiculosBundle\Entity\Vehiculo $vehiculo
     *
     * @return CheckControlInterno
     */
    public function setVehiculo(\VehiculosBundle\Entity\Vehiculo $vehiculo = null)
    {
        $this->vehiculo = $vehiculo;

        return $this;
    }

    /**
     * Get vehiculo
     *
     * @return \VehiculosBundle\Entity\Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }
}
