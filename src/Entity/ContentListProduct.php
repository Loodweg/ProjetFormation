<?php

namespace App\Entity;

use App\Repository\ContentListProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentListProductRepository::class)]
class ContentListProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: ListProduct::class, inversedBy: 'contentListProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private $listProduct;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $product;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getListProduct(): ?ListProduct
    {
        return $this->listProduct;
    }

    public function setListProduct(?ListProduct $listProduct): self
    {
        $this->listProduct = $listProduct;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
