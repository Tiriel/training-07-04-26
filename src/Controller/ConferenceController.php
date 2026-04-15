<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Event\Conference\ConferenceSubmittedEvent;
use App\Form\ConferenceType;
use App\Search\Conference\ConferenceSearchInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ConferenceController extends AbstractController
{
    #[Route('/conference', name: 'app_conference_list', methods: ['GET'])]
    public function list(Request $request, ConferenceSearchInterface $conferenceSearch): Response
    {
        $conferences = $conferenceSearch->searchByName($request->query->getString('name'));
        $conferences = $conferenceSearch->searchByName($request->query->getString('name'));
        $conferences = $conferenceSearch->searchByName($request->query->getString('name'));
        $conferences = $conferenceSearch->searchByName($request->query->getString('name'));
        $conferences = $conferenceSearch->searchByName($request->query->getString('name'));
        $conferences = $conferenceSearch->searchByName($request->query->getString('name'));

        return $this->render('conference/list.html.twig', [
            'conferences' => $conferences,
        ]);
    }

    #[Route('/conference/{id:conference}', name: 'app_conference_show', requirements: ['id' => Requirement::UUID], methods: ['GET'])]
    public function show(Conference $conference): Response
    {
        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
        ]);
    }

    #[Route('/conference/new', name: 'app_conference_new', methods: ['GET', 'POST'])]
    public function newConference(Request $request, EntityManagerInterface $manager, EventDispatcherInterface $eventDispatcher): Response
    {
        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $event = new ConferenceSubmittedEvent($conference);
            $eventDispatcher->dispatch($event);

            if ($event->isRejected() === false) {
                $manager->persist($conference);
                $manager->flush();

                return $this->redirectToRoute('app_conference_show', ['id' => $conference->getId()]);
            }

            foreach ($event->getRejectReasons() as $reason) {
                $form->addError(new FormError($reason));
            }
        }

        return $this->render('conference/new.html.twig', [
            'form' => $form,
        ]);
    }
}
