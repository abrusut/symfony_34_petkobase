<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Provincia
 * @ORM\Entity()
 * @ORM\Table(name="provincia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProvinciaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Provincia
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(name="area_numero", type="integer")
     */
    private $areaNumero;

    /**
     *@var string
     *
     *@ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var Localidad
     *
     * @ORM\OneToMany(targetEntity="Localidad", mappedBy="provincia")
     */
    private $localidades;



    function __construct()
    {
        $this->localidades = new ArrayCollection();
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

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return int
     */
    public function getAreaNumero()
    {
        return $this->areaNumero;
    }

    /**
     * @param int $areaNumero
     * @return Provincia
     */
    public function setAreaNumero(int $areaNumero): self
    {
        $this->areaNumero = $areaNumero;
        return $this;
    }

    /**
     * Add localidades
     *
     * @param Localidad $localidades
     * @return Provincia
     */
    public function addLocalidade(Localidad $localidades)
    {
        $this->localidades[] = $localidades;

        return $this;
    }

    /**
     * Remove localidades
     *
     * @param Localidad $localidades
     */
    public function removeLocalidade(Localidad $localidades)
    {
        $this->localidades->removeElement($localidades);
    }

    /**
     * Get localidades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLocalidades()
    {
        return $this->localidades;
    }

    /**
     *  Retorna el nombre de la provincia
     *
     * @return string
     *
     */
    public function __toString() {
        return $this->getNombre();
    }


    public function isSantaFe(){
        return $this->areaNumero === 82 ? true : false;
    }

    public function copyValues($objectForCopy)
    {           
        $vars=is_object($objectForCopy)?get_object_vars($objectForCopy):$objectForCopy;
        if(!is_array($vars)) throw Exception('Sin propiedades para el objeto Provincia!');
        foreach ($vars as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }
}
