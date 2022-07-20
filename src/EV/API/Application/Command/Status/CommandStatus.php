<?php

namespace EV\API\Application\Command\Status;

use EV\API\Infrastructure\Repository\CarRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommandStatus
{
    private $carRepository = null;
    
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function exec(Request $request): JsonResponse
    {
        $cars = $this->carRepository->count([]);
        return $cars > 0 ?
            new JsonResponse('OK', 200) :
            new JsonResponse('Error', 403);
    }
}