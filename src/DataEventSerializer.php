<?php

namespace Inmanturbo\Signal;

use Spatie\EventSourcing\EventSerializers\JsonEventSerializer;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class DataEventSerializer extends JsonEventSerializer
{
    public function serialize(ShouldBeStored $event): string
    {
        if ($event instanceof EventWithData) {
            return $event->toJson();
        }

        return parent::serialize($event);
    }

    public function deserialize(string $eventClass, string $json, int $version, ?string $metadata = null): ShouldBeStored
    {
        if (is_subclass_of($eventClass, EventWithData::class)) {
            return $eventClass::from(json_decode($json, true));
        }

        return parent::deserialize($eventClass, $json, $version, $metadata);
    }
}