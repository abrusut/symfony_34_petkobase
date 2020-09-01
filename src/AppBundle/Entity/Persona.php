<?php


namespace AppBundle\Entity;


use AppBundle\Entity\Localidad;
use AppBundle\Entity\Provincia;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Persona
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PersonaRepository")
 * @ORM\Table(name="persona")
 * @UniqueEntity(fields={"numeroDocumento", "sexo", "tipoDocumento"})
 * @ORM\HasLifecycleCallbacks()
 */
class Persona
{
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string|null
     * @ORM\Column(name="nombre", type="string", length=60,nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     * @Assert\Length( max = 60)
     * @Assert\NotNull()
     */
    private $nombre;
    
    /**
     * @var string|null
     * @ORM\Column(name="apellido", type="string", length=60,nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     * @Assert\Length( max = 60)
     * @Assert\NotNull()
     */
    private $apellido;
    
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     * @Assert\NotNull()
     */
    private $fechaNacimiento;
    
    /**
     * @var string|null
     * @ORM\Column(name="domicilio_calle", type="string", nullable=true,length=60)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     * @Assert\Length( max = 60)
     * @Assert\NotNull()
     */
    private $domicilioCalle;
    
    /**
     * @var integer|null
     * @ORM\Column(name="domicilio_numero", type="integer",nullable=true)
     */
    private $domicilioNumero;
    
    /**
     * @var TipoDocumento
     * @ORM\ManyToOne(targetEntity="TipoDocumento")
     */
    private $tipoDocumento;
    
    /**
     * @var integer|null
     * @ORM\Column(name="numero_documento", type="integer", length=8)
     * @Assert\NotBlank()
     * @Assert\Length(min = 8)
     * @Assert\Length( max = 8)
     * @Assert\NotNull()
     */
    private $numeroDocumento;
    
    /**
     * @var string|null
     * @ORM\Column(name="sexo", type="string", length=1, nullable=true)
     */
    private $sexo;
    
    /**
     * @var string|null
     * @ORM\Column(name="telefono", type="string", length=25, nullable=true)
     * @Assert\Length( max = 25)
     */
    private $telefono;
    
    /**
     * @var string|null
     * @ORM\Column(name="email", type="string", length=50, nullable=false)
     * @Assert\NotNull()
     * @Assert\Email()
     */
    private $email;
    
    /**
     * @var \DateTime|null
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;
    
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;
    
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_baja", type="datetime", nullable=true)
     * @Groups({"get", "post", "put"})
     */
    private $fechaBaja;
    
    /**
     * @Groups({"get", "post","put"})
     * @ORM\ManyToOne(targetEntity="Localidad")
     * @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     */
    private $localidad;
    
    /**
     * @Groups({"get", "post","put"})
     * @ORM\ManyToOne(targetEntity="Provincia")
     * @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
     */
    private $provincia;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * @return bool|null
     * @Groups({"get"})
     */
    public function getEnabled(): ?bool {
        $enabled = true;
        $dateActual = new \DateTime("now");
        if($this->getFechaBaja() !== null && $this->getFechaBaja() < $dateActual)
        {
            $enabled = false;
        }
        return $enabled;
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    
    /**
     * @return string|null
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }
    
    /**
     * @param string|null $nombre
     */
    public function setNombre(?string $nombre): void
    {
        $this->nombre = $nombre;
    }
    
    /**
     * @return string|null
     */
    public function getApellido(): ?string
    {
        return $this->apellido;
    }
    
    /**
     * @param string|null $apellido
     */
    public function setApellido(?string $apellido): void
    {
        $this->apellido = $apellido;
    }
    
    /**
     * @return \DateTime|null
     */
    public function getFechaNacimiento(): ?\DateTime
    {
        return $this->fechaNacimiento;
    }
    
    /**
     * @param \DateTime|null $fechaNacimiento
     */
    public function setFechaNacimiento(?\DateTime $fechaNacimiento): void
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }
    
    /**
     * @return string|null
     */
    public function getDomicilioCalle(): ?string
    {
        return $this->domicilioCalle;
    }
    
    /**
     * @param string|null $domicilioCalle
     */
    public function setDomicilioCalle(?string $domicilioCalle): void
    {
        $this->domicilioCalle = $domicilioCalle;
    }
    
    /**
     * @return int|null
     */
    public function getDomicilioNumero(): ?int
    {
        return $this->domicilioNumero;
    }
    
    /**
     * @param int|null $domicilioNumero
     */
    public function setDomicilioNumero(?int $domicilioNumero): void
    {
        $this->domicilioNumero = $domicilioNumero;
    }
    
    /**
     * @return TipoDocumento
     */
    public function getTipoDocumento(): ?TipoDocumento
    {
        return $this->tipoDocumento;
    }
    
    /**
     * @param TipoDocumento $tipoDocumento
     */
    public function setTipoDocumento(TipoDocumento $tipoDocumento): void
    {
        $this->tipoDocumento = $tipoDocumento;
    }
    
    /**
     * @return int|null
     */
    public function getNumeroDocumento(): ?int
    {
        return $this->numeroDocumento;
    }
    
    /**
     * @param int|null $numeroDocumento
     */
    public function setNumeroDocumento(?int $numeroDocumento): void
    {
        $this->numeroDocumento = $numeroDocumento;
    }
    
    /**
     * @return string|null
     */
    public function getSexo(): ?string
    {
        return $this->sexo;
    }
    
    /**
     * @param string|null $sexo
     */
    public function setSexo(?string $sexo): void
    {
        $this->sexo = $sexo;
    }
    
    /**
     * @return string|null
     */
    public function getTelefono(): ?string
    {
        return $this->telefono;
    }
    
    /**
     * @param string|null $telefono
     */
    public function setTelefono(?string $telefono): void
    {
        $this->telefono = $telefono;
    }
    
    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    
    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
    
    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }
    
    /**
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
    
    /**
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * @return \DateTime|null
     */
    public function getFechaBaja(): ?\DateTime
    {
        return $this->fechaBaja;
    }
    
    /**
     * @param \DateTime|null $fechaBaja
     */
    public function setFechaBaja(?\DateTime $fechaBaja): void
    {
        $this->fechaBaja = $fechaBaja;
    }
    
    /**
     * @return mixed
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }
    
    /**
     * @param mixed $localidad
     */
    public function setLocalidad($localidad): void
    {
        $this->localidad = $localidad;
    }
    
    /**
     * @return mixed
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
    
    /**
     * @param mixed $provincia
     */
    public function setProvincia($provincia): void
    {
        $this->provincia = $provincia;
    }
    
   
    
}
