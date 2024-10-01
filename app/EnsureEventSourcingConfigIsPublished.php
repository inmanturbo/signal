<?php

namespace Inmanturbo\Signal;

use Illuminate\Support\Facades\Artisan;

class EnsureEventSourcingConfigIsPublished implements HandlesConfigure
{
    public function __invoke(): void
    {
        Artisan::call('vendor:publish',[
            '--tag' => 'event-sourcing-config',
        ]);
    }
}
