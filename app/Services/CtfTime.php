<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

class CtfTime
{
    /**
     * 올해 팀 순위. CTFtime API를 6시간 캐시하고, 실패하면 config 값을 쓴다.
     *
     * @return array{year: int, rating_place: ?int, rating_points: ?float, country_place: ?int, live: bool}
     */
    public function rating(): array
    {
        $fallback = config('team.rating_fallback') + ['live' => false];

        $team = Cache::remember('ctftime.team', now()->addHours(6), function () {
            try {
                $response = Http::withUserAgent('usg-page (+https://ctftime.org/team/'.config('team.ctftime_id').')')
                    ->timeout(5)
                    ->get('https://ctftime.org/api/v1/teams/'.config('team.ctftime_id').'/');

                return $response->successful() ? $response->json() : null;
            } catch (Throwable) {
                return null;
            }
        });

        $year = (string) $fallback['year'];
        $live = $team['rating'][$year] ?? null;

        if (! isset($live['rating_place'])) {
            Cache::forget('ctftime.team');

            return $fallback;
        }

        return [
            'year' => (int) $year,
            'rating_place' => $live['rating_place'],
            'rating_points' => round($live['rating_points'], 3),
            'country_place' => $live['country_place'] ?? null,
            'live' => true,
        ];
    }
}
