<?php

declare(strict_types=1);

namespace App\Order\Domain\Model\Order;

use App\Base\Entity;
use DateTime;

class Order extends Entity
{
    private $orderId;
    private $tableNo;
    private $createdDate;
    private $modifiedDate;
    private $orderStatus;

    private function __construct(
        string $orderId,
        string $tableNo,
        OrderStatus $orderStatus,
        array $items,
        DateTime $createdDate,
        ?DateTime $modifiedDate
    ) {
        $this->orderId = $orderId;
        $this->tableNo = $tableNo;
        $this->items = $items;
        $this->orderStatus = $orderStatus;
        $this->createdDate = $createdDate;
        $this->modifiedDate = $modifiedDate;
    }



    public function getIdentity(): string
    {
        $this->orderId;
    }
}