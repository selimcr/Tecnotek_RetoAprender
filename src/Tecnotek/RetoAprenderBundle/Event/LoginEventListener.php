<?php

namespace Tecnotek\RetoAprenderBundle\Event;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

use Tecnotek\RetoAprenderBundle\Entity\User;

class LoginEventListener
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Catches the login of a user and does something with it
     *
     * @param \Symfony\Component\Security\Http\Event\InteractiveLoginEvent $event
     * @return void
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        if ($token && $token->getUser() instanceof User)
        {
            $user = $token->getUser();
            $user->setLastLogin(new \DateTime());
            $this->em->persist($user);
            $this->em->flush();
        }
    }
}