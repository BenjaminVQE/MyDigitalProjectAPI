<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\Get;
use App\Controller\InfoMeController;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\OpenApi\Model;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/me',
            controller: InfoMeController::class,
            normalizationContext: ['groups' => ['me:read']],
            openapi: new Model\Operation(
                summary: 'Collect infos user',
                description: 'Return profile\'s infos from user connected',
                responses: [
                    '200' => new Model\Response(
                        description: 'Profile return with success',
                        content: new \ArrayObject([
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'email' => ['type' => 'string'],
                                        'lastName' => ['type' => 'string'],
                                        'firstName' => ['type' => 'string'],
                                        'company' => ['type' => 'string'],
                                        'phoneNumber' => ['type' => 'string'],
                                        'roles' => [
                                            'type' => 'array',
                                            'items' => ['type' => 'string']
                                        ],
                                    ],
                                ],
                                'example' => [
                                    'email' => 'user@example.com',
                                    'lastName' => 'Dupont',
                                    'firstName' => 'Jean',
                                    'company' => 'Mon Entreprise',
                                    'phoneNumber' => '0123456789',
                                    'roles' => ['ROLE_USER'],
                                ]
                            ]
                        ])
                    ),
                    '401' => new Model\Response(
                        description: 'Unauthorized',
                        content: new \ArrayObject([
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'code' => ['type' => 'integer'],
                                        'message' => ['type' => 'string'],
                                        'firstName' => ['type' => 'string'],
                                        'company' => ['type' => 'string'],
                                        'phoneNumber' => ['type' => 'string'],
                                        'roles' => [
                                            'type' => 'array',
                                            'items' => ['type' => 'string']
                                        ],
                                    ],
                                ],
                                'example' => [
                                    'code' => '401',
                                    'message' => 'JWT Token not found',
                                ]
                            ]
                        ])
                    )
                ]
            )
        )
    ],
    formats: ['json']
)]
class InfoMe
{
    #[Groups(['me:read'])]
    public string $email;

    #[Groups(['me:read'])]
    public string $lastName;

    #[Groups(['me:read'])]
    public string $firstName;

    #[Groups(['me:read'])]
    public string $company;

    #[Groups(['me:read'])]
    public string $phoneNumber;

    #[Groups(['me:read'])]
    public array $roles;
}