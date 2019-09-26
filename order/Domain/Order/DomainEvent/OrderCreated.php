<?php

declare(strict_types=1);

use Common\DomainEvent;
use Order\Domain\Order\Model\OrderId;

class OrderCreated extends DomainEvent
{
    private $entityId;
    private $tableNo;
    private $orderItems;
    private $createDate;

    public function __construct(OrderId $orderId, string $tableNo, array $orderItems, DateTime $createDate)
    {
        $this->entityId = $orderId;
        $this->tableNo = $tableNo;
        $this->orderItems = $orderItems;
        $this->createDate = $createDate;

        parent::__construct(new DateTime());
    }

    public function getDerivedEventEqualityComponents(): array
    {
        $components = [];
        $components[] = $this->entityId;
        foreach ($this->orderItems as $item) {
            $components[] = $item;
        }
        $components[] = $this->createDate;

        return $components;
    }
}