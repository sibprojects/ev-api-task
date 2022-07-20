<?php

namespace App\Controller;

use EV\API\Application\Command\Dropoff\CommandDropoff;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiDropoffController extends AbstractController
{
    private $apiCommand = null;

    public function __construct(CommandDropoff $commandDropoff)
    {
        $this->apiCommand = $commandDropoff;
    }

    #[Route('/dropoff', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        return $this->apiCommand->exec($request);
    }
}
