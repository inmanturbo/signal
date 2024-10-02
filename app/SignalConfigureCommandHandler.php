<?php

namespace Inmanturbo\Signal;

class SignalConfigureCommandHandler implements HandlesConfigure
{
    protected function handlers(): array
    {
        return [
            EnsureEventSourcingConfigIsPublished::class,
            ReplaceInFiles::class,
        ];
    }

    public function __invoke(): void
    {
        foreach ($this->handlers() as $action) {
            app($action)();
        }
    }
}
