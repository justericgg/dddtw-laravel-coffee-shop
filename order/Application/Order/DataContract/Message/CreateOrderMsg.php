<?php

declare(strict_types=1);

namespace Order\Application\Order\DataContract\Message;

use Order\Application\Order\DataContract\Result\OrderItemRst;

class CreateOrderMsg
{
    public $tableNo;
    public $items;

    public function __construct(string $tableNo, OrderItemRst $items)
    {
        $this->tableNo = $tableNo;
        $this->items = $items;
    }
}