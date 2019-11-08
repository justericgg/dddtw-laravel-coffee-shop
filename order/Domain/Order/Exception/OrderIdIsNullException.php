<?php

declare(strict_types=1);

namespace Order\Domain\Order\Exception;

use DDDTW\DDD\Common\DomainException;
use Throwable;

class OrderIdIsNullException extends DomainException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Order Id can not be null', 1, $previous);
    }
}