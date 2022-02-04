<?php

namespace App\Entity;

use App\Repository\ContentInvoiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentInvoiceRepository::class)]
class ContentInvoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Invoice::class, inversedBy: 'contentInvoices')]
    #[ORM\JoinColumn(nullable: false)]
    private $invoice;

    #[ORM\Column(type: 'string', length: 255)]
    private $productName;

    #[ORM\Column(type: 'integer')]
    private $priceProduct;

    #[ORM\Column(type: 'string', length: 255)]
    private $imageProduct;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getPriceProduct(): ?int
    {
        return $this->priceProduct;
    }

    public function setPriceProduct(int $priceProduct): self
    {
        $this->priceProduct = $priceProduct;

        return $this;
    }

    public function getImageProduct(): ?string
    {
        return $this->imageProduct;
    }

    public function setImageProduct(string $imageProduct): self
    {
        $this->imageProduct = $imageProduct;

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
