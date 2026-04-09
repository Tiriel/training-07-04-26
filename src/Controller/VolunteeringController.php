<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\Volunteering;
use App\Form\VolunteeringType;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class VolunteeringController extends AbstractController
{
    #[Route('/volunteering/{id}', name: 'app_volunteering_show', requirements: ['id' => Requirement::UUID], methods: ['GET'])]
    public function show(Volunteering $volunteering): Response
    {
        return $this->render('volunteering/show.html.twig', [
            'volunteering' => $volunteering,
        ]);
    }

    #[Route('/volunteering/new', name: 'app_volunteering_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager, ConferenceRepository $repository): Response
    {
        $volunteering = (new Volunteering())->setForUser($this->getUser());

        if ($request->query->get('conference')) {
            $conference = $repository->find($request->query->get('conference'));
            $volunteering->setConference($conference);
        }

        $form = $this->createForm(VolunteeringType::class, $volunteering);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($volunteering);
            $manager->flush();

            return $this->redirectToRoute('app_volunteering_show', ['id' => $volunteering->getId()]);
        }

        return $this->render('volunteering/new.html.twig', [
            'form' => $form,
        ]);
    }
}
