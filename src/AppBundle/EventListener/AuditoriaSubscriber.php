<?php


namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use AppBundle\Entity\AuditoriaTrait;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuditoriaSubscriber implements EventSubscriber
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        /** @var AppBundle\Entity\AuditoriaTrait $entity **/
        $entity = $args->getObject();

        if ( in_array(AuditoriaTrait::class, class_uses(get_class($entity))) ){
            $tocken = $this->tokenStorage->getToken();

            $user = $tocken ? $tocken->getUser() : 'symfony_app';
            if ($user instanceof User) {
                $username = $user->getEmail();
            }
            else {
                $username = $user;
            }

            $entity->setCreatedValue($username);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        /** @var AppBundle\Entity\AuditoriaTrait $entity **/
        $entity = $args->getObject();

        if ( in_array(AuditoriaTrait::class, class_uses(get_class($entity))) ){
            $tocken = $this->tokenStorage->getToken();

            $user = $tocken ? $tocken->getUser() : 'symfony_app';
            if ($user instanceof User) {
                $username = $user->getEmail();
            }
            else {
                $username = $user;
            }

            $entity->setUpdatedValue($username);
        }
    }

}