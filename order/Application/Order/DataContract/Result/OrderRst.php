<?php

declare(strict_types=1);

namespace Order\Application\Order\DataContract\Result;

use DateTime;
use Order\Domain\Order\Model\OrderStatus;

class OrderRst
{
    public $id;
    public $status;
    public $items;
    public $createDate;
    public $modifyDate;

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
}