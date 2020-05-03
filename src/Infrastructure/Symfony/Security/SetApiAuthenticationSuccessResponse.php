<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class SetApiAuthenticationSuccessResponse
{
    private ?bool $secure = null;
    private int $tokenTtl;

    /**
     * SetApiAuthenticationSuccessResponse constructor.
     * @param int $tokenTtl
     */
    public function __construct(int $tokenTtl)
    {
        $this->tokenTtl = $tokenTtl;
    }

    /**
     * @param AuthenticationSuccessEvent $successEvent
     * @throws \Exception
     */
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $successEvent): void
    {
        $response = $successEvent->getResponse();
        $data = $successEvent->getData();

        $token = $data['token'];

        $response->headers->setCookie(
            new Cookie(
                'BEARER',
                $token,
                (new \DateTime())
                    ->add(new \DateInterval('PT' . $this->tokenTtl . 'S')),
                '/',
                null,
                $this->secure,
                true,
                false,
                'lax'
            )
        );
    }
}
