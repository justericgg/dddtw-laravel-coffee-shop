<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use Justericgg\DDD\Common\Enum;

/**
 * @method static OrderStatus Initial()
 * @method static OrderStatus Processing()
 * @method static OrderStatus Deliver()
 * @method static OrderStatus Closed()
 * @method static OrderStatus Cancel()
 */
class OrderStatus extends Enum
{
    private const Initial = 0;
    private const Processing = 1;
    private const Deliver = 2;
    private const Closed = 3;
    private const Cancel = 4;
}