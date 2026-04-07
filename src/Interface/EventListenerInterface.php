<?php

namespace App\Interface;

interface EventListenerInterface
{
    public function handle(object $event): void;
}