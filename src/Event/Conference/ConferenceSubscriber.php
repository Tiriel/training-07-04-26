<?php

declare(strict_types=1);

namespace App\Event\Conference;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class ConferenceSubscriber
{
    #[AsEventListener]
    public function rejectConferenceIfTooFarInTheFuture(ConferenceSubmittedEvent $event): void
    {
        if ($event->conference->getEndAt() < new \DateTimeImmutable('+2 years')) {
            return;
        }

        $event->reject('The conference is too far in the future (maximum 2 years ahead).');
    }
}
