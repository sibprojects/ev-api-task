<?php

namespace EV\API\Application\Command\Journey;

use EV\API\Application\Command\AbstractCommand;
use EV\API\Application\Service\JourneyRideService;
use EV\API\Domain\Car\Car;
use EV\API\Domain\Journey\Journey;
use EV\API\Domain\Journey\JourneyStatus;
use EV\API\Infrastructure\Repository\CarRepository;
use EV\API\Infrastructure\Repository\JourneyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommandJourney extends AbstractCommand
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
        if (!$journeyData = $this->transformJsonBody($request)) {
            return new JsonResponse('Bad Request', 400);
        }
        if (!isset($journeyData['id']) || !isset($journeyData['people'])){
            return new JsonResponse('Bad Request', 400);
        }

        // find journey
        if($journey = $this->journeyRepository->find($journeyData['id'])){
            return new JsonResponse('OK', 200);
        }

        $journey = new Journey();
        $journey->setId($journeyData['id']);
        $journey->setPeople($journeyData['people']);
        $journey->setStatus(JourneyStatus::WAIT);
        $this->journeyRepository->add($journey, true);

        // set ride if possible
        JourneyRideService::setRide($journey, $this->carRepository, $this->journeyRepository);

        return new JsonResponse('OK', 200);
    }
}