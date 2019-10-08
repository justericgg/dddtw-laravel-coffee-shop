<?php

namespace Order\Domain\Order\Model;

interface IOrderRepository
{
    public function generateOrderId(): OrderId;
    public function getBy(OrderId $orderId): Order;
    public function save(Order $order);
}