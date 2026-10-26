<?php

return [

    'ctftime_id' => 436124,

    'name' => '最強海巨',
    'name_en' => 'Ultimate Sea Giant',
    'name_ko' => '최강해거',
    'country' => 'KR',
    'since' => '2026.5',

    'links' => [
        'ctftime' => 'https://ctftime.org/team/436124',
    ],
    'discord' => 'eunjinko',

    'aka' => 'rubiyalab usg',

    // 리드 먼저, v1r4m이 맨 위
    'members' => [
        ['handle' => 'v1r4m', 'lead' => true, 'url' => 'https://ctftime.org/user/224117'],
        ['handle' => 'cooku222', 'lead' => true, 'url' => 'https://ctftime.org/user/245086'],
        ['handle' => 'joy'],
        ['handle' => 'esol'],
        ['handle' => 'miiz'],
        ['handle' => 'goldenfall'],
        ['handle' => 'daya'],
        ['handle' => 'sun20ny'],
        ['handle' => '안효빈'],
        ['handle' => 'suyeongg092'],
        ['handle' => 'haochi'],
    ],

    // CTFtime API를 못 쓸 때 보여줄 값
    'rating_fallback' => [
        'year' => 2026,
        'rating_place' => 750,
        'rating_points' => 103.988,
        'country_place' => 42,
    ],

    // 최신순, date = CTFtime 대회 시작일
    'results' => [
        ['date' => '2026-08-01', 'place' => 206, 'event' => 'Lexington Informatics Tournament CTF 2026', 'points' => 2543, 'rating' => 51.872],
        ['date' => '2026-07-20', 'place' => 110, 'event' => 'BDSec CTF 2026', 'points' => 1085, 'rating' => 3.775],
        ['date' => '2026-07-06', 'place' => 94, 'event' => 'LYKNCTF', 'points' => 2647, 'rating' => 6.773],
        ['date' => '2026-06-17', 'place' => 14, 'event' => 'Sieberrsec CTF 7.0', 'points' => 7678, 'rating' => 16.356],
        ['date' => '2026-05-19', 'place' => 36, 'event' => 'Hack for a Change 2026 May: UN SDG 1', 'points' => 3950, 'rating' => 25.211],
    ],

    'updated' => '2026-10-26',

];
