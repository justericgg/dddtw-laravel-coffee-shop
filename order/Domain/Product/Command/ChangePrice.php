<?php

declare(strict_types=1);

namespace Order\Domain\Product\Command;

class ChangePrice
{
    private $price;
    private $discount;

    public function __construct(int $price, int $discount)
    {
        $this->price = $price;
        $this->discount = $discount;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }
}