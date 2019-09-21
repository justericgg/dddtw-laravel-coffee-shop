<?php

declare(strict_types=1);

namespace Order\Domain\Order\Policy;

use Order\Domain\Order\Exception\OrderIdIsNullException;
use Order\Domain\Order\Exception\OrderItemEmptyException;
use Order\Domain\Order\Exception\TableNoEmptyException;
use Order\Domain\Order\Model\Order;
use Order\Domain\Order\Specification\OrderIdSpec;
use Order\Domain\Order\Specification\OrderItemSpec;
use Order\Domain\Order\Specification\OrderTableNoSpec;

class OrderPolicy
{
    /**
     * @param Order $order
     * @throws OrderIdIsNullException
     * @throws OrderItemEmptyException
     * @throws TableNoEmptyException
     */
    public function verify(Order $order): void
    {
        $orderIdSpec = new OrderIdSpec($order->getOrderId());
        if (!$orderIdSpec->isSatisfy()) {
            throw new OrderIdIsNullException();
        }

        $orderTableNoSpec = new OrderTableNoSpec($order->getTableNo());
        if (!$orderTableNoSpec->isSatisfy()) {
            throw new TableNoEmptyException();
        }

        $orderItemSpec = new OrderItemSpec($order->getItems());
        if (!$orderItemSpec->isSatisfy()) {
            throw new OrderItemEmptyException();
        }
    }
}