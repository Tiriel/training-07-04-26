<?php

namespace App;

use App\Interface\EventListenerInterface;
use App\Exception\NoListenerRegisteredException;

class EventDispatcher
{
    private array $listeners = [];

    public function addListener(string $eventName, callable|EventListenerInterface $listener): void
    {
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(object $event, ?string $eventName = null): object
    {
        $eventName ??= $event::class;
        $listeners = $this->listeners[$eventName] ?? [];

        if ([] === $listeners) {
            throw new NoListenerRegisteredException($eventName);
        }

        foreach ($listeners as $listener) {
            is_callable($listener)
                ? $listener($event)
                : $listener->handle($event);
        }

        return $event;
    }
}