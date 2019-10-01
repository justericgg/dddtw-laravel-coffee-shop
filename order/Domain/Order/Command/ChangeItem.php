<?php

declare(strict_types=1);

namespace Order\Domain\Order\Command;

class ChangeItem
{
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}