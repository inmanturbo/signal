<?php

namespace Inmanturbo\Signal;

use Illuminate\Support\Facades\Event;
use Inmanturbo\Signal\Events\AggregateMessageSent;
use Inmanturbo\Signal\Events\SignalMessageSent;

class SignalMessage {

    public static function process()
    {
        return new static;
    }

    private function __construct()
    {
        Event::listen(SignalMessageSent::class, function(SignalMessageSent $event) {
            AggregateMessageSent::dispatch([
                'aggregate' => $event->aggregate,
                'command' => $event->command,
                'event' => $event->event,
            ]);
            event($event->event->event_name->name, [
                'aggregate' => $event->aggregate,
                'command' => $event->command,
                'event' => $event->event,
            ]);
        });
    }
}
