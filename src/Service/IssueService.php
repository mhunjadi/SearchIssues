<?php

namespace App\Service;

use App\Entity\Issue;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IssueService
{
    private $entityManager;
    private $client;

    private const POSITIVE_RESULT = 'rocks';
    private const NEGATIVE_RESULT = 'sucks';

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $client)
    {
        $this->entityManager = $entityManager;
        $this->client = $client;
    }

    /**
     * @return 
     */
    public function getPopularity(string $word)
    {
        $positiveResults = $this->client->request('GET', 'https://api.github.com/search/issues', [
            'query' => [
                'q' => $word . '+' . self::POSITIVE_RESULT
            ],
        ]);

        $negativeResults = $this->client->request('GET', 'https://api.github.com/search/issues', [
            'query' => [
                'q' => $word . '+' . self::NEGATIVE_RESULT
            ],
        ]);

        $issue = new Issue();
        $issue->setWord($word);
        $issue->setPositiveResults(json_decode($positiveResults->getContent())->total_count);
        $issue->setNegativeResults(json_decode($negativeResults->getContent())->total_count);
        if ($issue->getPositiveResults() && $issue->getNegativeResults())
            $issue->setPopularity(round($issue->getPositiveResults() / ($issue->getPositiveResults() + $issue->getNegativeResults()) * 10));
        else
            $issue->setPopularity(0);

        $this->entityManager->persist($issue);
        $this->entityManager->flush();

        return [$issue->getId(), $issue->getWord(), $issue->getPositiveResults(), $issue->getNegativeResults(), $issue->getPopularity()];
    }
}