<?php

namespace Inmanturbo\Signal\Commands;

use Illuminate\Console\Command;

class SignalCommand extends Command
{
    public $signature = 'signal';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
