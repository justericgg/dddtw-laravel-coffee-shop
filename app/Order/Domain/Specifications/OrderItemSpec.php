<?php

declare(strict_types=1);

namespace App\Order\Domain\Specifications;

use App\Base\Specification;
use App\Order\Domain\Model\Order\OrderItem;

class OrderItemSpec extends Specification
{
    public function __construct(array $items)
    {
        $this->entity = $items;
    }

    public function predicate(): callable
    {
        return static function(array $items): bool {

            if (empty($items)) {
                return false;
            }

            foreach ($items as $item) {
                if (!$item instanceof OrderItem) {
                    return false;
                }
            }

            return true;
        };
    }
}