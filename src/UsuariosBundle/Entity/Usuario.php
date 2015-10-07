<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 29/9/15
 * Time: 20:29
 */

namespace UsuariosBundle\Entity;


use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="UsuarioRepository")
 * @ORM\Table(name="fos_user")
 */
class Usuario extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct() {
        parent::__construct();
        // your own logic
    }

    /**
     * @ORM\OneToMany(targetEntity="PerfilUsuario", mappedBy="usuario",cascade={"persist"})
     *
     */
    private $perfil;

}
