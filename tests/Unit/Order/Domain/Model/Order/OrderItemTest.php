<?php

declare(strict_types=1);

namespace Tests\Unit\Order\Domain\Model\Order;

use App\Order\Domain\Model\Order\OrderItem;
use Tests\TestCase;

class OrderItemTest extends TestCase
{
    public function testGetFee_WillReturnPriceTimesQty(): void
    {
        $orderItem = new OrderItem('PRODUCT_ID', 2, 100);
        $r = $orderItem->getFee();

        $this->assertEquals(200, $r);
    }
}
