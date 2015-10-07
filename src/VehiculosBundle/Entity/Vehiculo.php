<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vehiculo
 *
 * @ORM\Table(name="vehiculos")
 * @ORM\Entity(repositoryClass="VehiculosBundle\Entity\VehiculoRepository")
 */
class Vehiculo
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
     * @ORM\Column(name="vin", type="string", length=255)
     */
    private $vin;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_vehiculo", type="string", length=255)
     */
    private $nombreVehiculo;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", length=255)
     */
    private $modelo;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio_fabricacion", type="integer")
     */
    private $anioFabricacion;

    /**
     * @var string
     *
     * @ORM\Column(name="motor", type="string", length=255)
     */
    private $motor;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_llave", type="string", length=255)
     */
    private $codigoLlave;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_radio", type="string", length=255)
     */
    private $codigoRadio;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_seguridad", type="string", length=255)
     */
    private $codigoSeguridad;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_inmovilizador", type="string", length=255)
     */
    private $codigoInmovilizador;

    /**
     * @var string
     *
     * @ORM\Column(name="color_interno", type="string", length=255)
     */
    private $colorInterno;

    /**
     * @var string
     *
     * @ORM\Column(name="color_externo", type="string", length=255)
     */
    private $colorExterno;

    /**
     * @var string
     *
     * @ORM\Column(name="km_ingreso", type="string", length=255)
     */
    private $kmIngreso;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    private $observacion;


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
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Remito")
     * @ORM\JoinColumn(name="remito_id", referencedColumnName="id",nullable=true)
     */
    private $remito;

    /**
     * @ORM\ManyToOne(targetEntity="PersonasBundle\Entity\Persona")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id",nullable=true)
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\TipoCompra")
     * @ORM\JoinColumn(name="tipo_compra_id", referencedColumnName="id")
     */
    private $tipoCompra;
    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Factura")
     * @ORM\JoinColumn(name="factura_id", referencedColumnName="id", nullable=true)
     */
    private $factura;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Patentamiento")
     * @ORM\JoinColumn(name="patentamiento_id", referencedColumnName="id",nullable=true)
     */
    private $patentamiento;


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
     * Set vin
     *
     * @param string $vin
     *
     * @return Vehiculo
     */
    public function setVin($vin)
    {
        $this->vin = $vin;

        return $this;
    }

    /**
     * Get vin
     *
     * @return string
     */
    public function getVin()
    {
        return $this->vin;
    }

    /**
     * Set nombreVehiculo
     *
     * @param string $nombreVehiculo
     *
     * @return Vehiculo
     */
    public function setNombreVehiculo($nombreVehiculo)
    {
        $this->nombreVehiculo = $nombreVehiculo;

        return $this;
    }

    /**
     * Get nombreVehiculo
     *
     * @return string
     */
    public function getNombreVehiculo()
    {
        return $this->nombreVehiculo;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     *
     * @return Vehiculo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set anioFabricacion
     *
     * @param integer $anioFabricacion
     *
     * @return Vehiculo
     */
    public function setAnioFabricacion($anioFabricacion)
    {
        $this->anioFabricacion = $anioFabricacion;

        return $this;
    }

    /**
     * Get anioFabricacion
     *
     * @return integer
     */
    public function getAnioFabricacion()
    {
        return $this->anioFabricacion;
    }

    /**
     * Set motor
     *
     * @param string $motor
     *
     * @return Vehiculo
     */
    public function setMotor($motor)
    {
        $this->motor = $motor;

        return $this;
    }

    /**
     * Get motor
     *
     * @return string
     */
    public function getMotor()
    {
        return $this->motor;
    }

    /**
     * Set codigoLlave
     *
     * @param string $codigoLlave
     *
     * @return Vehiculo
     */
    public function setCodigoLlave($codigoLlave)
    {
        $this->codigoLlave = $codigoLlave;

        return $this;
    }

    /**
     * Get codigoLlave
     *
     * @return string
     */
    public function getCodigoLlave()
    {
        return $this->codigoLlave;
    }

    /**
     * Set codigoRadio
     *
     * @param string $codigoRadio
     *
     * @return Vehiculo
     */
    public function setCodigoRadio($codigoRadio)
    {
        $this->codigoRadio = $codigoRadio;

        return $this;
    }

    /**
     * Get codigoRadio
     *
     * @return string
     */
    public function getCodigoRadio()
    {
        return $this->codigoRadio;
    }

    /**
     * Set codigoSeguridad
     *
     * @param string $codigoSeguridad
     *
     * @return Vehiculo
     */
    public function setCodigoSeguridad($codigoSeguridad)
    {
        $this->codigoSeguridad = $codigoSeguridad;

        return $this;
    }

    /**
     * Get codigoSeguridad
     *
     * @return string
     */
    public function getCodigoSeguridad()
    {
        return $this->codigoSeguridad;
    }

    /**
     * Set codigoInmovilizador
     *
     * @param string $codigoInmovilizador
     *
     * @return Vehiculo
     */
    public function setCodigoInmovilizador($codigoInmovilizador)
    {
        $this->codigoInmovilizador = $codigoInmovilizador;

        return $this;
    }

    /**
     * Get codigoInmovilizador
     *
     * @return string
     */
    public function getCodigoInmovilizador()
    {
        return $this->codigoInmovilizador;
    }

    /**
     * Set colorInterno
     *
     * @param string $colorInterno
     *
     * @return Vehiculo
     */
    public function setColorInterno($colorInterno)
    {
        $this->colorInterno = $colorInterno;

        return $this;
    }

    /**
     * Get colorInterno
     *
     * @return string
     */
    public function getColorInterno()
    {
        return $this->colorInterno;
    }

    /**
     * Set colorExterno
     *
     * @param string $colorExterno
     *
     * @return Vehiculo
     */
    public function setColorExterno($colorExterno)
    {
        $this->colorExterno = $colorExterno;

        return $this;
    }

    /**
     * Get colorExterno
     *
     * @return string
     */
    public function getColorExterno()
    {
        return $this->colorExterno;
    }

    /**
     * Set kmIngreso
     *
     * @param string $kmIngreso
     *
     * @return Vehiculo
     */
    public function setKmIngreso($kmIngreso)
    {
        $this->kmIngreso = $kmIngreso;

        return $this;
    }

    /**
     * Get kmIngreso
     *
     * @return string
     */
    public function getKmIngreso()
    {
        return $this->kmIngreso;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     *
     * @return Vehiculo
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return Vehiculo
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
     * @return Vehiculo
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
     * @return Vehiculo
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
     * @return Vehiculo
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
     * Set remito
     *
     * @param \VehiculosBundle\Entity\Remito $remito
     *
     * @return Vehiculo
     */
    public function setRemito(\VehiculosBundle\Entity\Remito $remito = null)
    {
        $this->remito = $remito;

        return $this;
    }

    /**
     * Get remito
     *
     * @return \VehiculosBundle\Entity\Remito
     */
    public function getRemito()
    {
        return $this->remito;
    }

    /**
     * Set cliente
     *
     * @param \PersonasBundle\Entity\Persona $cliente
     *
     * @return Vehiculo
     */
    public function setCliente(\PersonasBundle\Entity\Persona $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \PersonasBundle\Entity\Persona
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set tipoCompra
     *
     * @param \VehiculosBundle\Entity\TipoCompra $tipoCompra
     *
     * @return Vehiculo
     */
    public function setTipoCompra(\VehiculosBundle\Entity\TipoCompra $tipoCompra = null)
    {
        $this->tipoCompra = $tipoCompra;

        return $this;
    }

    /**
     * Get tipoCompra
     *
     * @return \VehiculosBundle\Entity\TipoCompra
     */
    public function getTipoCompra()
    {
        return $this->tipoCompra;
    }

    /**
     * Set factura
     *
     * @param \VehiculosBundle\Entity\Factura $factura
     *
     * @return Vehiculo
     */
    public function setFactura(\VehiculosBundle\Entity\Factura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \VehiculosBundle\Entity\Factura
     */
    public function getFactura()
    {
        return $this->factura;
    }

    /**
     * Set patentamiento
     *
     * @param \VehiculosBundle\Entity\Patentamiento $patentamiento
     *
     * @return Vehiculo
     */
    public function setPatentamiento(\VehiculosBundle\Entity\Patentamiento $patentamiento = null)
    {
        $this->patentamiento = $patentamiento;

        return $this;
    }

    /**
     * Get patentamiento
     *
     * @return \VehiculosBundle\Entity\Patentamiento
     */
    public function getPatentamiento()
    {
        return $this->patentamiento;
    }
}
