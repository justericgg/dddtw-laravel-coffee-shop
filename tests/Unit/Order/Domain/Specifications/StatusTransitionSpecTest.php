<?php

declare(strict_types=1);

namespace Order\Domain\Specifications;

use App\Order\Domain\Model\Order\OrderStatus;
use App\Order\Domain\Specifications\StatusTransitionSpec;
use Tests\TestCase;

class StatusTransitionSpecTest extends TestCase
{
    public function testIsSatisfy_WhenCurStatusIsNotEqualToPreStatus_ReturnFalse(): void
    {
        $curOrderStatus = OrderStatus::Initial();
        $preOrderStatus = OrderStatus::Cancel();
        $targetOrderStatus = OrderStatus::Closed();
        $statusTransitionSpec = new StatusTransitionSpec($curOrderStatus, $preOrderStatus, $targetOrderStatus);

        $r = $statusTransitionSpec->isSatisfy();

        $this->assertFalse($r);
    }

    public function testIsSatisfy_WhenCurStatusIsEqualToPreStatusButTargetStatusIsNotTheNextStatus_ReturnFalse(): void
    {
        $curOrderStatus = OrderStatus::Initial();
        $preOrderStatus = OrderStatus::Initial();
        $targetOrderStatus = OrderStatus::Closed();
        $statusTransitionSpec = new StatusTransitionSpec($curOrderStatus, $preOrderStatus, $targetOrderStatus);

        $r = $statusTransitionSpec->isSatisfy();

        $this->assertFalse($r);
    }

    public function testIsSatisfy_WhenCurStatusIsEqualToPreStatusAndTargetStatusIsTheNextStatus_ReturnTrue(): void
    {
        $curOrderStatus = OrderStatus::Initial();
        $preOrderStatus = OrderStatus::Initial();
        $targetOrderStatus = OrderStatus::Processing();
        $statusTransitionSpec = new StatusTransitionSpec($curOrderStatus, $preOrderStatus, $targetOrderStatus);

        $r = $statusTransitionSpec->isSatisfy();

        $this->assertTrue($r);
    }
}