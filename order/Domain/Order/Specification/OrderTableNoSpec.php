<?php

declare(strict_types=1);

namespace Order\Domain\Order\Specification;

use Common\Specification;

class OrderTableNoSpec extends Specification
{
    public function __construct(string $tableNo)
    {
        $this->entity = $tableNo;
    }

    public function predicate(): callable
    {
        return static function(string $tableNo): bool {
            return !empty($tableNo);
        };
    }
}