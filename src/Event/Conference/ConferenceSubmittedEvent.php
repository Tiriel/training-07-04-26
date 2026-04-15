<?php

declare(strict_types=1);

namespace App\Event\Conference;

use App\Entity\Conference;

final class ConferenceSubmittedEvent
{
    /**
     * @var list<string>
     */
    private array $rejectReasons = [];

    public function __construct(
        public readonly Conference $conference,
    ) {
    }

    public function isRejected(): bool
    {
        return [] !== $this->rejectReasons;
    }

    public function reject(string $reason): void
    {
        $this->rejectReasons[] = $reason;
    }

    /**
     * @return list<string>
     */
    public function getRejectReasons(): array
    {
        return $this->rejectReasons;
    }
}
