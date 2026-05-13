@extends('ctf.layout')

@section('content')
@if($nicknameMode)
    <div class="nickname-screen">
        <div class="nickname-card glass">
            <div class="logo">
                <svg width="48" height="48" viewBox="0 0 64 64" fill="none">
                    <path d="M12 18C18 10 28 8 36 10C45 12 52 18 54 28C56 37 53 47 44 52C36 57 25 56 17 50"
                          stroke="#38BDF8" stroke-width="4" stroke-linecap="round"/>
                    <circle cx="15" cy="47" r="4.5" fill="#38BDF8"/>
                    <circle cx="39" cy="49" r="3.5" fill="#60A5FA"/>
                    <path d="M15 47L24 38L32 41L39 49" stroke="#7DD3FC" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </div>

            <div class="brand">Agadir <span>SOC</span> CTF Lab</div>
            <p class="muted">Blue Team Training Environment</p>

            <p>
                Enter your analyst nickname to start the training.
            </p>

            <form method="POST" action="{{ route('ctf.start') }}">
                @csrf
                <input type="text" name="nickname" placeholder="Analyst nickname" autocomplete="off">
                @error('nickname')
                    <div class="alert error">{{ $message }}</div>
                @enderror
                <br><br>
                <button type="submit" style="width:100%;">Enter the Lab</button>
            </form>
        </div>
    </div>
@else
    <div class="page">
        <div class="topbar glass">
            <div>
                <div class="brand">Agadir <span>SOC</span> CTF Lab</div>
                <div class="muted">Welcome {{ $nickname }} — Blue Team Training Environment</div>
            </div>

            <div>
                <span class="status">● LIVE</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        @if(session('fake'))
            <div class="alert fake">{{ session('fake') }}</div>
        @endif

        <div class="stats">
            <div class="stat-card glass">
                <div class="stat-title">Total Challenges</div>
                <div class="stat-number">{{ $totalChallenges }}</div>
            </div>

            <div class="stat-card glass">
                <div class="stat-title">Solved</div>
                <div class="stat-number">{{ $solvedCount }}</div>
            </div>

            <div class="stat-card glass">
                <div class="stat-title">Points</div>
                <div class="stat-number">{{ $score }}</div>
            </div>

            <div class="stat-card glass">
                <div class="stat-title">Final Mission</div>
                <div class="stat-number" style="font-size:22px;">
                    {{ $finalUnlocked ? 'Unlocked' : 'Locked' }}
                </div>
            </div>
        </div>

        <div class="submit-panel glass">
            <h2>Submit a Flag</h2>

            <form method="POST" action="{{ route('ctf.submit.global') }}">
                @csrf
                <div class="submit-row">
                    <input type="text" name="flag" placeholder="SOC{...}" autocomplete="off">
                    <button type="submit">Validate</button>
                </div>
            </form>

            <div class="progress-wrap">
                <div class="progress-bar" style="width: {{ $totalChallenges > 0 ? ($solvedCount / $totalChallenges) * 100 : 0 }}%;"></div>
            </div>

            <p class="muted">{{ $solvedCount }} / {{ $totalChallenges }} solved — {{ $score }} / {{ $totalPoints }} pts</p>
        </div>

        <div class="categories">
            <span class="category">Web</span>
            <span class="category">Crypto</span>
            <span class="category">OSINT</span>
            <span class="category">Binary</span>
            <span class="category">Mixed</span>
        </div>

        <div class="fragment-box glass">
            <h2>Fragment Chain</h2>
            <p class="muted">Collect fragments A, B and C to unlock the final operation.</p>

            <div class="fragment-grid">
                <div class="fragment">
                    <strong>Fragment A</strong><br>
                    {{ isset($fragments['A']) ? 'Collected: '.$fragments['A'] : 'Locked' }}
                </div>

                <div class="fragment">
                    <strong>Fragment B</strong><br>
                    {{ isset($fragments['B']) ? 'Collected: '.$fragments['B'] : 'Locked' }}
                </div>

                <div class="fragment">
                    <strong>Fragment C</strong><br>
                    {{ isset($fragments['C']) ? 'Collected: '.$fragments['C'] : 'Locked' }}
                </div>

                <div class="fragment">
                    <strong>Final Operation</strong><br>
                    {{ $finalUnlocked ? 'Unlocked' : 'Locked' }}
                </div>
            </div>
        </div>

        <div class="challenge-grid">
            @foreach($challenges as $slug => $challenge)
                @php
                    $isSolved = in_array($slug, $solved, true);
                    $isLocked = $slug === 'operation-agadir-shield' && ! $finalUnlocked;
                    $levelClass = strtolower($challenge['level']);
                @endphp

                <div class="challenge-card glass">
                    <div class="challenge-head">
                        <div>
                            <div class="challenge-title">{{ $challenge['title'] }}</div>
                            <span class="badge {{ $levelClass }}">{{ $challenge['level'] }}</span>
                            <span class="badge locked">{{ $challenge['category'] }}</span>
                            <span class="badge locked">{{ $challenge['points'] }} pts</span>
                        </div>

                        @if($isSolved)
                            <span class="badge solved">Solved</span>
                        @elseif($isLocked)
                            <span class="badge locked">Locked</span>
                        @else
                            <span class="badge medium">Unlocked</span>
                        @endif
                    </div>

                    <p class="muted">{{ $challenge['short'] }}</p>

                    @if($isLocked)
                        <span class="btn btn-dark">Locked</span>
                    @else
                        <a class="btn" href="{{ route('ctf.challenge', $slug) }}">Open Challenge</a>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="glass" style="padding:18px; display:flex; justify-content:space-between; align-items:center; gap:12px;">
            <div>
                <strong>Player Summary</strong><br>
                <span class="muted">{{ $nickname }} — {{ $score }} pts — {{ $solvedCount }} solves</span>
            </div>

            <form method="POST" action="{{ route('ctf.reset') }}">
                @csrf
                <button class="btn-danger" type="submit">Reset CTF</button>
            </form>
        </div>
    </div>
@endif
@endsection
