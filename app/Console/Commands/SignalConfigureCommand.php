<?php

namespace Inmanturbo\Signal\Console\Commands;

use Illuminate\Console\Command;
use Inmanturbo\Signal\SignalConfigureCommandHandler;

class SignalConfigureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signal:configure';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(SignalConfigureCommandHandler::class)();
    }
}
