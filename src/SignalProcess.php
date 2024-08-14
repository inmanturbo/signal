<?php

namespace Inmanturbo\Signal;

class SignalProcess
{
    public static function subject(
        $aggregate,
        $command,
        Event $event,
    )
    {
        return new static($aggregate, $command, $event);
    }

    private function __construct(
        public $aggregate,
        public $command,
        public $event,
    )
    {
        SignalMessage::process($aggregate, $command, $event);
    }
} 