<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\OrderRepository;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    normalizationContext: ['groups' => ['order:read']],
    operations: [
        new Get(security: "is_granted('ROLE_ADMIN') or object.getUser() == user"),
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new Post(),
        new Put(
            security: "object.getUser() == user"
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN')"
        ),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['user' => 'exact'])]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read'])]
    private ?int $id = null;

    #[Groups(['order:read'])]
    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?User $user = null;

    /**
     * @var Collection<int, OrderArticle>
     */
    #[ORM\OneToMany(targetEntity: OrderArticle::class, mappedBy: 'order', cascade: ['persist'])]
    #[Assert\NotBlank]
    #[Groups(['order:read'])]
    private Collection $orderArticles;

    public function __construct()
    {
        $this->orderArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, OrderArticle>
     */
    public function getOrderArticles(): Collection
    {
        return $this->orderArticles;
    }

    public function addOrderArticle(OrderArticle $orderArticle): static
    {
        if (!$this->orderArticles->contains($orderArticle)) {
            $this->orderArticles->add($orderArticle);
            $orderArticle->setOrder($this);
        }

        return $this;
    }

    public function removeOrderArticle(OrderArticle $orderArticle): static
    {
        if ($this->orderArticles->removeElement($orderArticle)) {
            // set the owning side to null (unless already changed)
            if ($orderArticle->getOrder() === $this) {
                $orderArticle->setOrder(null);
            }
        }

        return $this;
    }
}