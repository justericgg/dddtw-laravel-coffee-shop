<?php

declare(strict_types=1);

namespace App\Base;

abstract class Specification
{
    protected $entity;

    abstract public function predicate(): callable;

    public function isSatisfy(): bool {
        return $this->predicate()($this->entity);
    }
}