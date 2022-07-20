<?php

namespace App\Controller;

use EV\API\Application\Command\Evs\CommandEvs;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiEvsController extends AbstractController
{
    private $apiCommand = null;

    public function __construct(CommandEvs $commandEvs)
    {
        $this->apiCommand = $commandEvs;
    }

    #[Route('/evs', methods: ['PUT'])]
    public function index(Request $request): JsonResponse
    {
        return $this->apiCommand->exec($request);
    }
}
