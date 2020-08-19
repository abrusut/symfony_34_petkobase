<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AtributoConfiguracion
 *
 * @ORM\Entity()
 */
class AtributoConfiguracion
{
    use AuditoriaTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

       
    /**
     * @var string
     *
     * @ORM\Column(name="clave", type="string", nullable=false)
     * @Assert\NotNull()
     */
    private $clave;

    /**
     * @var string
     *     
     * @ORM\Column(type="text", length=65535, nullable=false))
     * @Assert\NotNull()
     */
    private $valor;

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
     * Set clave
     *
     * @param string $clave
     * @return AtributoConfiguracion
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string 
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return AtributoConfiguracion
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }
}
