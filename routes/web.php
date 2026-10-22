<?php

use App\Services\CtfTime;
use Illuminate\Support\Facades\Route;

Route::get('/', function (CtfTime $ctftime) {
    $results = collect(config('team.results'));
    [$leads, $crew] = collect(config('team.members'))->partition(fn ($member) => $member['lead'] ?? false);

    return view('team', [
        'team' => config('team'),
        'rating' => $ctftime->rating(),
        'results' => $results,
        'best' => $results->min('place'),
        'leads' => $leads,
        'crew' => $crew,
    ]);
});
