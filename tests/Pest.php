<?php

use Inmanturbo\Signal\Tests\TestCase;

uses(TestCase::class)
    ->beforeEach(function (): void {
        $this->artisan('signal:migrate')->assertExitCode(0);
    })
    ->in(__DIR__);
