<?php

declare(strict_types=1);

namespace Order\Application\Order\DomainService;

use DateTime;
use Exception;
use Order\Domain\Order\Model\OrderId;

class OrderIdTranslator
{
    /**
     * @param string $orderId
     * @return OrderId
     * @throws Exception
     */
    public function translate(string $orderId): OrderId
    {
        $idString = explode('-', $orderId);

        return new OrderId((int) $idString[2], new DateTime($idString[1]));
    }
}