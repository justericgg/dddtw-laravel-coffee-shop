<?php

declare(strict_types=1);

namespace Order\Domain\Order\Specification;

use DDDTW\DDD\Common\Specification;
use Order\Domain\Order\Model\OrderId;

class OrderIdSpec extends Specification
{
    public function __construct(OrderId $entity) {
        $this->entity = $entity;
    }

    public function predicate(): callable
    {
        return static function(OrderId $orderId): bool {
            if (preg_match('/^ord-\d{8}-\d{1,}$/', $orderId->toString(), $matches)) {
                return true;
            }
            return false;
        };
    }
}