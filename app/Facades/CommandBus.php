<?php

namespace Inmanturbo\Signal\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed dispatch(object $command)
 * @method static mixed dispatchWithMiddleware(object $command)
 * @method static self middleware(\Inmanturbo\Signal\Middleware ...$middlewares)
 *
 * @see \Inmanturbo\Signal\CommandBus
 */
class CommandBus extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Inmanturbo\Signal\CommandBus::class;
    }
}
