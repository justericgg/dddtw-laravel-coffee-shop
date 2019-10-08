<?php

declare(strict_types=1);

namespace Order\Application\Order;

use Order\Application\Order\DataContract\Message\CreateOrderMsg;
use Order\Application\Order\DataContract\Result\OrderRst;
use Order\Application\Order\DomainService\OrderItemsTranslator;
use Order\Domain\Order\Command\CreateOrder;
use Order\Domain\Order\Exception\OrderIdIsNullException;
use Order\Domain\Order\Exception\OrderItemEmptyException;
use Order\Domain\Order\Exception\TableNoEmptyException;
use Order\Domain\Order\Model\IOrderRepository;
use Order\Domain\Order\Model\Order;
use Order\Domain\Order\Model\OrderStatus;

class CreateOrderSvc
{
    private $repository;
    private $itemsTranslator;

    public function __construct(IOrderRepository $repository, OrderItemsTranslator $itemsTranslator)
    {
        $this->repository = $repository;
        $this->itemsTranslator = $itemsTranslator;
    }

    /**
     * @param CreateOrderMsg $createOrderMsg
     * @return OrderRst
     * @throws OrderIdIsNullException
     * @throws OrderItemEmptyException
     * @throws TableNoEmptyException
     */
    public function handle(CreateOrderMsg $createOrderMsg): OrderRst
    {
        $orderId = $this->repository->generateOrderId();
        $orderItems = $this->itemsTranslator->translate($createOrderMsg->items);
        $cmd = new CreateOrder($orderId, $createOrderMsg->tableNo, OrderStatus::Initial(), $orderItems);
        $order = Order::create($cmd);

        $this->repository->save($order);

        return new OrderRst(
            $order->getOrderId()->toString(),
            $order->getOrderStatus(),
            $createOrderMsg->items,
            $order->getCreatedDate(),
            $order->getModifiedDate()
        );
    }
}