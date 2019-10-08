<?php

declare(strict_types=1);

namespace Order\Application\Order\DataContract\Result;

use DateTime;
use Order\Domain\Order\Model\Order;
use Order\Domain\Order\Model\OrderStatus;

class OrderRst
{
    private $id;
    private $status;
    private $items;
    private $createDate;
    private $modifyDate;

    /**
     * OrderRst constructor.
     * @param string $id
     * @param OrderStatus $status
     * @param OrderItemRst[] $items
     * @param DateTime $createDate
     * @param DateTime|null $modifyDate
     */
    public function __construct(string $id, OrderStatus $status, array $items, DateTime $createDate, ?DateTime $modifyDate = null)
    {
        $this->id = $id;
        $this->status = $status->getValue();
        $this->items = $items;
        $this->createDate = $createDate;
        $this->modifyDate = $modifyDate;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return OrderStatus
     */
    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    /**
     * @return OrderItemRst
     */
    public function getItems(): OrderItemRst
    {
        return $this->items;
    }

    /**
     * @return DateTime
     */
    public function getCreateDate(): DateTime
    {
        return $this->createDate;
    }

    /**
     * @return DateTime|null
     */
    public function getModifyDate(): ?DateTime
    {
        return $this->modifyDate;
    }
}