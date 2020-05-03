<?php

declare(strict_types=1);

namespace App\Presentation\Api\Handler\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

final class GetLoggedInUser
{
    /**
     * @param Security $security
     * @param SerializerInterface $serializer
     * @return JsonResponse
     * Get information from logged user (Needed into frontend authentication).
     */
    public function __invoke(Security $security, SerializerInterface $serializer): JsonResponse
    {
        $user = $serializer->serialize(
            $security->getUser(),
            'json',
            ['attributes' => ['firstName', 'lastName', 'roles']]
        );
        return new JsonResponse($user);
    }
}
