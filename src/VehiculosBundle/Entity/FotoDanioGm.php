<?php

namespace VehiculosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FotoDanioGm
 *
 * @ORM\Table(name="fotos_danios_gm")
 * @ORM\Entity
 */
class FotoDanioGm {
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
	 * @ORM\Column(name="ruta", type="string", length=255)
	 */
	private $ruta;

	public function __toString() {
		return $this->ruta;
	}

	public function getAbsolutePath() {
		return null === $this->ruta
			? null
			: $this->getUploadRootDir() . '/' . $this->ruta;
	}

	public function getWebPath() {
		return null === $this->ruta
			? null
			: $this->getUploadDir() . '/' . $this->ruta;
	}

	protected function getUploadRootDir() {
		// the absolute directory ruta where uploaded
		// documents should be saved
		return __DIR__ . '/../../../web/' . $this->getUploadDir();
	}

	protected function getUploadDir() {
		// get rid of the __DIR__ so it doesn't screw up
		// when displaying uploaded doc/image in the view.
		return 'uploads/fotos_danio/';
	}

	/**
	 * @Assert\File(maxSize="6000000")
	 */
	private $foto;

	/**
	 * Sets foto.
	 *
	 * @param UploadedFile $foto
	 */
	public function setFoto(UploadedFile $foto = null)
	{
		$this->foto = $foto;
	}

	/**
	 * Get foto.
	 *
	 * @return UploadedFile
	 */
	public function getFoto()
	{
		return $this->foto;
	}

	public function upload()
	{
		// the file property can be empty if the field is not required
		if (null === $this->getFoto()) {
			return;
		}

		// use the original file name here but you should
		// sanitize it at least to avoid any security issues

		// move takes the target directory and then the
		// target filename to move to
		$this->getFoto()->move(
				$this->getUploadRootDir(),
				$this->getFoto()->getClientOriginalName()
		);

		// set the path property to the filename where you've saved the file
		$this->ruta = $this->getFoto()->getClientOriginalName();

		// clean up the file property as you won't need it anymore
		$this->foto = null;
	}


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
	 * @ORM\ManyToOne(targetEntity="DanioVehiculoGm", inversedBy="fotoDanio")
	 * @ORM\JoinColumn(name="danio_vehiculo_id", referencedColumnName="id")
	 */
	private $danioVehiculo;



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
     * Set ruta
     *
     * @param string $ruta
     *
     * @return FotoDanioGm
     */
    public function setRuta($ruta)
    {
        $this->ruta = $ruta;

        return $this;
    }

    /**
     * Get ruta
     *
     * @return string
     */
    public function getRuta()
    {
        return $this->ruta;
    }

    /**
     * Set creado
     *
     * @param \DateTime $creado
     *
     * @return FotoDanioGm
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
     * @return FotoDanioGm
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
     * @return FotoDanioGm
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
     * @return FotoDanioGm
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
     * Set danioVehiculo
     *
     * @param \VehiculosBundle\Entity\DanioVehiculoGm $danioVehiculo
     *
     * @return FotoDanioGm
     */
    public function setDanioVehiculo(\VehiculosBundle\Entity\DanioVehiculoGm $danioVehiculo = null)
    {
        $this->danioVehiculo = $danioVehiculo;

        return $this;
    }

    /**
     * Get danioVehiculo
     *
     * @return \VehiculosBundle\Entity\DanioVehiculoGm
     */
    public function getDanioVehiculo()
    {
        return $this->danioVehiculo;
    }
}
