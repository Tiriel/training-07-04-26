<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerHelper;
use Symfony\Component\DependencyInjection\Attribute\AutowireMethodOf;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class HomeController
{
    public function __construct(
        #[AutowireMethodOf(ControllerHelper::class)]
        private readonly \Closure $render,
    ) {}

    #[Route('/', name: 'app_main_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $name = $request->query->get('name', 'World');

        return $this->render('main/index.html.twig', [
            'name' => $name,
        ]);
    }

    #[Route('/contact', name: 'app_home_contact', methods: ['GET'], priority: -1)]
    #[Template('main/contact.html.twig')]
    public function contact(): void {}

    private function render(string $view, array $parameters = [], ?Response $response = null): Response
    {
        return ($this->render)($view, $parameters, $response);
    }
}
