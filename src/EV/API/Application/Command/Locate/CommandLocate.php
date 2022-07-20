<?php

namespace EV\API\Application\Command\Locate;

use EV\API\Application\Command\AbstractCommand;
use EV\API\Domain\Journey\JourneyStatus;
use EV\API\Infrastructure\Repository\JourneyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommandLocate extends AbstractCommand
{
    private $journeyRepository = null;

    public function __construct(JourneyRepository $journeyRepository)
    {
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
        if (!isset($journeyData['id'])){
            return new JsonResponse('Bad Request', 400);
        }

        // find journey
        if($journey = $this->journeyRepository->find($journeyData['id'])){
            if($journey->getStatus()==JourneyStatus::RIDE){
                return new JsonResponse('OK', 200);
            } else {
                return new JsonResponse('', 204);
            }
        }

        return new JsonResponse('Not Found', 404);
    }
}