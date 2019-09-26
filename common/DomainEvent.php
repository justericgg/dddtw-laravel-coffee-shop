<?php

declare(strict_types=1);

namespace Common;

use DateTime;
use Illuminate\Support\Str;

abstract class DomainEvent
{
    protected $eventId;
    protected $occuredDate;

    public function __construct(?DateTime $occuredDate = null)
    {
        $this->eventId = Str::uuid()->toString();
        $this->occuredDate = $occuredDate ?? new DateTime();
    }

    abstract public function getDerivedEventEqualityComponents(): array;

    public function getEventId(): string
    {
        return $this->eventId;
    }

    public function getOccuredDate(): DateTime
    {
        return $this->occuredDate;
    }

    public function getEqualityComponents(): array
    {
        $components = [];
        $components[] = $this->eventId;
        $components[] = $this->occuredDate;
        $components[] = $this->getDerivedEventEqualityComponents();

        return $components;
    }
}