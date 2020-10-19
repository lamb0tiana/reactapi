<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
class JwtSubscriber
{
    private $request;
    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack;
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        /** @var User $user */
        $user = $event->getUser();
        $data = $event->getData();
        $data['username'] = $user->getUsername();
        $data['email']  = $user->getEmail();
        $data['avatar'] = $user->getPicture();
        $event->setData($data);
    }

}
