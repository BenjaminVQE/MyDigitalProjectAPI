<?php

namespace App\ApiResource;

use ArrayObject;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\SimulatorController;
use ApiPlatform\OpenApi\Model;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            controller: SimulatorController::class,
            openapi: new Model\Operation(
                summary: 'Simulate price',
                description: 'Simulate the total price of a cart based on unit price, quantity, and selected package.',
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'pricePerProduct' => ['type' => 'string'],
                                    'numberOfProduct' => ['type' => 'integer'],
                                    'package' => ['type' => 'integer'],
                                ]
                            ],
                            'example' => [
                                'pricePerProduct' => '5.90',
                                'numberOfProduct' => 11,
                                'package' => true,
                            ]
                        ]
                    ])
                ),
                responses: [
                    '200' => new Model\Response(
                        description: 'Simulation completed successfully',
                        content: new \ArrayObject([
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'totalPriceHT' => ['type' => 'string'],
                                        'totalPrice' => ['type' => 'string'],
                                    ]
                                ],
                                'example' => [
                                    'totalPriceHT' => '364.90',
                                    'totalPrice' => '437,88',
                                ]
                            ]
                        ])
                    )
                ]
            )
        )
    ]
)]
class Simulator
{
    #[Assert\NotBlank]
    private ?string $pricePerProduct = null;

    #[Assert\NotBlank]
    private ?int $numberOfProduct = null;

    #[Assert\NotBlank]
    private ?bool $package = false;

    public function getPricePerProduct(): ?string
    {
        return $this->pricePerProduct;
    }

    public function setPricePerProduct(string $pricePerProduct): static
    {
        $this->pricePerProduct = $pricePerProduct;

        return $this;
    }

    public function getNumberOfProduct(): ?int
    {
        return $this->numberOfProduct;
    }

    public function setNumberOfProduct(int $numberOfProduct): static
    {
        $this->numberOfProduct = $numberOfProduct;

        return $this;
    }

    public function isPackage(): ?bool
    {
        return $this->package;
    }

    public function setPackage(bool $package): static
    {
        $this->package = $package;

        return $this;
    }
}