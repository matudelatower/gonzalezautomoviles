<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * DanioVehiculoGm
 *
 * @ORM\Table(name="danios_vehiculo_gm")
 * @ORM\Entity
 */
class DanioVehiculoGm
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
     * @ORM\Column(name="numero_orden_arreglo", type="string", length=255, nullable=true)
     */
    private $numeroOrdenArreglo;

    /**
     * @var string
     *
     * @ORM\Column(name="solucionado", type="boolean",nullable=true)
     */
    private $solucionado;


    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\Vehiculo", inversedBy="danioVehiculoGm")
     * @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id")
     */
    private $vehiculo;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\TipoDanioGm")
     * @ORM\JoinColumn(name="tipo_danio_id", referencedColumnName="id")
     */
    private $tipoDanio;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\CodigoDanioGm")
     * @ORM\JoinColumn(name="codigo_danio_id", referencedColumnName="id")
     */
    private $codigoDanio;

    /**
     * @ORM\ManyToOne(targetEntity="VehiculosBundle\Entity\GravedadDanioGm")
     * @ORM\JoinColumn(name="gravedad_danio_id", referencedColumnName="id")
     */
    private $gravedadDanio;

    /**
     *
     * @ORM\OneToMany(targetEntity="VehiculosBundle\Entity\FotoDanioGm", mappedBy="danioVehiculo", cascade={"persist"})
     */
    private $fotoDanio;

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
     * Constructor
     */
    public function __construct()
    {
        $this->fotoDanio = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numeroOrdenArreglo
     *
     * @param string $numeroOrdenArreglo
     *
     * @return DanioVehiculoGm
     */
    public function setNumeroOrdenArreglo($numeroOrdenArreglo)
    {
        $this->numeroOrdenArreglo = $numeroOrdenArreglo;

        return $this;
    }

    /**
     * Get numeroOrdenArreglo
     *
     * @return string
     */
    public function getNumeroOrdenArreglo()
    {
        return $this->numeroOrdenArreglo;
    }

    /**
     * Set solucionado
     *
     * @param boolean $solucionado
     *
     * @return DanioVehiculoGm
     */
    public function setSolucionado($solucionado)
    {
        $this->solucionado = $solucionado;

        return $this;
    }

    /**
     * Get solucionado
     *
     * @return boolean
     */
    public function getSolucionado()
    {
        return $this->solucionado;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return DanioVehiculoGm
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
     * @return DanioVehiculoGm
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
     * Set vehiculo
     *
     * @param \VehiculosBundle\Entity\Vehiculo $vehiculo
     *
     * @return DanioVehiculoGm
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

    /**
     * Set tipoDanio
     *
     * @param \VehiculosBundle\Entity\TipoDanioGm $tipoDanio
     *
     * @return DanioVehiculoGm
     */
    public function setTipoDanio(\VehiculosBundle\Entity\TipoDanioGm $tipoDanio = null)
    {
        $this->tipoDanio = $tipoDanio;

        return $this;
    }

    /**
     * Get tipoDanio
     *
     * @return \VehiculosBundle\Entity\TipoDanioGm
     */
    public function getTipoDanio()
    {
        return $this->tipoDanio;
    }

    /**
     * Set codigoDanio
     *
     * @param \VehiculosBundle\Entity\CodigoDanioGm $codigoDanio
     *
     * @return DanioVehiculoGm
     */
    public function setCodigoDanio(\VehiculosBundle\Entity\CodigoDanioGm $codigoDanio = null)
    {
        $this->codigoDanio = $codigoDanio;

        return $this;
    }

    /**
     * Get codigoDanio
     *
     * @return \VehiculosBundle\Entity\CodigoDanioGm
     */
    public function getCodigoDanio()
    {
        return $this->codigoDanio;
    }

    /**
     * Set gravedadDanio
     *
     * @param \VehiculosBundle\Entity\GravedadDanioGm $gravedadDanio
     *
     * @return DanioVehiculoGm
     */
    public function setGravedadDanio(\VehiculosBundle\Entity\GravedadDanioGm $gravedadDanio = null)
    {
        $this->gravedadDanio = $gravedadDanio;

        return $this;
    }

    /**
     * Get gravedadDanio
     *
     * @return \VehiculosBundle\Entity\GravedadDanioGm
     */
    public function getGravedadDanio()
    {
        return $this->gravedadDanio;
    }

    /**
     * Add fotoDanio
     *
     * @param \VehiculosBundle\Entity\FotoDanioGm $fotoDanio
     *
     * @return DanioVehiculoGm
     */
    public function addFotoDanio(\VehiculosBundle\Entity\FotoDanioGm $fotoDanio)
    {
        $this->fotoDanio[] = $fotoDanio;

        return $this;
    }

    public function setFotoDanio(\VehiculosBundle\Entity\FotoDanioGm $fotoDanio)
    {
        $this->fotoDanio[] = $fotoDanio;

        return $this;
    }

    /**
     * Remove fotoDanio
     *
     * @param \VehiculosBundle\Entity\FotoDanioGm $fotoDanio
     */
    public function removeFotoDanio(\VehiculosBundle\Entity\FotoDanioGm $fotoDanio)
    {
        $this->fotoDanio->removeElement($fotoDanio);
    }

    /**
     * Get fotoDanio
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFotoDanio()
    {
        return $this->fotoDanio;
    }

    /**
     * Set creadoPor
     *
     * @param \UsuariosBundle\Entity\Usuario $creadoPor
     *
     * @return DanioVehiculoGm
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
     * @return DanioVehiculoGm
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
