<?php

declare(strict_types=1);

namespace App\Order\Domain\Order\Exception;

use App\Base\DomainException;
use Throwable;

class OrderIdIsNullException extends DomainException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Order Id can not be null', 1, $previous);
    }
}