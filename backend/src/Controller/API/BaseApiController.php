<?php

namespace App\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseApiController extends AbstractController
{
    protected function jsonSuccess(array $data, int $status = 200): Response
    {
        return $this->json([
            'success' => true,
            'data' => $data,
        ], $status);
    }

    protected function jsonError(string $message, int $status = 400): Response
    {
        return $this->json([
            'success' => false,
            'error' => $message,
        ], $status);
    }
}
