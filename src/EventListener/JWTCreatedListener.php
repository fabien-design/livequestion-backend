<?php
// EventListener/JWTCreatedListener.php

declare(strict_types=1);

namespace App\EventListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


/**
 * Class JWTCreatedListener
 */
class JWTCreatedListener
{

    public function __construct(private ParameterBagInterface $parameterBag)
    {
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $payload = $event->getData();

        if (($payload['scope'] ?? '') === 'fileScope') {
            $expiration = new \DateTime($this->parameterBag->get('app.jwt_expires_in'));
            $payload['exp'] = $expiration->getTimestamp();
        }

        $event->setData($payload);
    }
}
