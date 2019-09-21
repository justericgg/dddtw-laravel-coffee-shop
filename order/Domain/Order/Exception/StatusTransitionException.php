<?php

declare(strict_types=1);

namespace Order\Domain\Order\Exception;

use App\Order\Domain\Order\Model\OrderStatus;
use Common\DomainException;
use Throwable;

class StatusTransitionException extends DomainException
{
    public function __construct(OrderStatus $curStatus, OrderStatus $targetStatus, Throwable $previous = null)
    {
        parent::__construct("Can not transit order status from {$curStatus->getValue()} to {$targetStatus->getValue()}", 0, $previous);
    }
}