<?php

namespace Tests\Unit\Order\Domain\Order\Model;

use DateTime;
use Order\Domain\Order\Model\OrderId;
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