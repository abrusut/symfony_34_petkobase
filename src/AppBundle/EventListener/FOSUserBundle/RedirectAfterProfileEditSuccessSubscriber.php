<?php


namespace AppBundle\EventListener\FOSUserBundle;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class RedirectAfterProfileEditSuccessSubscriber implements EventSubscriberInterface
{

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::PROFILE_EDIT_SUCCESS => 'onEditProfileEditSuccess',
        ];
    }

    public function onEditProfileEditSuccess(FormEvent $formEvent)
    {
        $url = $this->router->generate('public_home');
        $respose = new RedirectResponse($url);
        $formEvent->setResponse($respose);
    }

}