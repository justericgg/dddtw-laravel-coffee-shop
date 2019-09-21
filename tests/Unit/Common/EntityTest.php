<?php

namespace Tests\Unit\Base;

use Common\Entity;
use Tests\TestCase;

class EntityTest extends TestCase
{
    public function testEquals_TwoIdentitiesAreTheSame_ReturnTrue(): void
    {
        $entityA = new MyEntity('123');
        $entityB = new MyEntity('123');

        $this->assertTrue($entityA->equals($entityB));
    }

    public function testEquals_TwoIdentitiesAreDifferent_ReturnFalse(): void
    {
        $entityA = new MyEntity('123');
        $entityB = new MyEntity('124');

        $this->assertFalse($entityA->equals($entityB));
    }
}

class MyEntity extends Entity
{
    private $myId;

    public function __construct(string $myId)
    {
        $this->myId = $myId;
    }

    public function getIdentity(): string
    {
        return $this->myId;
    }
}
