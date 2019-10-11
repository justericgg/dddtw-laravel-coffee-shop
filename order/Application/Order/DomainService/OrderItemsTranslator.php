<?php

declare(strict_types=1);

namespace Order\Application\Order\DomainService;

use Order\Application\Order\DataContract\Result\OrderItemRst;
use Order\Domain\Order\Model\OrderItem;

class OrderItemsTranslator
{
    /**
     * @param OrderItemRst[] $items
     * @return OrderItem[]
     */
    public function translate(array $items): array
    {
        $orderItems = [];
        foreach ($items as $item) {
            $orderItems[] = new OrderItem($item->productId, $item->qty, $item->price);
        }
        return $orderItems;
    }
}