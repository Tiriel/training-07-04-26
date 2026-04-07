<?php

require __DIR__.'/EventDispatcher.php';

$dispatcher = new EventDispatcher();
$dispatcher->addListener('foo', function ($event) {
    echo 'Foo event: '.$event->getMessage()."\n";
});

$dispatcher->dispatch(new class {
    public function getMessage(): string
    {
        return 'Hello World!';
    }
}, 'foo');
