<?php

namespace Tests\Unit\Order\Domain\Model\Order;

use App\Order\Domain\Model\Order\OrderId;
use DateTime;
use Tests\TestCase;

class OrderIdTest extends TestCase
{
    public function testGetAbbr_MustReturnOrd(): void
    {
        $sut = new OrderId(0, new DateTime());

        $abbr = $sut->getAbbr();

        $this->assertEquals('ord', $abbr);
    }
}