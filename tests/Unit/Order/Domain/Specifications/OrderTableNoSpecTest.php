<?php

declare(strict_types=1);

namespace Order\Domain\Specifications;

use App\Order\Domain\Specifications\OrderTableNoSpec;
use Tests\TestCase;

class OrderTableNoSpecTest extends TestCase
{
    public function testIsSatisfy_WhenTableNoIsEmpty_ReturnFalse(): void
    {
        $tableNo = '';
        $orderTableNoSpec = new OrderTableNoSpec($tableNo);

        $r = $orderTableNoSpec->isSatisfy();

        $this->assertFalse($r);
    }

    public function testIsSatisfy_WhenTableNoIsNotEmpty_ReturnTrue(): void
    {
        $tableNo = '1';
        $orderTableNoSpec = new OrderTableNoSpec($tableNo);

        $r = $orderTableNoSpec->isSatisfy();

        $this->assertTrue($r);
    }
}