<?php

namespace EV\API\Application\Service;

use EV\API\Domain\Journey\Journey;
use EV\API\Domain\Journey\JourneyStatus;
use EV\API\Infrastructure\Repository\CarRepository;
use EV\API\Infrastructure\Repository\JourneyRepository;

class JourneyRideService
{
    public static function checkRides(CarRepository $carRepository, JourneyRepository $journeyRepository)
    {
        $journeys = $journeyRepository->findBy(['status' => JourneyStatus::WAIT]);
        foreach ($journeys as $journey){
            self::setRide($journey, $carRepository, $journeyRepository);
        }
    }

    public static function setRide(Journey $journey, CarRepository $carRepository, JourneyRepository $journeyRepository)
    {
        $emptyCar = $carRepository->getEmptyCar(2);
        if($emptyCar){
            $journey->setCar($emptyCar);
            $journey->setStatus(JourneyStatus::RIDE);
            $journeyRepository->add($journey, true);
        }
    }

}