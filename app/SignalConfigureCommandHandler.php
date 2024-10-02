<?php

namespace Inmanturbo\Signal;

class SignalConfigureCommandHandler implements HandlesConfigure
{
    protected array $actions = [
        EnsureEventSourcingConfigIsPublished::class,
        ReplaceInFiles::class,
    ];

    public function __invoke(): void
    {
        foreach ($this->actions as $action) {
            app($action)();
        }
    }
}
