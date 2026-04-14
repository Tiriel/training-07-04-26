<?php

declare(strict_types=1);

namespace App\Search\Conference;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(id: ConferenceSearchInterface::class)]
final class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function searchByName(?string $name = null): array
    {
        return [];
    }
}
