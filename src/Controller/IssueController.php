<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\IssueRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

;
use App\Service\IssueService;

class IssueController extends AbstractController
{
    private $issueRepository;
    private $issueService;

    public function __construct(IssueRepository $issueRepository, IssueService $issueService)
    {
        $this->issueRepository = $issueRepository;
        $this->issueService = $issueService;
    }

    #[Route('/issues/search/{word}', name: 'app_issue')]
    public function create(string $word): JsonResponse
    {
        $issue = $this->issueService->getPopularity($word);
        return $this->json(['word' => $word, 'issue' => $issue]);
    }

    #[Route('/issues', name: 'app_issues')]
    public function index(): JsonResponse
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $issues = $serializer->normalize($this->issueRepository->findAll());
        return $this->json($issues);
    }
}
