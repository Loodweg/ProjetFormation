<?php

namespace App\Entity;

use App\Repository\ListProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListProductRepository::class)]
class ListProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'listProduct', targetEntity: Purchase::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $purchase;

    #[ORM\OneToMany(mappedBy: 'listProduct', targetEntity: ContentListProduct::class, orphanRemoval: true)]
    private $contentListProducts;

    public function __construct()
    {
        $this->contentListProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchase(): ?Purchase
    {
        return $this->purchase;
    }

    public function setPurchase(Purchase $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    /**
     * @return Collection|ContentListProduct[]
     */
    public function getContentListProducts(): Collection
    {
        return $this->contentListProducts;
    }

    public function addContentListProduct(ContentListProduct $contentListProduct): self
    {
        if (!$this->contentListProducts->contains($contentListProduct)) {
            $this->contentListProducts[] = $contentListProduct;
            $contentListProduct->setListProduct($this);
        }

        return $this;
    }

    public function removeContentListProduct(ContentListProduct $contentListProduct): self
    {
        if ($this->contentListProducts->removeElement($contentListProduct)) {
            // set the owning side to null (unless already changed)
            if ($contentListProduct->getListProduct() === $this) {
                $contentListProduct->setListProduct(null);
            }
        }

        return $this;
    }
}
