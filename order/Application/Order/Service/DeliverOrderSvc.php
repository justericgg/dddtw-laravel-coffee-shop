<?php

declare(strict_types=1);

namespace Order\Application\Order\Service;

use Exception;
use InvalidArgumentException;
use Order\Application\Order\DataContract\Message\DeliverOrderMsg;
use Order\Application\Order\DomainService\OrderIdTranslator;
use Order\Infra\Repository\Mongo\OrderRepository;

class DeliverOrderSvc
{
    private $repository;
    private $idTranslator;

    public function __construct(OrderRepository $repository, OrderIdTranslator $idTranslator)
    {
        $this->repository = $repository;
        $this->idTranslator = $idTranslator;
    }

    /**
     * @param DeliverOrderMsg $deliverOrderMsg
     * @throws Exception
     */
    public function handle(DeliverOrderMsg $deliverOrderMsg): void
    {
        $orderId = $this->idTranslator->translate($deliverOrderMsg->id);

        $order = $this->repository->getBy($orderId);
        if ($order === null) {
            throw new InvalidArgumentException("order not found: {$deliverOrderMsg->id}");
        }

        $order->deliver();

        $this->repository->save($order);
    }
}