<?php

namespace Inmanturbo\Signal;

class Event
{
    public function __construct(
        public int $aggregate_version = 1,
        public string $aggregate_id,
        public SignalEvent $event_name,
        public array $data,
    ){}
}