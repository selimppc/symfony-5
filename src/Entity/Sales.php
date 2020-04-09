<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalesRepository")
 */
class Sales
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="sales")
     */
    private $item_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $order_qty;

    /**
     * @ORM\Column(type="integer")
     */
    private $batch_sequence;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cost_price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $sell_price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemId(): ?Product
    {
        return $this->item_id;
    }

    public function setItemId(?Product $item_id): self
    {
        $this->item_id = $item_id;

        return $this;
    }

    public function getOrderQty(): ?int
    {
        return $this->order_qty;
    }

    public function setOrderQty(int $order_qty): self
    {
        $this->order_qty = $order_qty;

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

    public function getCostPrice(): ?string
    {
        return $this->cost_price;
    }

    public function setCostPrice(string $cost_price): self
    {
        $this->cost_price = $cost_price;

        return $this;
    }

    public function getSellPrice(): ?string
    {
        return $this->sell_price;
    }

    public function setSellPrice(string $sell_price): self
    {
        $this->sell_price = $sell_price;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
