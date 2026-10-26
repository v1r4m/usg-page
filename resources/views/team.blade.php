<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $team['name'] }} · {{ $team['name_en'] }}</title>
<meta name="description" content="{{ $team['name'] }} ({{ $team['name_en'] }}) — CTF team from Korea.">
<meta property="og:title" content="{{ $team['name'] }} · {{ $team['name_en'] }}">
<meta property="og:image" content="{{ asset('images/main.webp') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tinos:wght@400;700&family=Noto+Serif+KR:wght@400;500&family=Noto+Serif+JP:wght@700&display=swap" rel="stylesheet">
<style>
  :root {
    --bg: #ffffff;
    --fg: #222222;
    --muted: #a8a8a8;
    --accent: #555555;
    --ink: #1f3550;
    --rule: #ececec;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  html { color-scheme: light dark; }

  body {
    font-family: "Times New Roman", "Tinos", "Noto Serif KR", serif;
    background: var(--bg);
    color: var(--fg);
    line-height: 1.45;
    -webkit-font-smoothing: antialiased;
  }

  main {
    max-width: 460px;
    margin: 0 auto;
    padding: 3.5rem 1.6rem;
  }

  header { margin-bottom: 1.3rem; }

  .hero {
    display: block;
    width: 100%;
    height: auto;
    border-radius: 2px;
    margin-bottom: 1.6rem;
  }

  h1 {
    font-family: "Noto Serif JP", "Noto Serif KR", serif;
    font-size: 1.7rem;
    font-weight: 700;
    letter-spacing: 0.04em;
  }

  h1 .dot { color: var(--ink); }

  .sub {
    font-size: 0.78rem;
    color: var(--muted);
    margin-top: 0.2rem;
  }

  .links {
    font-size: 0.78rem;
    margin-top: 0.7rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0 0.6rem;
  }

  .links a { color: var(--fg); text-decoration: none; }
  .links a:hover { color: var(--accent); }
  .links .sep { color: var(--muted); }

  /* label : content rows */
  section { display: flex; gap: 0.9rem; margin-bottom: 1rem; }

  section .label {
    flex: 0 0 3.2rem;
    font-size: 0.72rem;
    color: var(--accent);
    padding-top: 0.18rem;
    text-align: right;
  }

  section .body { flex: 1; min-width: 0; font-size: 0.82rem; }

  section .body p + p { margin-top: 0.1rem; }

  section .body .when { color: var(--muted); }

  section .body a { color: var(--fg); text-decoration: none; border-bottom: 1px dotted var(--muted); }
  section .body a:hover { color: var(--accent); border-bottom-color: var(--accent); }

  .num { font-variant-numeric: tabular-nums; }

  /* results: place · event · rating */
  .rows .row {
    display: flex;
    gap: 0.6rem;
    padding: 0.05rem 0;
  }
  .rows .row .place { flex: 0 0 2.2rem; color: var(--muted); }
  .rows .row .event { flex: 1; min-width: 0; }
  .rows .row .date { color: var(--muted); font-size: 0.76rem; padding-top: 0.05rem; white-space: nowrap; }
  .rows .row.best .place { color: var(--ink); }

  .rows .total {
    display: flex;
    justify-content: space-between;
    margin-top: 0.3rem;
    padding-top: 0.3rem;
    border-top: 1px solid var(--rule);
    color: var(--muted);
    font-size: 0.76rem;
  }

  .members a.handle { border: 0; }

  footer {
    margin-top: 2.5rem;
    font-size: 0.68rem;
    color: var(--muted);
    text-align: center;
  }

  @media (prefers-color-scheme: dark) {
    :root {
      --bg: #161616;
      --fg: #e6e6e6;
      --muted: #6f6f6f;
      --accent: #a0a0a0;
      --ink: #8fb0d6;
      --rule: #2a2a2a;
    }
    .hero { filter: brightness(0.82) contrast(1.05); }
  }
</style>
</head>
<body>
<main>

  <header>
    <img class="hero" src="{{ asset('images/main.webp') }}" alt="{{ $team['name'] }} — {{ $team['name_ko'] }}, {{ $team['name_en'] }}" width="1024" height="559">
    <h1>{{ $team['name'] }}<span class="dot">.</span></h1>
    <div class="sub">{{ $team['name_ko'] }} · {{ $team['name_en'] }}</div>
    <div class="sub">aka {{ $team['aka'] }}</div>
  </header>

  <section>
    <div class="label">team</div>
    <div class="body">
      <p>{{ $team['since'] }}–now</p>
    </div>
  </section>

  <section>
    <div class="label">rank</div>
    <div class="body num">
      <p><span class="when">{{ $rating['year'] }}</span> #{{ number_format($rating['rating_place']) }} overall · #{{ $rating['country_place'] }} in KR</p>
      <p><span class="when">rating</span> {{ number_format($rating['rating_points'], 3) }} pts · <a href="{{ $team['links']['ctftime'] }}">ctftime</a></p>
    </div>
  </section>

  <section>
    <div class="label">crew</div>
    <div class="body members">
      @foreach ($leads->concat($crew) as $member)
        <p>
          @isset($member['url'])
            <a class="handle" href="{{ $member['url'] }}">{{ $member['handle'] }}</a>
          @else
            {{ $member['handle'] }}
          @endisset
          @if ($member['lead'] ?? false)
            <span class="when">lead</span>
          @endif
        </p>
      @endforeach
    </div>
  </section>

  <section>
    <div class="label">ctf</div>
    <div class="body rows num">
      @foreach ($results as $result)
        <div class="row {{ $result['place'] === $best ? 'best' : '' }}">
          <span class="place">#{{ $result['place'] }}</span>
          <span class="event">{{ $result['event'] }}</span>
          <span class="date">{{ \Illuminate\Support\Carbon::parse($result['date'])->format('Y.m.d') }}</span>
        </div>
      @endforeach
      <div class="total">
        <span>{{ $results->count() }} events · best #{{ $best }}</span>
      </div>
    </div>
  </section>

  <section>
    <div class="label">contact</div>
    <div class="body">
      <p>discord {{ '@'.$team['discord'] }}</p>
    </div>
  </section>

  <footer>last updated {{ $team['updated'] }}</footer>

</main>
</body>
</html>
