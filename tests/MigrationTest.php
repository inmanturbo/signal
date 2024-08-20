<?php

use Illuminate\Support\Facades\Schema;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

it('can create the stored_events table', function () {
    $this->artisan('signal:migrate')->assertExitCode(0);

    assertDatabaseHas('migrations', ['migration' => '2024_06_26_194318_create_stored_events_table']);

    assertTrue(Schema::hasTable('stored_events'));
});

it('can run migrations with --fresh option', function () {
    $this->artisan('signal:migrate')->assertExitCode(0);
    $this->artisan('signal:migrate --fresh')->assertExitCode(0);

    assertDatabaseHas('migrations', ['migration' => '2024_06_26_194318_create_stored_events_table']);

    assertTrue(Schema::hasTable('stored_events'));
});

it('can run migrations with --wipe option', function () {
    $this->artisan('signal:migrate')->assertExitCode(0);
    $this->artisan('signal:migrate --wipe')->assertExitCode(0);

    assertDatabaseMissing('migrations', ['migration' => '2024_06_26_194318_create_stored_events_table']);

    assertFalse(Schema::hasTable('stored_events'));
});

it('can run migrations with --log-only option', function () {
    $this->artisan('signal:migrate')->assertExitCode(0);
    $this->artisan('signal:migrate --wipe')->assertExitCode(0);
    $this->artisan('signal:migrate --log-only')->assertExitCode(0);

    assertDatabaseHas('migrations', ['migration' => '2024_06_26_194318_create_stored_events_table']);

    assertFalse(Schema::hasTable('stored_events'));
});
