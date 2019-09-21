<?php

declare(strict_types=1);

namespace Order\Domain\Order\Exception;

use Common\DomainException;
use Throwable;

class TableNoEmptyException extends DomainException
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Table no can not be empty', 3, $previous);
    }
}