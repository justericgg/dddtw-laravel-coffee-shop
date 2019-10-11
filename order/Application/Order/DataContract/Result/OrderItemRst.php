<?php

declare(strict_types=1);

namespace Order\Application\Order\DataContract\Result;

class OrderItemRst
{
    public $productId;
    public $qty;
    public $price;
    public $fee;

    public function __construct(string $productId, int $qty, int $price)
    {
        $this->productId = $productId;
        $this->qty = $qty;
        $this->price = $price;
        $this->fee = $qty * $price;
    }
}