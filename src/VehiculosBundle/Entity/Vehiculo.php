<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Vehiculo
 *
 * @ORM\Table(name="vehiculos")
 * @ORM\Entity(repositoryClass="VehiculosBundle\Entity\VehiculoRepository")
 * @UniqueEntity("vin")
 * @UniqueEntity("chasis")
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
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\CodigoModelo")
     * @ORM\JoinColumn(name="codigo_modelo_id", referencedColumnName="id",nullable=true)
     */
    private $modelo;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio_fabricacion", type="integer", nullable=true)
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
     * @ORM\Column(name="codigo_llave", type="string", length=255, nullable=true)
     */
    private $codigoLlave;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_radio", type="string", length=255, nullable=true)
     */
    private $codigoRadio;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_seguridad", type="string", length=255, nullable=true)
     */
    private $codigoSeguridad;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo_inmovilizador", type="string", length=255, nullable=true)
     */
    private $codigoInmovilizador;

    /**
     * @var string
     *
     * @ORM\Column(name="color_interno", type="string", length=255, nullable=true)
     */
    private $colorInterno;

    /**
     * @var string
     *
     * @ORM\Column(name="color_externo", type="string", length=255, nullable=true)
     */
    private $colorExterno;

    /**
     * @var string
     *
     * @ORM\Column(name="km_ingreso", type="string", length=255, nullable=true)
     */
    private $kmIngreso;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", nullable=true, nullable=true)
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
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Remito", cascade={"persist"})
     * @ORM\JoinColumn(name="remito_id", referencedColumnName="id",nullable=true)
     */
    private $remito;

    /**
     * @ORM\ManyToOne(targetEntity="ClientesBundle\Entity\Cliente")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id",nullable=true)
     */
    private $cliente;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\TipoVentaEspecial")
     * @ORM\JoinColumn(name="tipo_venta_especial_id", referencedColumnName="id", nullable=true))
     */
    private $tipoVentaEspecial;
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
     * @ORM\OneToMany(targetEntity="VehiculosBundle\Entity\EstadoVehiculo", mappedBy="vehiculo", cascade={"persist"})
     *
     */
    private $estadoVehiculo;

    /**
     * @var string
     *
     * @ORM\Column(name="chasis", type="string", length=255)
     */
    private $chasis;

    /**
     * @var string
     *
     * @ORM\Column(name="documento", type="string", length=255)
     */
    private $documento;

    /**
     * @var string
     *
     * @ORM\Column(name="importe", type="decimal")
     */
    private $importe;

    /**
     * @var string
     *
     * @ORM\Column(name="impuestos", type="decimal")
     */
    private $impuestos;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_pedido", type="string", length=255)
     */
    private $numeroPedido;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_orden", type="string", length=255, nullable=true)
     */
    private $numeroOrden;


    /**
     * @var string
     *
     * @ORM\Column(name="numero_grupo", type="string", length=255, nullable=true)
     */
    private $numeroGrupo;


    /**
     * @var string
     *
     * @ORM\Column(name="numero_solicitud", type="string", length=255, nullable=true)
     */
    private $numeroSolicitud;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Transportista", inversedBy="vehiculo")
     * @ORM\JoinColumn(name="transportista_id", referencedColumnName="id",nullable=true)
     */
    private $transportista;


    public function __toString()
    {
        return $this->vin;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estadoVehiculo = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set chasis
     *
     * @param string $chasis
     *
     * @return Vehiculo
     */
    public function setChasis($chasis)
    {
        $this->chasis = $chasis;

        return $this;
    }

    /**
     * Get chasis
     *
     * @return string
     */
    public function getChasis()
    {
        return $this->chasis;
    }

    /**
     * Set documento
     *
     * @param string $documento
     *
     * @return Vehiculo
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return Vehiculo
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set impuestos
     *
     * @param string $impuestos
     *
     * @return Vehiculo
     */
    public function setImpuestos($impuestos)
    {
        $this->impuestos = $impuestos;

        return $this;
    }

    /**
     * Get impuestos
     *
     * @return string
     */
    public function getImpuestos()
    {
        return $this->impuestos;
    }

    /**
     * Set numeroPedido
     *
     * @param string $numeroPedido
     *
     * @return Vehiculo
     */
    public function setNumeroPedido($numeroPedido)
    {
        $this->numeroPedido = $numeroPedido;

        return $this;
    }

    /**
     * Get numeroPedido
     *
     * @return string
     */
    public function getNumeroPedido()
    {
        return $this->numeroPedido;
    }

    /**
     * Set numeroOrden
     *
     * @param string $numeroOrden
     *
     * @return Vehiculo
     */
    public function setNumeroOrden($numeroOrden)
    {
        $this->numeroOrden = $numeroOrden;

        return $this;
    }

    /**
     * Get numeroOrden
     *
     * @return string
     */
    public function getNumeroOrden()
    {
        return $this->numeroOrden;
    }

    /**
     * Set numeroGrupo
     *
     * @param string $numeroGrupo
     *
     * @return Vehiculo
     */
    public function setNumeroGrupo($numeroGrupo)
    {
        $this->numeroGrupo = $numeroGrupo;

        return $this;
    }

    /**
     * Get numeroGrupo
     *
     * @return string
     */
    public function getNumeroGrupo()
    {
        return $this->numeroGrupo;
    }

    /**
     * Set numeroSolicitud
     *
     * @param string $numeroSolicitud
     *
     * @return Vehiculo
     */
    public function setNumeroSolicitud($numeroSolicitud)
    {
        $this->numeroSolicitud = $numeroSolicitud;

        return $this;
    }

    /**
     * Get numeroSolicitud
     *
     * @return string
     */
    public function getNumeroSolicitud()
    {
        return $this->numeroSolicitud;
    }

    /**
     * Set modelo
     *
     * @param \VehiculosBundle\Entity\CodigoModelo $modelo
     *
     * @return Vehiculo
     */
    public function setModelo(\VehiculosBundle\Entity\CodigoModelo $modelo = null)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return \VehiculosBundle\Entity\CodigoModelo
     */
    public function getModelo()
    {
        return $this->modelo;
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
     * @param \ClientesBundle\Entity\Cliente $cliente
     *
     * @return Vehiculo
     */
    public function setCliente(\ClientesBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \ClientesBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set tipoVentaEspecial
     *
     * @param \VehiculosBundle\Entity\TipoVentaEspecial $tipoVentaEspecial
     *
     * @return Vehiculo
     */
    public function setTipoVentaEspecial(\VehiculosBundle\Entity\TipoVentaEspecial $tipoVentaEspecial = null)
    {
        $this->tipoVentaEspecial = $tipoVentaEspecial;

        return $this;
    }

    /**
     * Get tipoVentaEspecial
     *
     * @return \VehiculosBundle\Entity\TipoVentaEspecial
     */
    public function getTipoVentaEspecial()
    {
        return $this->tipoVentaEspecial;
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

    /**
     * Add estadoVehiculo
     *
     * @param \VehiculosBundle\Entity\EstadoVehiculo $estadoVehiculo
     *
     * @return Vehiculo
     */
    public function addEstadoVehiculo(\VehiculosBundle\Entity\EstadoVehiculo $estadoVehiculo)
    {
        $this->estadoVehiculo[] = $estadoVehiculo;

        return $this;
    }

    /**
     * Remove estadoVehiculo
     *
     * @param \VehiculosBundle\Entity\EstadoVehiculo $estadoVehiculo
     */
    public function removeEstadoVehiculo(\VehiculosBundle\Entity\EstadoVehiculo $estadoVehiculo)
    {
        $this->estadoVehiculo->removeElement($estadoVehiculo);
    }

    /**
     * Get estadoVehiculo
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstadoVehiculo()
    {
        return $this->estadoVehiculo;
    }

    /**
     * Set transportista
     *
     * @param \VehiculosBundle\Entity\Transportista $transportista
     *
     * @return Vehiculo
     */
    public function setTransportista(\VehiculosBundle\Entity\Transportista $transportista = null)
    {
        $this->transportista = $transportista;

        return $this;
    }

    /**
     * Get transportista
     *
     * @return \VehiculosBundle\Entity\Transportista
     */
    public function getTransportista()
    {
        return $this->transportista;
    }
}
