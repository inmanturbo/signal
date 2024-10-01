<?php

namespace Inmanturbo\Signal\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Inmanturbo\Signal\Signal
 */
class Signal extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Inmanturbo\Signal\Signal::class;
    }
}
