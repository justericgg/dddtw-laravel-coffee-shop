<?php

declare(strict_types=1);

namespace Order\Domain\Specifications;

use App\Order\Domain\Model\Order\OrderId;
use App\Order\Domain\Specifications\OrderIdSpec;
use DateTime;
use Tests\TestCase;

class OrderIdSpecTest extends TestCase
{
    public function testIsSatisfy_Pass(): void {

        $orderIdSpec = new OrderIdSpec(new OrderId(10, new DateTime()));

        $r = $orderIdSpec->isSatisfy();

        $this->assertTrue($r);
    }
}