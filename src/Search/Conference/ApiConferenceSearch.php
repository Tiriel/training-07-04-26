<?php

declare(strict_types=1);

namespace App\Search\Conference;

final class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function searchByName(?string $name = null): array
    {
        return [];
    }
}
