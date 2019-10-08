<?php

declare(strict_types=1);

namespace Order\Application\Order\DataContract\Result;

class OrderItemRst
{
    private $productId;
    private $qty;
    private $price;
    private $fee;

    public function __construct(string $productId, int $qty, int $price)
    {
        $this->productId = $productId;
        $this->qty = $qty;
        $this->price = $price;
        $this->fee = $qty * $price;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getFee(): int
    {
        return $this->fee;
    }
}