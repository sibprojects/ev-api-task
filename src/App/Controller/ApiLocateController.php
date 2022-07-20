<?php

namespace App\Controller;

use EV\API\Application\Command\Locate\CommandLocate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiLocateController extends AbstractController
{
    private $apiCommand = null;

    public function __construct(CommandLocate $commandLocate)
    {
        $this->apiCommand = $commandLocate;
    }

    #[Route('/locate', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        return $this->apiCommand->exec($request);
    }
}
