<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Conference;

interface ConferenceRepositoryInterface
{
    /**
     * @return list<Conference>
     */
    public function listAll(): array;

    /**
     * @return list<Conference>
     */
    public function searchByName(string $name): array;

    public function total(): int;
}
