<?php

declare(strict_types=1);

namespace Order\Domain\Order\Specification;

use DateTime;
use Order\Domain\Order\Model\OrderId;
use Tests\TestCase;

class OrderIdSpecTest extends TestCase
{
    public function testIsSatisfy_Pass(): void {

        $orderIdSpec = new OrderIdSpec(new OrderId(10, new DateTime()));

        $r = $orderIdSpec->isSatisfy();

        $this->assertTrue($r);
    }
}