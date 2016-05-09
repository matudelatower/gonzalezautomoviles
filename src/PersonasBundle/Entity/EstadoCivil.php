<?php

namespace PersonasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EstadoCivil
 *
 * @ORM\Table(name="estado_civil")
 * @ORM\Entity
 */
class EstadoCivil {

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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return EstadoCivil
     */
    public function setNombre($nombre) {
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

    public function __toString() {
        return $this->nombre;
    }

}
