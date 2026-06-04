<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('ops:bootstrap', function () {
    $databasePath = database_path('database.sqlite');

    if (config('database.default') === 'sqlite' && ! File::exists($databasePath)) {
        File::ensureDirectoryExists(dirname($databasePath));
        File::put($databasePath, '');

        $this->info("Created SQLite database at {$databasePath}");
    }

    $this->call('migrate', ['--force' => true]);
    $this->call('db:seed', ['--force' => true]);
    $this->call('optimize:clear');

    $this->info('Passionation Ops is bootstrapped.');
})->purpose('Prepare the production admin database and seeded admin account');
