<?php

namespace Inmanturbo\Signal;

use Illuminate\Pipeline\Pipeline;
use ReflectionClass;
use Spatie\EventSourcing\Commands\CommandHandler;

class CommandBus
{
    private array $middlewares = [];

    public function middleware(Middleware ...$middlewares): self
    {
        $clone = clone $this;

        foreach ($middlewares as $middleware) {
            $clone->middlewares[] = $middleware;
        }

        return $clone;
    }

    public function dispatch(object $command): mixed
    {
        return (new Pipeline)
            ->through($this->middlewares)
            ->send($command)
            ->then(fn (object $command): mixed => CommandHandler::for($command)->handle());
    }

    public function dispatchWithMiddleware(object $command): mixed
    {
        $reflection = new ReflectionClass($command);

        if ($reflection->hasMethod('middleware') && $reflection->getMethod('middleware')->isStatic()) {
            $clone = $this->middleware(...$command::middleware());

            return $clone->dispatch($command);
        }

        return $this->dispatch($command);
    }
}
