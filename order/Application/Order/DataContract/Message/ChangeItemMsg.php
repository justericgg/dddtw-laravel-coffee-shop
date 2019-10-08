<?php

declare(strict_types=1);

namespace Order\Application\Order\DataContract\Message;

use Order\Application\Order\DataContract\Result\OrderItemRst;

class ChangeItemMsg
{
    public $id;
    public $items;

    public function __construct(string $id, OrderItemRst $items)
    {
        $this->id = $id;
        $this->items = $items;
    }
}