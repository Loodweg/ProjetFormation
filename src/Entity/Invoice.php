<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(inversedBy: 'invoice', targetEntity: Purchase::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $purchase;

    #[ORM\Column(type: 'integer')]
    private $total;

    #[ORM\Column(type: 'boolean')]
    private $isPayed;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: ContentInvoice::class, orphanRemoval: true)]
    private $contentInvoices;

    public function __construct()
    {
        $this->contentInvoices = new ArrayCollection();
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

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getIsPayed(): ?bool
    {
        return $this->isPayed;
    }

    public function setIsPayed(bool $isPayed): self
    {
        $this->isPayed = $isPayed;

        return $this;
    }

    /**
     * @return Collection|ContentInvoice[]
     */
    public function getContentInvoices(): Collection
    {
        return $this->contentInvoices;
    }

    public function addContentInvoice(ContentInvoice $contentInvoice): self
    {
        if (!$this->contentInvoices->contains($contentInvoice)) {
            $this->contentInvoices[] = $contentInvoice;
            $contentInvoice->setInvoice($this);
        }

        return $this;
    }

    public function removeContentInvoice(ContentInvoice $contentInvoice): self
    {
        if ($this->contentInvoices->removeElement($contentInvoice)) {
            // set the owning side to null (unless already changed)
            if ($contentInvoice->getInvoice() === $this) {
                $contentInvoice->setInvoice(null);
            }
        }

        return $this;
    }
}
