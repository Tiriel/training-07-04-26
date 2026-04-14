<?php

declare(strict_types=1);

namespace App\Search\Conference;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsAlias(id: ConferenceSearchInterface::class)]
final class ApiConferenceSearch implements ConferenceSearchInterface
{
    public function __construct(
        #[Autowire(env: 'CONFERENCES_API_KEY')]
        private readonly string $apiKey,

        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function searchByName(string|null $name = null): array
    {
        $httpClient = $this->httpClient
            ->withOptions([
                'headers' => [
                    'apikey' => $this->apiKey,
                    'accept' => 'application/json'
                ],
            ])
        ;

        $name = trim($name ?? '');

        if ('' !== $name) {
            $httpClient = $httpClient
                ->withOptions([
                    'query' => ['name' => $name],
                ])
            ;
        }

        $response = $httpClient->request('GET', 'https://devevents-api.fr/events');
        dump($response->toArray());

        return [];
    }
}
