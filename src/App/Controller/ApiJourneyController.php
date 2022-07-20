<?php

namespace App\Controller;

use EV\API\Application\Command\Journey\CommandJourney;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiJourneyController extends AbstractController
{
    private $apiCommand = null;

    public function __construct(CommandJourney $commandJourney)
    {
        $this->apiCommand = $commandJourney;
    }

    #[Route('/journey', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        return $this->apiCommand->exec($request);
    }
}
