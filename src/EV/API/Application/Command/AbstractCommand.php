<?php

namespace EV\API\Application\Command;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractCommand
{
    abstract public function exec(Request $request): JsonResponse;

    protected function isJsonRequest(Request $request) {
        return 'json' === $request->getContentType();
    }

    protected function transformJsonBody(Request $request) {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        if ($data === null) {
            return false;
        }
        return $data;
    }
}