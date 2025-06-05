<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class InfoController extends AbstractController
{
    #[Route('/api/me', name: 'api_info', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function __invoke(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json([
            'email' => $user->getUserIdentifier(),
            'lastName' => $user->getLastName(),
            'firstName' => $user->getFirstName(),
            'company' => $user->getCompany(),
            'phoneNumber' => $user->getPhoneNumber(),
            'roles' => $user->getRoles(),
        ]);
    }
}