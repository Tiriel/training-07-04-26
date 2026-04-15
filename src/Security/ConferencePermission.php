<?php

declare(strict_types=1);

namespace App\Security;

enum ConferencePermission
{
    private const PREFIX = 'conference/';

    public const CREATE = self::PREFIX . 'create';
}
