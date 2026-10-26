<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_team_page_shows_live_rating(): void
    {
        Http::fake([
            'ctftime.org/*' => Http::response([
                'rating' => ['2026' => ['rating_place' => 500, 'rating_points' => 150.12345, 'country_place' => 30]],
            ]),
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('最強海巨')
            ->assertSee('#500 overall')
            ->assertSee('150.123 pts')
            ->assertSee('Sieberrsec CTF 7.0')
            ->assertSee('2026.06.17')
            ->assertSee('aka rubiyalab usg')
            ->assertSeeInOrder(['v1r4m', 'cooku222', 'joy', 'suyeongg092', 'haochi']);
    }

    public function test_team_page_falls_back_when_ctftime_is_down(): void
    {
        Http::fake(['ctftime.org/*' => Http::response('Forbidden', 403)]);

        $this->get('/')
            ->assertOk()
            ->assertSee('#750 overall')
            ->assertSee('103.988 pts');
    }
}
