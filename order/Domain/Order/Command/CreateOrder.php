<?php

declare(strict_types=1);

use Order\Domain\Order\Model\OrderId;
use Order\Domain\Order\Model\OrderStatus;

class CreateOrder
{
    private $orderId;
    private $status;
    private $tableNo;
    private $items;

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getTableNo(): string
    {
        return $this->tableNo;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function createOrder(OrderId $orderId, string $tableNo, OrderStatus $status, array $items): void
    {
        $this->orderId = $orderId;
        $this->tableNo = $tableNo;
        $this->status = $status;
        $this->items = $items;
    }
}