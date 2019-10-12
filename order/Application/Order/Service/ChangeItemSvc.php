<?php

declare(strict_types=1);

namespace Order\Application\Order\Service;

use Exception;
use InvalidArgumentException;
use Order\Application\Order\DataContract\Message\ChangeItemMsg;
use Order\Application\Order\DataContract\Result\OrderRst;
use Order\Application\Order\DomainService\OrderIdTranslator;
use Order\Application\Order\DomainService\OrderItemsTranslator;
use Order\Domain\Order\Command\ChangeItem;
use Order\Infra\Repository\Mongo\OrderRepository;

class ChangeItemSvc
{
    private $repository;
    private $orderIdTranslator;
    private $itemsTranslator;

    public function __construct(OrderRepository $repository, OrderIdTranslator $orderIdTranslator, OrderItemsTranslator $itemsTranslator)
    {
        $this->repository = $repository;
        $this->orderIdTranslator = $orderIdTranslator;
        $this->itemsTranslator = $itemsTranslator;
    }

    /**
     * @param ChangeItemMsg $changeItemMsg
     * @return OrderRst
     * @throws Exception
     */
    public function handle(ChangeItemMsg $changeItemMsg): OrderRst
    {
        $orderId = $this->orderIdTranslator->translate($changeItemMsg->id);

        $order = $this->repository->getBy($orderId);
        if ($order === null) {
            throw new InvalidArgumentException("order not found: {$changeItemMsg->id}");
        }

        $items = $this->itemsTranslator->translate($changeItemMsg->items);

        $cmd = new ChangeItem($items);
        $order->changeItem($cmd);

        $this->repository->save($order);

        return new OrderRst(
            $order->getOrderId()->toString(),
            $order->getOrderStatus(),
            $changeItemMsg->items,
            $order->getCreatedDate(),
            $order->getModifiedDate()
        );
    }
}
