<?php

declare(strict_types=1);

namespace App\Order\Domain\Model\Order;

use App\Base\EntityId;

class OrderId extends EntityId
{
    public function getAbbr(): string
    {
        return 'ord';
    }
}