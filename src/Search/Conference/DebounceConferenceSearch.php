<?php

declare(strict_types=1);

namespace App\Search\Conference;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(ConferenceSearchInterface::class)]
final class DebounceConferenceSearch implements ConferenceSearchInterface
{
    private array $debounce = [];

    private array|null $noNameDebounce = null;

    public function __construct(
        private readonly ConferenceSearchInterface $inner
    ) {
    }

    public function searchByName(?string $name = null): array
    {
        $name = trim($name ?? '');

        if ('' === $name) {
            return $this->noNameDebounce ??= $this->inner->searchByName($name);
        }

        return $this->debounce[$name] ??= $this->inner->searchByName($name);
    }
}
