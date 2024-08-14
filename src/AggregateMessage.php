<?php

namespace Inmanturbo\Signal;

use Illuminate\Support\Facades\Event;
use Inmanturbo\Signal\Events\AggregateMessageSent;

class AggregateMessage
{
    public static function process()
    {
        return new static;
    }

    private function __construct()
    {
        Event::listen(AggregateMessageSent::class, function(AggregateMessageSent $event) {
            event($event->event->event_name->name, [
                'aggregate' => $event->aggregate,
                'command' => $event->command,
                'event' => $event->event,
            ]);
        });
    }
}