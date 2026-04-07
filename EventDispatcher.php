<?php

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

        foreach ($this->listeners[$eventName] as $listener) {
            is_callable($listener)
                ? $listener($event)
                : $listener->handle($event);
        }

        return $event;
    }
}