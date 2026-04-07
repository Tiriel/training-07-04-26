<?php

class NoListenerRegisteredException extends RuntimeException
{
    public function __construct(public readonly string $eventName)
    {
        parent::__construct("No listener registered for this event.");
    }
}