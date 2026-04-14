<?php

declare(strict_types=1);

namespace App\Search\Conference;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsAlias(id: ConferenceSearchInterface::class)]
final class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        #[Autowire(env: 'CONFERENCES_API_KEY')]
        private readonly string $apiKey,
    ) {
    }

    public function searchByName(?string $name = null): array
    {
        return [];
    }
}
