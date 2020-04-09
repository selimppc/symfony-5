<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128, options={"default" : "Gnomes"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cost_price;

    /**
     * @ORM\Column( type="integer")
     */
    private $batch_sequence;

    /**
     * @ORM\Column(type="datetime")
     */
    private $purchase_date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sales", mappedBy="item_id")
     */
    private $sales;

    public function __construct()
    {
        $this->sales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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

    public function getCostPrice(): ?string
    {
        return $this->cost_price;
    }

    public function setCostPrice(string $cost_price): self
    {
        $this->cost_price = $cost_price;

        return $this;
    }

    public function getBatchSequence(): ?int
    {
        return $this->batch_sequence;
    }

    public function setBatchSequence(int $batch_sequence): self
    {
        $this->batch_sequence = $batch_sequence;
        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchase_date;
    }

    public function setPurchaseDate(\DateTimeInterface $purchase_date): self
    {
        $this->purchase_date = $purchase_date->getTimestamp();

        return $this;
    }

    /**
     * @return Collection|Sales[]
     */
    public function getSales(): Collection
    {
        return $this->sales;
    }

    public function addSale(Sales $sale): self
    {
        if (!$this->sales->contains($sale)) {
            $this->sales[] = $sale;
            $sale->setItemId($this);
        }

        return $this;
    }

    public function removeSale(Sales $sale): self
    {
        if ($this->sales->contains($sale)) {
            $this->sales->removeElement($sale);
            // set the owning side to null (unless already changed)
            if ($sale->getItemId() === $this) {
                $sale->setItemId(null);
            }
        }

        return $this;
    }
}
