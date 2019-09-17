<?php

namespace Tests\Unit\Base;

use App\Base\EntityId;
use DateTime;
use InvalidArgumentException;
use Tests\TestCase;

class EntityIdTest extends TestCase
{
    public function testConstruct_WhenSeqNoLessThanZero_ThrowInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new MyEntityId(-1, new DateTime());
    }

    public function testToString_MustReturnFormatSeqOccuredDateAbbr(): void
    {
        $sut = new MyEntityId(0, new DateTime('2019-01-01 13:14:15'));

        $r = $sut->toString();

        $this->assertEquals('0-20190101131415-test', $r);
    }
}

class MyEntityId extends EntityId
{
    public function getAbbr(): string
    {
        return 'test';
    }
}
