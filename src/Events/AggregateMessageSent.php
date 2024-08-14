<?php

namespace Inmanturbo\Signal\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Inmanturbo\Signal\Event;

class AggregateMessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $name;

    public function __construct(
        public $aggregate,
        public $command,
        public Event $event,
    )
    {
        $this->name = $event->event_name;
    }
}