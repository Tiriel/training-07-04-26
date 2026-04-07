<?php

namespace App;

use App\Interface\EventListenerInterface;
use App\Exception\NoListenerRegisteredException;

class EventDispatcher
{
    private array $listeners = [];

    public function addListener(string $eventName, callable|EventListenerInterface $listener, int $priority = 0): void
    {
        $this->listeners[$eventName][$priority][] = $listener;
    }

    public function dispatch(object $event, ?string $eventName = null): object
    {
        $eventName ??= $event::class;
        $listeners = $this->listeners[$eventName] ?? [];

        if ([] === $listeners) {
            throw new NoListenerRegisteredException($eventName);
        }

        krsort($listeners);

        foreach ($listeners as $sortedListeners) {
            $this->doDispatch($event, $sortedListeners);
        }

        return $event;
    }

    private function doDispatch(object $event, array $listeners): void
    {
        foreach ($listeners as $listener) {
            if ($event instanceof Event && $event->isPropagationStopped()) {
                return;
            }

            if ($listener instanceof EventListenerInterface) {
                $listener->handle($event);
                continue;
            }

            $listener($event);
        }
    }
}