<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('pokemon-tcg:sync-series')
    ->monthly()
    ->sundays()
    ->at('03:00')
    ->withoutOverlapping();

Schedule::command('pokemon-tcg:sync-sets')
    ->monthly()
    ->sundays()
    ->at('03:15')
    ->withoutOverlapping();

Schedule::command('pokemon-tcg:sync-cards')
    ->monthly()
    ->sundays()
    ->at('03:30')
    ->withoutOverlapping();