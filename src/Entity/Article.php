<?php

namespace App\Entity;

use App\Entity\Cart;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Put(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        ),
    ]
)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $width = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank]
    private ?string $height = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $matter = null;

    /**
     * @var Collection<int, Cart>
     */
    #[ORM\ManyToMany(targetEntity: Cart::class, mappedBy: 'articles')]
    private Collection $cart;

    #[ORM\Column(length: 50)]
    private ?string $price = null;

    public function __construct()
    {
        $this->cart = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function setWidth(string $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getMatter(): ?string
    {
        return $this->matter;
    }

    public function setMatter(string $matter): static
    {
        $this->matter = $matter;

        return $this;
    }

    /**
     * @return Collection<int, Cart>
     */
    public function getCart(): Collection
    {
        return $this->cart;
    }

    public function addCart(Cart $cart): static
    {
        if (!$this->cart->contains($cart)) {
            $this->cart->add($cart);
            $cart->addArticle($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): static
    {
        if ($this->cart->removeElement($cart)) {
            $cart->removeArticle($this);
        }

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }
}
