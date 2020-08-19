<?php


namespace AppBundle\EventListener\FOSUserBundle;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class RedirectAfterRegistrationSuccessSubscriber implements EventSubscriberInterface
{
    use TargetPathTrait;

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
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        ];
    }

    public function onRegistrationSuccess(FormEvent $formEvent)
    {
        $url = $this->getTargetPath($formEvent->getRequest()->getSession(), 'main');
        if (!$url) {
            $url = $this->router->generate('public_home');
        }
        $response = new RedirectResponse($url);
        $formEvent->setResponse($response);
    }

}