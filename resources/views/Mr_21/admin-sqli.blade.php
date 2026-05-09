<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agadir SOC - Admin SQLi Challenge</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- !! -->

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            color: #e5e7eb;
            background:
                linear-gradient(rgba(2, 6, 23, 0.84), rgba(2, 6, 23, 0.92)),
                url('{{ asset('images/background.jpg') }}') center center / cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px);
            background-size: 34px 34px;
            opacity: .16;
        }

        .wrapper {
            width: 100%;
            max-width: 900px;
            position: relative;
            z-index: 2;
        }

        .card {
            background: rgba(15, 23, 42, .86);
            border: 1px solid rgba(56, 189, 248, .18);
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 25px 70px rgba(0,0,0,.35);
            backdrop-filter: blur(10px);
        }

        .brand {
            font-size: 30px;
            font-weight: 800;
            color: #f8fafc;
            margin-bottom: 6px;
        }

        .brand span { color: #38bdf8; }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 20px;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 18px;
        }

        .terminal {
            background: #020617;
            border: 1px solid rgba(148, 163, 184, .18);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 18px;
        }

        .terminal-header {
            background: rgba(30, 41, 59, .95);
            padding: 12px 14px;
            color: #94a3b8;
        }

        pre {
            margin: 0;
            padding: 18px;
            color: #93c5fd;
            white-space: pre-wrap;
            line-height: 1.6;
            font-size: 14px;
        }

        .panel {
            background: rgba(8, 15, 28, .72);
            border: 1px solid rgba(148, 163, 184, .14);
            border-radius: 16px;
            padding: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #cbd5e1;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, .20);
            background: rgba(2, 6, 23, .85);
            color: #f8fafc;
            font-size: 15px;
            outline: none;
            margin-bottom: 14px;
        }

        input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, .12);
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .hint {
            background: rgba(30, 41, 59, .55);
            border-left: 4px solid #38bdf8;
            padding: 12px 14px;
            border-radius: 12px;
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 14px;
        }

        .query-box {
            margin-top: 14px;
            padding: 14px;
            border-radius: 12px;
            background: rgba(2, 6, 23, .85);
            border: 1px solid rgba(148, 163, 184, .16);
            color: #fde68a;
            font-family: monospace;
            font-size: 13px;
            line-height: 1.5;
        }

        .success {
            margin-top: 14px;
            padding: 14px;
            border-radius: 12px;
            background: rgba(22, 163, 74, .14);
            border: 1px solid rgba(22, 163, 74, .35);
            color: #bbf7d0;
            line-height: 1.6;
        }

        .error {
            margin-top: 14px;
            padding: 14px;
            border-radius: 12px;
            background: rgba(220, 38, 38, .14);
            border: 1px solid rgba(220, 38, 38, .35);
            color: #fecaca;
        }

        .code {
            display: inline-block;
            margin-top: 8px;
            padding: 8px 12px;
            border-radius: 10px;
            background: rgba(2, 6, 23, .9);
            color: #7dd3fc;
            font-family: monospace;
            font-weight: bold;
        }

        @media(max-width: 850px) {
            .main-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="grid"></div>

<div class="wrapper">
    <div class="card">
        <div class="brand">Agadir <span>SOC</span> Admin Gateway</div>
        <div class="subtitle">SQL Injection training lab — safe simulation</div>

        <div class="main-grid">
            <div>
                <div class="terminal">
                    <div class="terminal-header">admin-gateway.log</div>
                    <pre>
[BOOT] Restricted admin gateway initialized
[INFO] Legacy authentication module detected
[WARN] Query concatenation pattern found
[OBJECTIVE] Bypass the simulated login form
[GOAL] Recover the admin registration code
[NOTE] No real database query is executed.
                    </pre>
                </div>

                <div class="terminal">
                    <div class="terminal-header">analyst-hint.txt</div>
                    <pre>
Hint 1: The condition must become TRUE.
Hint 2: A classic payload often uses OR.
Hint 3: Comments can ignore the rest of the query.
                    </pre>
                </div>

                @if($simulatedQuery)
                    <div class="query-box">
                        <strong>Simulated SQL Query:</strong><br>
                        {{ $simulatedQuery }}
                    </div>
                @endif
            </div>

            <div class="panel">
                <h2>Admin Login Simulation</h2>

                <div class="hint">
                    Try to bypass this simulated form using a SQL injection payload.
                    The result will reveal the admin code used in the real choose-role page.
                </div>

                <form method="POST" action="{{ route('admin.challenge') }}">
                    @csrf

                    <label>Username</label>
                    <input
                        type="text"
                        name="username"
                        value="{{ old('username', $username) }}"
                        placeholder="admin"
                        autocomplete="off"
                    >

                    <label>Password</label>
                    <input
                        type="text"
                        name="password"
                        value="{{ old('password', $password) }}"
                        placeholder="password"
                        autocomplete="off"
                    >

                    <button type="submit">Execute Login Query</button>
                </form>

                @if($success)
                    <div class="success">
                        ✅ SQL condition bypassed successfully.
                        <br>
                        Admin registration code recovered:
                        <br>
                        <span class="code">{{ $adminCode }}</span>
                        <br><br>
                        Go to <strong>/choose-role</strong>, select <strong>SOC Admin</strong>, and use this code.
                    </div>
                @endif

                @if($error)
                    <div class="error">
                        ❌ {{ $error }}
                    </div>
                @endif

                <div style="margin-top:14px; color:#fcd34d; font-size:13px;">
                    This page is only a CTF simulation and does not execute real SQL queries.
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
