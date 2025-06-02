<?php

namespace App\Controller;

use App\ApiResource\Simulator;
use App\Services\SimulatorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SimulatorController extends AbstractController
{
    public function __construct(
        protected SimulatorService $simulatorService,
    ) {}

    public function __invoke(#[MapRequestPayload] Simulator $simulator)
    {
        $result = $this->simulatorService->simulate($simulator);

        return new JsonResponse($result, JsonResponse::HTTP_CREATED);
    }
}
