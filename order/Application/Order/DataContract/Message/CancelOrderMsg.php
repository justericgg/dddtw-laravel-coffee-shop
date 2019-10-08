<?php

declare(strict_types=1);

namespace Order\Application\Order\DataContract\Message;

class CancelOrderMsg
{
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}