<?php


namespace AppBundle\Entity;

//use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
//use Doctrine\ORM\Mapping\PrePersist;
//use Doctrine\ORM\Mapping\PreUpdate;


/**
 * AuditoriaTrait
 *
 * Se debe agregar la clase AppBundle\EventListener\AuditoriaSubscriber
 *
 * y declararla en los servicios (app/config/services.yml):
 *
 *  AppBundle\EventListener\AuditoriaSubscriber:
 *      tags:
 *          - { name: doctrine.event_subscriber, connection: default }
 *
 * @ORM\HasLifecycleCallbacks()
 */
trait AuditoriaTrait
{

    /**
     * @var \DateTime|null
     *
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
     * @ORM\Column(name="created_by", type="string", length=255, nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(name="updated_by", type="string", length=255, nullable=false)
     */
    private $updatedBy;


    public function setCreatedValue($username = 'anon.')
    {
        $fecha = new \DateTime();
        $this->createdAt = $this->updatedAt = $fecha;
        $this->createdBy = $this->updatedBy = $username;
    }

    public function setUpdatedValue($username = 'anon.')
    {
        $this->updatedAt = new \DateTime();
        $this->updatedBy = $username;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return AtributoConfiguracion
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return AtributoConfiguracion
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     * @return self
     */
    public function setCreatedBy($createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param mixed $updatedBy
     * @return self
     */
    public function setUpdatedBy($updatedBy): self
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

}