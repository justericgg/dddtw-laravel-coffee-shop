<?php

declare(strict_types=1);

namespace App\Base;

use DateTime;
use InvalidArgumentException;

abstract class EntityId extends ValueObject
{
    protected $seqNo;
    protected $occuredDate;

    abstract public function getAbbr(): string;

    public function __construct(int $seqNo, DateTime $occuredDate)
    {
        if ($seqNo < 0) {
            throw new InvalidArgumentException('SeqNo can not be negative digital');
        }

        $this->seqNo = $seqNo;
        $this->occuredDate = $occuredDate;
    }

    public function toString(): string
    {
        return "{$this->seqNo}-{$this->occuredDate->format('YmdHis')}-{$this->getAbbr()}";
    }

    public function getEqualityComponents(): array
    {
        return [
            $this->seqNo,
            $this->occuredDate->format('YmdHis'),
            $this->getAbbr(),
        ];
    }
}