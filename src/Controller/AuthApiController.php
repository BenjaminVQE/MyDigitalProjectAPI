<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthApiController extends AbstractController
{
    private $jwtManager;
    private $security;

    public function __construct(JWTTokenManagerInterface $jwtManager, Security $security)
    {
        $this->jwtManager = $jwtManager;
        $this->security = $security;
    }

    #[Route('/api/auth', name: 'auth', methods: ['POST'])]
    public function authenticate(): JsonResponse
    {
        $user = $this->security->getUser();

        if (!$user) {
            return new JsonResponse(['message' => 'Invalid credentials'], 401);
        }

        $token = $this->jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
}