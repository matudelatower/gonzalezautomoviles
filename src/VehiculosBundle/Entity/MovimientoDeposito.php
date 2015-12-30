<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MovimientoDeposito
 *
 * @ORM\Table(name="movimientos_depositos")
 * @ORM\Entity
 */
class MovimientoDeposito {

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fecha_ingreso", type="datetime")
	 */
	private $fechaIngreso;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fecha_egreso", type="datetime", nullable=true)
	 */
	private $fechaEgreso;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="fila", type="string", length=255,nullable=true)
	 */
	private $fila;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="posicion", type="string", length=255, nullable=true)
	 */
	private $posicion;

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
	 * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Deposito")
	 * @ORM\JoinColumn(name="deposito_origen_id", referencedColumnName="id",nullable=true)
	 */
	private $depositoOrigen;

	/**
	 * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Deposito")
	 * @ORM\JoinColumn(name="deposito_destino_id", referencedColumnName="id",nullable=false)
	 */
	private $depositoDestino;

	/**
	 * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\TipoMovimiento")
	 * @ORM\JoinColumn(name="tipo_movimiento_id", referencedColumnName="id")
	 */
	private $tipoMovimiento;

	/**
	 * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Vehiculo", inversedBy="movimientoDeposito")
	 * @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id",nullable=true)
	 */
	private $vehiculo;

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set fechaIngreso
	 *
	 * @param \DateTime $fechaIngreso
	 *
	 * @return MovimientoDeposito
	 */
	public function setFechaIngreso( $fechaIngreso ) {
		$this->fechaIngreso = $fechaIngreso;

		return $this;
	}

	/**
	 * Get fechaIngreso
	 *
	 * @return \DateTime
	 */
	public function getFechaIngreso() {
		return $this->fechaIngreso;
	}

	/**
	 * Set fechaEgreso
	 *
	 * @param \DateTime $fechaEgreso
	 *
	 * @return MovimientoDeposito
	 */
	public function setFechaEgreso( $fechaEgreso ) {
		$this->fechaEgreso = $fechaEgreso;

		return $this;
	}

	/**
	 * Get fechaEgreso
	 *
	 * @return \DateTime
	 */
	public function getFechaEgreso() {
		return $this->fechaEgreso;
	}

	/**
	 * Set fila
	 *
	 * @param string $fila
	 *
	 * @return MovimientoDeposito
	 */
	public function setFila( $fila ) {
		$this->fila = $fila;

		return $this;
	}

	/**
	 * Get fila
	 *
	 * @return string
	 */
	public function getFila() {
		return $this->fila;
	}

	/**
	 * Set posicion
	 *
	 * @param string $posicion
	 *
	 * @return MovimientoDeposito
	 */
	public function setPosicion( $posicion ) {
		$this->posicion = $posicion;

		return $this;
	}

	/**
	 * Get posicion
	 *
	 * @return string
	 */
	public function getPosicion() {
		return $this->posicion;
	}

	/**
	 * Set observacion
	 *
	 * @param string $observacion
	 *
	 * @return MovimientoDeposito
	 */
	public function setObservacion( $observacion ) {
		$this->observacion = $observacion;

		return $this;
	}

	/**
	 * Get observacion
	 *
	 * @return string
	 */
	public function getObservacion() {
		return $this->observacion;
	}

	/**
	 * Set creado
	 *
	 * @param \DateTime $creado
	 *
	 * @return MovimientoDeposito
	 */
	public function setCreado( $creado ) {
		$this->creado = $creado;

		return $this;
	}

	/**
	 * Get creado
	 *
	 * @return \DateTime
	 */
	public function getCreado() {
		return $this->creado;
	}

	/**
	 * Set actualizado
	 *
	 * @param \DateTime $actualizado
	 *
	 * @return MovimientoDeposito
	 */
	public function setActualizado( $actualizado ) {
		$this->actualizado = $actualizado;

		return $this;
	}

	/**
	 * Get actualizado
	 *
	 * @return \DateTime
	 */
	public function getActualizado() {
		return $this->actualizado;
	}

	/**
	 * Set creadoPor
	 *
	 * @param \UsuariosBundle\Entity\Usuario $creadoPor
	 *
	 * @return MovimientoDeposito
	 */
	public function setCreadoPor( \UsuariosBundle\Entity\Usuario $creadoPor = null ) {
		$this->creadoPor = $creadoPor;

		return $this;
	}

	/**
	 * Get creadoPor
	 *
	 * @return \UsuariosBundle\Entity\Usuario
	 */
	public function getCreadoPor() {
		return $this->creadoPor;
	}

	/**
	 * Set actualizadoPor
	 *
	 * @param \UsuariosBundle\Entity\Usuario $actualizadoPor
	 *
	 * @return MovimientoDeposito
	 */
	public function setActualizadoPor( \UsuariosBundle\Entity\Usuario $actualizadoPor = null ) {
		$this->actualizadoPor = $actualizadoPor;

		return $this;
	}

	/**
	 * Get actualizadoPor
	 *
	 * @return \UsuariosBundle\Entity\Usuario
	 */
	public function getActualizadoPor() {
		return $this->actualizadoPor;
	}

	/**
	 * Set depositoOrigen
	 *
	 * @param \VehiculosBundle\Entity\Deposito $depositoOrigen
	 *
	 * @return MovimientoDeposito
	 */
	public function setDepositoOrigen( \VehiculosBundle\Entity\Deposito $depositoOrigen = null ) {
		$this->depositoOrigen = $depositoOrigen;

		return $this;
	}

	/**
	 * Get depositoOrigen
	 *
	 * @return \VehiculosBundle\Entity\Deposito
	 */
	public function getDepositoOrigen() {
		return $this->depositoOrigen;
	}

	/**
	 * Set depositoDestino
	 *
	 * @param \VehiculosBundle\Entity\Deposito $depositoDestino
	 *
	 * @return MovimientoDeposito
	 */
	public function setDepositoDestino( \VehiculosBundle\Entity\Deposito $depositoDestino ) {
		$this->depositoDestino = $depositoDestino;

		return $this;
	}

	/**
	 * Get depositoDestino
	 *
	 * @return \VehiculosBundle\Entity\Deposito
	 */
	public function getDepositoDestino() {
		return $this->depositoDestino;
	}

	/**
	 * Set tipoMovimiento
	 *
	 * @param \VehiculosBundle\Entity\TipoMovimiento $tipoMovimiento
	 *
	 * @return MovimientoDeposito
	 */
	public function setTipoMovimiento( \VehiculosBundle\Entity\TipoMovimiento $tipoMovimiento = null ) {
		$this->tipoMovimiento = $tipoMovimiento;

		return $this;
	}

	/**
	 * Get tipoMovimiento
	 *
	 * @return \VehiculosBundle\Entity\TipoMovimiento
	 */
	public function getTipoMovimiento() {
		return $this->tipoMovimiento;
	}

	/**
	 * Set vehiculo
	 *
	 * @param \VehiculosBundle\Entity\Vehiculo $vehiculo
	 *
	 * @return MovimientoDeposito
	 */
	public function setVehiculo( \VehiculosBundle\Entity\Vehiculo $vehiculo = null ) {
		$this->vehiculo = $vehiculo;

		return $this;
	}

	/**
	 * Get vehiculo
	 *
	 * @return \VehiculosBundle\Entity\Vehiculo
	 */
	public function getVehiculo() {
		return $this->vehiculo;
	}

}
