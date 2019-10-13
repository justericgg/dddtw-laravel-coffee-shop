<?php

declare(strict_types=1);

namespace Order\Application\Order\Service;

use Exception;
use InvalidArgumentException;
use Order\Application\Order\DataContract\Message\CloseOrderMsg;
use Order\Application\Order\DomainService\OrderIdTranslator;
use Order\Infra\Repository\Mongo\OrderRepository;

class CloseOrderSvc
{
    private $repository;
    private $idTranslator;

    public function __construct(OrderRepository $repository, OrderIdTranslator $idTranslator)
    {
        $this->repository = $repository;
        $this->idTranslator = $idTranslator;
    }

    /**
     * @param CloseOrderMsg $closeOrderMsg
     * @throws Exception
     */
    public function handle(CloseOrderMsg $closeOrderMsg): void
    {
        $orderId = $this->idTranslator->translate($closeOrderMsg->id);

        $order = $this->repository->getBy($orderId);
        if ($order === null) {
            throw new InvalidArgumentException("order not found: {$closeOrderMsg->id}");
        }

        $order->close();

        $this->repository->save($order);
    }
}