<?php

namespace Inmanturbo\Signal\Actions;

class InvokeHandleConfigure
{
    public function __invoke(HandleConfigure $action): void
    {
        foreach ($action->handlers as $handler) {
            app(get_class($handler))();
        }
    }
}
