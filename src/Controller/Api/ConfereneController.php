<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\ConferenceRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

final class ConfereneController
{
    #[Route('/api/conferences-circular', name: 'app_api_conferences_list_circular')]
    public function getVolunteeringsApi(ConferenceRepositoryInterface $repository, SerializerInterface $serializer): Response
    {
        $conferences = $repository->listAll();

        $context = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function(object $object, string $format, array $context) {
                return $object->getId();
            }
        ];

        $data =  $serializer->serialize($conferences, 'json', $context);

        return new JsonResponse($data, Response::HTTP_OK, json: true);
    }
}
