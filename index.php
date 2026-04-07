<?php

require __DIR__.'/EventDispatcher.php';
require __DIR__.'/EventListenerInterface.php';

$listener = new class implements EventListenerInterface {
    public function handle(object $event): void
    {
        echo 'Handled event: '.$event->getMessage()."\n";
    }
};
$dispatcher = new EventDispatcher();
$dispatcher->addListener('foo', function ($event) {
    echo 'Foo event: '.$event->getMessage()."\n";
});
$dispatcher->addListener('foo', $listener);

$dispatcher->dispatch(new class {
    public function getMessage(): string
    {
        return 'Hello World!';
    }
}, 'foo');

