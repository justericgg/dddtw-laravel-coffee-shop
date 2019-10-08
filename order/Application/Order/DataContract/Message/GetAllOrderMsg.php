<?php

declare(strict_types=1);

namespace Order\Application\Order\DataContract\Message;

class GetAllOrderMsg
{
    public $pageNo;
    public $pageSize;

    public function __construct(int $pageNo, int $pageSize)
    {
        $this->pageNo = $pageNo;
        $this->pageSize = $pageSize;
    }
}