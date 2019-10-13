<?php

declare(strict_types=1);

namespace Order\Application\Order\Service;

use Exception;
use InvalidArgumentException;
use Order\Application\Order\DataContract\Message\CancelOrderMsg;
use Order\Application\Order\DomainService\OrderIdTranslator;
use Order\Infra\Repository\Mongo\OrderRepository;

class CancelOrderSvc
{
    private $repository;
    private $idTranslator;

    public function __construct(OrderRepository $repository, OrderIdTranslator $idTranslator)
    {
        $this->repository = $repository;
        $this->idTranslator = $idTranslator;
    }

    /**
     * @param CancelOrderMsg $cancelOrderMsg
     * @throws Exception
     */
    public function handle(CancelOrderMsg $cancelOrderMsg): void
    {
        $orderId = $this->idTranslator->translate($cancelOrderMsg->id);

        $order = $this->repository->getBy($orderId);
        if ($order === null) {
            throw new InvalidArgumentException("order not found: {$cancelOrderMsg->id}");
        }

        $order->cancel();

        $this->repository->save($order);
    }
}