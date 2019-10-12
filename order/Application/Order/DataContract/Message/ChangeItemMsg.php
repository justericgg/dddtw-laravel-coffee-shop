<?php

declare(strict_types=1);

namespace Order\Application\Order\DataContract\Message;

class ChangeItemMsg
{
    public $id;
    public $items;

    public function __construct(string $id, array $items)
    {
        $this->id = $id;
        $this->items = $items;
    }
}