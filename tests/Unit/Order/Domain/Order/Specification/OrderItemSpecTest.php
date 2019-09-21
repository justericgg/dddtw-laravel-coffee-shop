<?php

declare(strict_types=1);

namespace Order\Domain\Order\Specification;

use Order\Domain\Order\Model\OrderItem;
use Tests\TestCase;

class OrderItemSpecTest extends TestCase
{
    public function testIsSatisfy_WhenListContainsANoneOrderItemObject_ReturnFalse(): void
    {
        $items = [];
        $items[] = 'something else';
        $orderItemSpec = new OrderItemSpec($items);

        $r = $orderItemSpec->isSatisfy();

        $this->assertFalse($r);
    }

    public function testIsSatisfy_WhenItemsIsEmpty_ReturnFalse(): void
    {
        $items = [];
        $orderItemSpec = new OrderItemSpec($items);

        $r = $orderItemSpec->isSatisfy();

        $this->assertFalse($r);
    }

    public function testisSatisfy_WhenItemsIsValid_ReturnTrue(): void
    {
        $items = [];
        $items[] = new OrderItem('1', 1, 100);
        $items[] = new OrderItem('1', 1, 100);
        $orderItemSpec = new OrderItemSpec($items);

        $r = $orderItemSpec->isSatisfy();

        $this->assertTrue($r);
    }
}