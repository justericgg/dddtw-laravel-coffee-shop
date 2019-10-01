<?php

declare(strict_types=1);

namespace Order\Domain\Product\Command;

class ChangeDescription
{
    private $desc;

    public function __construct(string $desc)
    {
        $this->desc = $desc;
    }

    public function getDescription(): string
    {
        return $this->desc;
    }
}