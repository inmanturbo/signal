<?php

namespace Inmanturbo\Signal;

class Signal {

    public static function signal(
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
