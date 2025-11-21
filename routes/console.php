<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule stale match cleanup
Schedule::command('matches:release-stale')
    ->everyThirtyMinutes()
    ->withoutOverlapping()
    ->onOneServer();
