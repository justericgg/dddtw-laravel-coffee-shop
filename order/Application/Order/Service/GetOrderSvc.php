<?php

declare(strict_types=1);

namespace Order\Application\Order\Service;

use Exception;
use Order\Application\Order\DataContract\Message\GetOrderMsg;
use Order\Application\Order\DataContract\Result\OrderRst;
use Order\Application\Order\DomainService\OrderIdTranslator;
use Order\Domain\Order\Model\IOrderRepository;
use Order\Domain\Order\Model\OrderItem;

class GetOrderSvc
{
    private $repository;
    private $idTranslator;

    public function __construct(IOrderRepository $repository, OrderIdTranslator $idTranslator)
    {
        $this->repository = $repository;
        $this->idTranslator = $idTranslator;
    }

    /**
     * @param GetOrderMsg $getOrderMsg
     * @return OrderRst
     * @throws Exception
     */
    public function handle(GetOrderMsg $getOrderMsg): OrderRst
    {
        $orderId = $this->idTranslator->translate($getOrderMsg->id);
        $order = $this->repository->getBy($orderId);

        $items = [];
        foreach ($order->getItems() as $item) {
            /** @var OrderItem $item */
            $items[] = [
                'product_id' => $item->getProductId(),
                'qty' => $item->getQty(),
                'price' => $item->getPrice(),
            ];
        }

        return new OrderRst(
            $order->getOrderId()->toString(),
            $order->getOrderStatus(),
            $items,
            $order->getCreatedDate(),
            $order->getModifiedDate()
        );
    }
}