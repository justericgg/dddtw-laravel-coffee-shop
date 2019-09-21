<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use Common\Entity;
use DateTime;

class Order extends Entity
{
    private $orderId;
    private $tableNo;
    private $items;
    private $createdDate;
    private $modifiedDate;
    private $orderStatus;

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getTableNo(): string
    {
        return $this->tableNo;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCreatedDate(): DateTime
    {
        return $this->createdDate;
    }

    public function getModifiedDate(): ?DateTime
    {
        return $this->modifiedDate;
    }

    public function getOrderStatus(): OrderStatus
    {
        return $this->orderStatus;
    }

    private function __construct(
        OrderId $orderId,
        string $tableNo,
        OrderStatus $orderStatus,
        array $items,
        DateTime $createdDate,
        ?DateTime $modifiedDate
    ) {
        $this->orderId = $orderId;
        $this->tableNo = $tableNo;
        $this->items = $items;
        $this->orderStatus = $orderStatus;
        $this->createdDate = $createdDate;
        $this->modifiedDate = $modifiedDate;
    }

    public function getIdentity(): string
    {
        return $this->orderId->toString();
    }
}