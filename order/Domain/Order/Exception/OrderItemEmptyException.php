<?php

declare(strict_types=1);

namespace Order\Domain\Order\Exception;

use DDDTW\DDD\Common\DomainException;
use Throwable;

class OrderItemEmptyException extends DomainException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('OrderItem can not be empty or null', 2, $previous);
    }
}