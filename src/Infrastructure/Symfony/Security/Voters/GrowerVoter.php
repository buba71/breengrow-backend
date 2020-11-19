<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Security\Voters;

use App\Application\UseCases\Grower\Show\ShowGrowerRequest;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class GrowerVoter extends Voter
{

    protected function supports($attribute, $subject)
    {
        dd($attribute);
        $supportsAttribute = in_array($attribute, ['GROWER_READ']);
        $supportSubject = $subject instanceof ShowGrowerRequest;

        return $supportsAttribute && $supportSubject;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {

    }
}