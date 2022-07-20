<?php

namespace EV\API\Application\Command\Evs;

use EV\API\Application\Command\AbstractCommand;
use EV\API\Domain\Car\Car;
use EV\API\Infrastructure\Repository\CarRepository;
use EV\API\Infrastructure\Repository\JourneyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommandEvs extends AbstractCommand
{
    private $carRepository = null;
    private $journeyRepository = null;

    public function __construct(CarRepository $carRepository, JourneyRepository $journeyRepository)
    {
        $this->carRepository = $carRepository;
        $this->journeyRepository = $journeyRepository;
    }

    public function exec(Request $request): JsonResponse
    {
        $data = $request->getContent();

        if (empty($data)) {
            return new JsonResponse('Bad Request', 400);
        }
        if (!$this->isJsonRequest($request)) {
            return new JsonResponse('Bad Request', 400);
        }
        if (!$data = $this->transformJsonBody($request)) {
            return new JsonResponse('Bad Request', 400);
        }

        $this->journeyRepository->removeAll();
        $this->carRepository->removeAll();

        foreach ($data as $carData){
            $car = new Car();
            $car->setId($carData['id']);
            $car->setSeats($carData['seats']);
            $this->carRepository->add($car, true);
        }

        return new JsonResponse('OK', 200);
    }
}