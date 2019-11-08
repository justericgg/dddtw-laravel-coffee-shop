<?php

declare(strict_types=1);

namespace Order\Domain\Order\DomainEvent;

use DDDTW\DDD\Common\DomainEvent;
use DateTime;
use Illuminate\Support\Str;
use Order\Domain\Order\Model\OrderId;

class OrderItemsChanged extends DomainEvent
{
    private $entityId;
    private $changedOrderItems;
    private $modifiedDate;

    public function __construct(OrderId $orderId, array $changedOrderItems, DateTime $modifiedDate)
    {
        $this->entityId = $orderId;
        $this->changedOrderItems = $changedOrderItems;
        $this->modifiedDate = $modifiedDate;

        parent::__construct(new DateTime());
    }

    public function getDerivedEventEqualityComponents(): array
    {
        $components = [];
        $components[] = $this->entityId;
        foreach ($this->changedOrderItems as $item) {
            $components[] = $item;
        }

        return $components;
    }

    public function generateEventId(): string
    {
        return Str::uuid()->toString();
    }
}