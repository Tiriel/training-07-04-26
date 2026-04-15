<?php

declare(strict_types=1);

namespace App\Security\Voter\Conference;

use App\Security\ConferencePermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use function in_array;

final class CanCreateVoter extends Voter
{
    public function __construct(
        private readonly AccessDecisionManagerInterface $accessDecisionManager,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [ConferencePermission::CREATE], true);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        if ($this->accessDecisionManager->decide($token, ['ROLE_WEBSITE'], $subject) === true) {
            $vote?->addReason('User is role website.');

            return true;
        }

        if ($this->accessDecisionManager->decide($token, ['ROLE_ORGANIZER'], $subject) === true) {
            $vote?->addReason('User is role organizer.');

            return true;
        }

        $vote?->addReason('User is neither organizer nor website.');

        return false;
    }
}
