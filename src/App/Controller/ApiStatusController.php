<?php

namespace App\Controller;

use EV\API\Application\Command\Status\CommandStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiStatusController extends AbstractController
{
    private $apiCommand = null;

    public function __construct(CommandStatus $commandStatus)
    {
        $this->apiCommand = $commandStatus;
    }

    #[Route('/status', name: 'app_api_status')]
    public function index(Request $request): JsonResponse
    {
        return $this->apiCommand->exec($request);
    }
}
