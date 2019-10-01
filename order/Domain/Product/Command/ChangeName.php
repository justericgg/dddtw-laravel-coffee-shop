<?php

declare(strict_types=1);

namespace Order\Domain\Product\Command;

class ChangeName
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}