<?php

namespace Inmanturbo\Signal;

use Inmanturbo\Signal\Actions\HandleConfigure;
use Inmanturbo\Signal\Actions\InvokeHandleConfigure;

class SignalConfigureCommandHandler
{
    protected function handlers():array
    {
        return [
            new EnsureEventSourcingConfigIsPublished,
            new ReplaceInFiles,
        ];
    }

    public function __invoke(): void
    {
        app(InvokeHandleConfigure::class)(new HandleConfigure(...$this->handlers()));
    }
}
