<?php

use App\Event;
use App\EventDispatcher;
use App\Interface\EventListenerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__.'/vendor/autoload.php';

$twig = new Environment(new FilesystemLoader('templates'));

$listener = new class($twig) implements EventListenerInterface {
    public function __construct(
        private readonly Environment $twig,
    ) {}

    public function handle(object $event): void
    {
        echo $this->twig->render('event.html.twig', ['message' => $event->getMessage()]).\PHP_EOL;
        $event->stopPropagation();
    }
};
$dispatcher = new EventDispatcher();
$dispatcher->addListener('foo', function ($event) {
    echo 'Foo event: '.$event->getMessage()."\n";
});
$dispatcher->addListener('foo', $listener, 200);

$dispatcher->dispatch(new class extends Event {
    public function getMessage(): string
    {
        return 'Hello World!';
    }
}, 'foo');

