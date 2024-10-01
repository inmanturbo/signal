<?php

namespace Inmanturbo\Signal\Actions;

use Inmanturbo\Signal\HandlesConfigure;

class HandleConfigure
{
    /**
     * @var array<int|string, \Inmanturbo\Signal\HandlesConfigure>
     */
    public $handlers;

    public function __construct(
        HandlesConfigure ...$handlers,
    ) {
        $this->handlers = $handlers;
    }
}
