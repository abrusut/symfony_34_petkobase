<?php


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 *
 */
class User extends BaseUser
{
    use AuditoriaTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=100)
     */
    private $apellido;

    /**
     * @var int
     *
     * @ORM\Column(name="dni", type="integer")
     */
    private $dni;

    public function __construct()
    {
        parent::__construct();
        $this->nombre = $this->apellido = '';
        $this->dni = 0;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {
        $this->setUsername($email);
        return parent::setEmail($email);
    }

    /**
     * @return string|null
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     * @return User
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    /**
     * @param string $apellido
     * @return User
     */
    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getDni(): ?int
    {
        return $this->dni;
    }

    /**
     * @param int $dni
     * @return User
     */
    public function setDni(int $dni): self
    {
        $this->dni = $dni;
        return $this;
    }


}