<?php

declare(strict_types=1);

namespace Order\Application\Order\Service;

use Exception;
use InvalidArgumentException;
use Order\Application\Order\DataContract\Message\ProcessOrderMsg;
use Order\Application\Order\DomainService\OrderIdTranslator;
use Order\Infra\Repository\Mongo\OrderRepository;

class ProcessOrderSvc
{
    private $repository;
    private $idTranslator;

    public function __construct(OrderRepository $repository, OrderIdTranslator $idTranslator)
    {
        $this->repository = $repository;
        $this->idTranslator = $idTranslator;
    }

    /**
     * @param ProcessOrderMsg $processOrderMsg
     * @throws Exception
     */
    public function handle(ProcessOrderMsg $processOrderMsg): void
    {
        $orderId = $this->idTranslator->translate($processOrderMsg->id);

        $order = $this->repository->getBy($orderId);
        if ($order === null) {
            throw new InvalidArgumentException("order not found: {$processOrderMsg->id}");
        }

        $order->process();

        $this->repository->save($order);
    }
}