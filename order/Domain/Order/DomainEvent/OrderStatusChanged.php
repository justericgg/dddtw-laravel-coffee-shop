<?php

declare(strict_types=1);

namespace Order\Domain\Order\DomainEvent;

use DDDTW\DDD\Common\DomainEvent;
use DateTime;
use Illuminate\Support\Str;
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

    public function generateEventId(): string
    {
        return Str::uuid()->toString();
    }
}