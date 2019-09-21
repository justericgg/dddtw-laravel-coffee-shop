<?php

declare(strict_types=1);

namespace Order\Domain\Order\Specification;

use Common\Specification;
use Order\Domain\Order\Model\OrderStatus;

class StatusTransitionSpec extends Specification
{
    private $previousStatus;
    private $targetStatus;

    public function __construct(OrderStatus $oriStatus, OrderStatus $previousStatus, OrderStatus $targetStatus)
    {
        $this->entity = $oriStatus;
        $this->previousStatus = $previousStatus;
        $this->targetStatus = $targetStatus;
    }

    public function predicate(): callable
    {
        return function (OrderStatus $oriStatus): bool {
            return $oriStatus->getValue() === $this->previousStatus->getValue() &&
                abs($this->previousStatus->getValue() - $this->targetStatus->getValue()) === 1;
        };
    }
}