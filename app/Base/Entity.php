<?php

declare(strict_types=1);

namespace App\Base;

abstract class Entity
{
    abstract public function getIdentity(): string;

    public function equals(?Entity $entity): bool
    {
        if ($entity === null) {
            return false;
        }

        return $this->getIdentity() === $entity->getIdentity();
    }
}