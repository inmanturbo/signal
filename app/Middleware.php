<?php

namespace Inmanturbo\Signal;

use Closure;

interface Middleware
{
    public function handle(object $command, Closure $next): mixed;
}
