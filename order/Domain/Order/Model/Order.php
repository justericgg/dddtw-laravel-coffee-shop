<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use Common\Entity;
use DateTime;
use Order\Domain\Order\Command\ChangeItem;
use Order\Domain\Order\Command\CreateOrder;
use Order\Domain\Order\DomainEvent\OrderCreated;
use Order\Domain\Order\DomainEvent\OrderItemsChanged;
use Order\Domain\Order\DomainEvent\OrderStatusChanged;
use Order\Domain\Order\Exception\OrderIdIsNullException;
use Order\Domain\Order\Exception\OrderItemEmptyException;
use Order\Domain\Order\Exception\StatusTransitionException;
use Order\Domain\Order\Exception\TableNoEmptyException;
use Order\Domain\Order\Policy\OrderPolicy;
use Order\Domain\Order\Specification\StatusTransitionSpec;

class Order extends Entity
{
    private $orderId;
    private $tableNo;
    private $items;
    private $createdDate;
    private $modifiedDate;
    private $orderStatus;

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getTableNo(): string
    {
        return $this->tableNo;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCreatedDate(): DateTime
    {
        return $this->createdDate;
    }

    public function getModifiedDate(): ?DateTime
    {
        return $this->modifiedDate;
    }

    public function getOrderStatus(): OrderStatus
    {
        return $this->orderStatus;
    }

    private function __construct(
        OrderId $orderId,
        string $tableNo,
        OrderStatus $orderStatus,
        array $items,
        DateTime $createdDate,
        ?DateTime $modifiedDate = null
    ) {
        $this->orderId = $orderId;
        $this->tableNo = $tableNo;
        $this->items = $items;
        $this->orderStatus = $orderStatus;
        $this->createdDate = $createdDate;
        $this->modifiedDate = $modifiedDate;

        parent::__construct();
    }

    /**
     * @param CreateOrder $cmd
     * @return Order
     * @throws OrderIdIsNullException
     * @throws OrderItemEmptyException
     * @throws TableNoEmptyException
     */
    public static function create(CreateOrder $cmd): Order
    {
        $order = new Order($cmd->getOrderId(), $cmd->getTableNo(), $cmd->getStatus(), $cmd->getItems(), new DateTime());

        $orderPolicy = new OrderPolicy();
        $orderPolicy->verify($order);

        $order->applyEvent(new OrderCreated($order->getOrderId(), $order->getTableNo(), $order->getItems(), $order->getCreatedDate()));

        return $order;
    }

    public function changeItem(ChangeItem $cmd): void
    {
        $newItems = $cmd->getItems();

        if ($newItems === null) {
            return;
        }

        $this->items = $newItems;
        $this->modifiedDate = new DateTime();

        $this->applyEvent(new OrderItemsChanged($this->orderId, $this->items, $this->modifiedDate));
    }

    public function getIdentity(): string
    {
        return $this->orderId->toString();
    }

    /**
     * @param OrderStatus $prevStatus
     * @param OrderStatus $targetStatus
     * @throws StatusTransitionException
     */
    private function verifyStatus(OrderStatus $prevStatus, OrderStatus $targetStatus): void
    {
        if ($this->orderStatus->getValue() === $targetStatus->getValue()) {
            return;
        }

        $spec = new StatusTransitionSpec($this->orderStatus, $prevStatus, $targetStatus);
        if ($spec->isSatisfy() === false) {
            throw new StatusTransitionException($this->orderStatus, $targetStatus);
        }
    }

    private function changeStatus(OrderStatus $orderStatus): void
    {
        $oriStatus = $this->orderStatus;
        $this->orderStatus = $orderStatus;
        $this->modifiedDate = new DateTime();

        $this->applyEvent(new OrderStatusChanged($this->orderId, $oriStatus, $this->orderStatus, $this->modifiedDate));
    }
}