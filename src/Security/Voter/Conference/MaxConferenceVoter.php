<?php

declare(strict_types=1);

namespace App\Security\Voter\Conference;

use App\Repository\ConferenceRepositoryInterface;
use App\Security\ConferencePermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

final class MaxConferenceVoter implements VoterInterface
{
    private const MAX_CONFERENCE = 5;

    public function __construct(
        private readonly ConferenceRepositoryInterface $conferenceRepository,
    ) {
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes, ?Vote $vote = null): int
    {
        [$attribute] = $attributes;

        if ($attribute !== ConferencePermission::CREATE) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $isMaxReached = $this->conferenceRepository->total() >= self::MAX_CONFERENCE;

        if ($isMaxReached === true) {
            $vote?->addReason('Maximum conference of ' . self::MAX_CONFERENCE . ' reached.');

            return VoterInterface::ACCESS_DENIED;
        }
        $vote?->addReason('Maximum conference is not reached. Carry on.');

        return VoterInterface::ACCESS_ABSTAIN;
    }
}
