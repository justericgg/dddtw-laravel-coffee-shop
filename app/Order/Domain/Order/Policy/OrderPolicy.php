<?php

declare(strict_types=1);

namespace App\Order\Domain\Order\Policy;

use App\Base\DomainException;
use App\Order\Domain\Order\Exception\OrderIdIsNullException;
use App\Order\Domain\Order\Exception\OrderItemEmptyException;
use App\Order\Domain\Order\Exception\TableNoEmptyException;
use App\Order\Domain\Order\Model\Order;
use App\Order\Domain\Order\Specification\OrderIdSpec;
use App\Order\Domain\Order\Specification\OrderItemSpec;
use App\Order\Domain\Order\Specification\OrderTableNoSpec;

class OrderPolicy
{
    /**
     * @param Order $order
     * @throws DomainException
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