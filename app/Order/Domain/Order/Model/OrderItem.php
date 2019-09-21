<?php

declare(strict_types=1);

namespace App\Order\Domain\Order\Model;

use App\Base\ValueObject;

class OrderItem extends ValueObject
{
    private $productId;
    private $qty;
    private $price;

    public function __construct(string $productId, int $qty, int $price)
    {
        $this->productId = $productId;
        $this->qty = $qty;
        $this->price = $price;
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
        return $this->qty * $this->price;
    }

    public function getEqualityComponents(): array
    {
        return [
            $this->productId,
            $this->qty,
            $this->price,
        ];
    }
}