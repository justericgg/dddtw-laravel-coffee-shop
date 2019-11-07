<?php

declare(strict_types=1);

namespace Order\Domain\Order\DomainEvent;

use Justericgg\DDD\Common\DomainEvent;
use DateTime;
use Order\Domain\Order\Model\OrderId;
use Order\Domain\Order\Model\OrderStatus;

class OrderStatusChanged extends DomainEvent
{
    private $entityId;
    private $lastStatus;
    private $currentStatus;
    private $modifiedDate;

    public function __construct(OrderId $orderId, OrderStatus $lastStatus, OrderStatus $currentStatus, DateTime $modifiedDate)
    {
        $this->entityId = $orderId;
        $this->lastStatus = $lastStatus;
        $this->currentStatus = $currentStatus;
        $this->modifiedDate = $modifiedDate;

        parent::__construct(new DateTime());
    }

    public function getDerivedEventEqualityComponents(): array
    {
        return [
            $this->entityId,
            $this->lastStatus,
            $this->currentStatus,
            $this->modifiedDate,
        ];
    }
}