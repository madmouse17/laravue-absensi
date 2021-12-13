<?php

use App\Models\Attendance;
use App\Models\Employe;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('att_date', function () {
    $em = Employe::get();
    foreach ($em as  $value) {
        Attendance::create([
            'employe_id' => $value->id,
            'attended_at' => Carbon::now()->format('Y-m-d'),
        ]);
    }
})->purpose('Insert date in Attendance');
