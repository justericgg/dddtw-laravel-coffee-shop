<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use Common\EntityId;

class OrderId extends EntityId
{
    public function getAbbr(): string
    {
        return 'ord';
    }
}