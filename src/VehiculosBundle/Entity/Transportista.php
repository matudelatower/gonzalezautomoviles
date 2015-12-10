<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Transportista
 *
 * @ORM\Table(name="transportistas")
 * @ORM\Entity
 */
class Transportista {
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
	 * @ORM\Column(name="cuit", type="string", length=255)
	 */
	private $cuit;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="apellido", type="string", length=255)
	 */
	private $apellido;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="nombre", type="string", length=255)
	 */
	private $nombre;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="telefono", type="string", length=255, nullable=true)
	 */
	private $telefono;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="domicilio", type="string", length=255, nullable=true)
	 */
	private $domicilio;

	/**
	 * @ORM\OneToMany(targetEntity="VehiculosBundle\Entity\Vehiculo", mappedBy="transportista", cascade={"persist"})
	 *
	 */
	private $vehiculo;

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

	public function __toString() {
		return $this->apellido . ", " . $this->nombre;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->vehiculo = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set cuit
	 *
	 * @param string $cuit
	 *
	 * @return Transportista
	 */
	public function setCuit( $cuit ) {
		$this->cuit = $cuit;

		return $this;
	}

	/**
	 * Get cuit
	 *
	 * @return string
	 */
	public function getCuit() {
		return $this->cuit;
	}

	/**
	 * Set apellido
	 *
	 * @param string $apellido
	 *
	 * @return Transportista
	 */
	public function setApellido( $apellido ) {
		$this->apellido = $apellido;

		return $this;
	}

	/**
	 * Get apellido
	 *
	 * @return string
	 */
	public function getApellido() {
		return $this->apellido;
	}

	/**
	 * Set nombre
	 *
	 * @param string $nombre
	 *
	 * @return Transportista
	 */
	public function setNombre( $nombre ) {
		$this->nombre = $nombre;

		return $this;
	}

	/**
	 * Get nombre
	 *
	 * @return string
	 */
	public function getNombre() {
		return $this->nombre;
	}

	/**
	 * Set telefono
	 *
	 * @param string $telefono
	 *
	 * @return Transportista
	 */
	public function setTelefono( $telefono ) {
		$this->telefono = $telefono;

		return $this;
	}

	/**
	 * Get telefono
	 *
	 * @return string
	 */
	public function getTelefono() {
		return $this->telefono;
	}

	/**
	 * Set domicilio
	 *
	 * @param string $domicilio
	 *
	 * @return Transportista
	 */
	public function setDomicilio( $domicilio ) {
		$this->domicilio = $domicilio;

		return $this;
	}

	/**
	 * Get domicilio
	 *
	 * @return string
	 */
	public function getDomicilio() {
		return $this->domicilio;
	}

	/**
	 * Set creado
	 *
	 * @param \DateTime $creado
	 *
	 * @return Transportista
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
	 * @return Transportista
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
	 * Add vehiculo
	 *
	 * @param \VehiculosBundle\Entity\Vehiculo $vehiculo
	 *
	 * @return Transportista
	 */
	public function addVehiculo( \VehiculosBundle\Entity\Vehiculo $vehiculo ) {
		$this->vehiculo[] = $vehiculo;

		return $this;
	}

	/**
	 * Remove vehiculo
	 *
	 * @param \VehiculosBundle\Entity\Vehiculo $vehiculo
	 */
	public function removeVehiculo( \VehiculosBundle\Entity\Vehiculo $vehiculo ) {
		$this->vehiculo->removeElement( $vehiculo );
	}

	/**
	 * Get vehiculo
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getVehiculo() {
		return $this->vehiculo;
	}

	/**
	 * Set creadoPor
	 *
	 * @param \UsuariosBundle\Entity\Usuario $creadoPor
	 *
	 * @return Transportista
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
	 * @return Transportista
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
}
