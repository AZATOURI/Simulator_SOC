@extends('ctf.layout')

@section('content')
<div class="page">
    <div class="topbar glass">
        <div>
            <div class="brand">{{ $challenge['title'] }}</div>
            <div class="muted">{{ $challenge['category'] }} — {{ $challenge['level'] }} — {{ $challenge['points'] }} pts</div>
        </div>

        <a class="btn btn-dark" href="{{ route('ctf.index') }}">Back to Dashboard</a>
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

    @if($isSolved)
        <div class="alert success">This challenge is already solved.</div>
    @endif

    <div class="glass" style="padding:22px; margin-bottom:20px;">
        <span class="badge {{ strtolower($challenge['level']) }}">{{ $challenge['level'] }}</span>
        <span class="badge locked">{{ $challenge['category'] }}</span>
        <span class="badge locked">{{ $challenge['points'] }} pts</span>

        <p style="margin-top:18px;">{{ $challenge['short'] }}</p>
    </div>

    @if($slug === 'source-recon')
        <div class="terminal">
            <div class="terminal-title">source-recon.txt</div>
            <pre>
A SOC analyst should inspect what the browser receives.

Visible fake flag:
SOC{THIS_IS_NOT_THE_FLAG}

Goal:
Find the real flag in the page source.
            </pre>
        </div>

        <!-- SOC{SOURCE_RECON_FOUND} -->
    @endif

    @if($slug === 'console-signal')
        <div class="terminal">
            <div class="terminal-title">console-signal.log</div>
            <pre>
A suspicious signal was detected.

Visible fake flag:
SOC{AI_FOUND_FAKE_FLAG}

Goal:
Open DevTools Console and decode the Base64 signal.
            </pre>
        </div>

        @push('scripts')
        <script>
            const socSignal = "U09De0NPTlNPTEVfU0lHTkFMfQ==";
            console.log("Agadir SOC signal detected:");
            console.log(socSignal);
            console.log("Hint: decode this Base64 signal.");
        </script>
        @endpush
    @endif

    @if($slug === 'forgotten-soc-file')
        <div class="terminal">
            <div class="terminal-title">forgotten-file.recon</div>
            <pre>
Some SOC notes are forgotten in public endpoints.

Goal:
Find the training note.

Hint:
Try this endpoint:
/ctf/soc-note

This challenge gives Fragment A.
            </pre>
        </div>
    @endif

    @if($slug === 'blue-team-header')
        <div class="terminal">
            <div class="terminal-title">blue-team-header.http</div>
            <pre>
The page content looks normal.

Visible fake flag:
SOC{VISIBLE_FAKE_HEADER}

Goal:
Inspect the HTTP response headers.
Look for X-SOC-Signal.
            </pre>
        </div>
    @endif

    @if($slug === 'internal-threat-vault')
        <div class="terminal">
            <div class="terminal-title">vault.sha256</div>
            <pre>
Internal vault contains hashes.

Real hash:
5b97d6721cb10fb0d9fb46d603c17cbe3a1105dddc8e4d097c2e520ccb6646f9

Fake hash:
71e517bfa47d6318fd8c12fbc315edb484c6150a2209b3d9d575d2e08b012d28

Goal:
Find the original flag from the correct SHA-256 hash.

This challenge gives Fragment B.
            </pre>
        </div>
    @endif

    @if($slug === 'suspicious-login-log')
        <div class="terminal">
            <div class="terminal-title">auth.log</div>
            <pre>
[10:21] failed login user=guest ip=192.168.1.10
[10:22] failed login user=admin ip=192.168.1.45
[10:23] failed login user=admin ip=192.168.1.45
[10:24] failed login user=admin ip=192.168.1.45
[10:25] success login user=admin ip=192.168.1.45

Goal:
Find the suspicious user and IP.

Flag format:
SOC{username_ip}

This challenge gives Fragment C.
            </pre>
        </div>
    @endif

    @if($slug === 'analyst-trap')
        <div class="terminal">
            <div class="terminal-title">analyst-trap.txt</div>
            <pre>
Not every visible flag is valid.

Fake flags:
SOC{FAKE_FLAG}
SOC{AI_TRAP}
SOC{NOT_REAL}

Goal:
Find the verified signal.
            </pre>
        </div>

        <div data-verified-signal="SOC{VERIFY_BEFORE_SUBMIT}" style="display:none;"></div>
    @endif

    @if($slug === 'admin-gateway')
        <div class="terminal">
            <div class="terminal-title">admin-gateway.sql</div>
            <pre>
Legacy admin gateway detected.

This is a safe SQL Injection simulation.
No real SQL query is executed.

Try to make the condition TRUE.
Example idea:
admin' OR '1'='1
            </pre>
        </div>

        <div class="glass" style="padding:18px; margin-bottom:20px;">
            <h2>Admin Login Simulation</h2>

            <form method="POST" action="{{ route('ctf.lab.admin') }}">
                @csrf
                <input type="text" name="username" placeholder="username">
                <br><br>
                <input type="text" name="password" placeholder="password">
                <br><br>
                <button type="submit">Execute Simulated Query</button>
            </form>
        </div>
    @endif

    @if($slug === 'binary-beacon')
        <div class="terminal">
            <div class="terminal-title">binary-beacon.log</div>
            <pre>
A binary beacon was found in SOC logs.

Fake decoded text:
SOC{BINARY_FAKE_DECODE}

Binary:
01010011 01001111 01000011 01111011 01000010 01001001 01001110 01000001 01010010 01011001 01011111 01000010 01000101 01000001 01000011 01001111 01001110 01011111 01000100 01000101 01000011 01001111 01000100 01000101 01000100 01111101

Goal:
Decode the binary string.
            </pre>
        </div>
    @endif

    @if($slug === 'operation-agadir-shield')
        <div class="terminal">
            <div class="terminal-title">final-operation.chain</div>
            <pre>
Final mission requires fragments:

Fragment A = {{ $fragments['A'] ?? 'LOCKED' }}
Fragment B = {{ $fragments['B'] ?? 'LOCKED' }}
Fragment C = {{ $fragments['C'] ?? 'LOCKED' }}

Goal:
Build the final flag from A + B + C.

Format:
SOC{A_B_C}
            </pre>
        </div>
    @endif

    <div class="submit-panel glass">
        <h2>Submit Flag</h2>

        <form method="POST" action="{{ route('ctf.submit', $slug) }}">
            @csrf
            <div class="submit-row">
                <input type="text" name="flag" placeholder="SOC{...}" autocomplete="off">
                <button type="submit">Validate</button>
            </div>
        </form>
    </div>
</div>
@endsection
