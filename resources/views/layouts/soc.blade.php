<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agadir SOC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(56, 189, 248, .12), transparent 30%),
                radial-gradient(circle at bottom right, rgba(37, 99, 235, .10), transparent 30%),
                linear-gradient(135deg, #07111f 0%, #0a1426 45%, #0b1320 100%);
            color: #e5e7eb;
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 250px;
            background: rgba(8, 15, 28, .96);
            border-right: 1px solid rgba(148, 163, 184, .12);
            padding: 24px 18px;
        }

        .brand {
            font-size: 28px;
            font-weight: bold;
            color: #f8fafc;
            margin-bottom: 6px;
        }

        .brand span {
            color: #38bdf8;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 12px;
            margin-bottom: 28px;
        }

        .nav-title {
            color: #64748b;
            font-size: 12px;
            margin: 22px 0 10px;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .nav-link {
            display: block;
            padding: 12px 14px;
            margin-bottom: 10px;
            border-radius: 12px;
            background: rgba(15, 23, 42, .8);
            color: #cbd5e1;
            transition: all .25s ease;
            border: 1px solid transparent;
        }

        .nav-link:hover {
            transform: translateX(4px);
            border-color: rgba(56, 189, 248, .35);
            background: rgba(30, 41, 59, .95);
        }

        .main {
            margin-left: 250px;
            padding: 0;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: rgba(9, 18, 34, .95);
            border-bottom: 1px solid rgba(148, 163, 184, .12);
            backdrop-filter: blur(12px);
        }

        .status-line {
            display: flex;
            align-items: center;
            gap: 18px;
            color: #e2e8f0;
            font-size: 14px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            background: #22c55e;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 1.5s infinite;
            box-shadow: 0 0 0 rgba(34,197,94,.5);
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34,197,94,.55); }
            70% { transform: scale(1.2); box-shadow: 0 0 0 12px rgba(34,197,94,0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34,197,94,0); }
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .incident-pill {
            background: rgba(245, 158, 11, .14);
            color: #fcd34d;
            border: 1px solid rgba(245, 158, 11, .2);
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: bold;
        }

        .user-badge {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .user-info {
            color: #f8fafc;
            font-size: 14px;
        }

        .role {
            color: #93c5fd;
            font-size: 12px;
        }

        .content {
            padding: 24px;
        }

        h1 {
            margin: 0 0 10px;
            color: #f8fafc;
        }

        .muted {
            color: #94a3b8;
            margin-bottom: 20px;
        }

        .card {
            background: rgba(15, 23, 42, .88);
            border: 1px solid rgba(148, 163, 184, .12);
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 18px 45px rgba(0,0,0,.18);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 20px;
        }

        .stat-title {
            color: #94a3b8;
            font-size: 13px;
            margin-bottom: 12px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .stat-number {
            color: #f8fafc;
            font-size: 38px;
            font-weight: bold;
        }

        .small-trend {
            font-size: 14px;
            margin-top: 8px;
        }

        .positive { color: #4ade80; }
        .negative { color: #f87171; }

        .btn {
            border: 0;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            color: white;
            display: inline-block;
        }

        .btn-primary { background: #2563eb; }
        .btn-success { background: #16a34a; }
        .btn-warning { background: #d97706; }
        .btn-danger { background: #dc2626; }
        .btn-dark { background: #334155; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 14px 12px;
            color: #cbd5e1;
            background: rgba(30, 41, 59, .85);
            font-size: 13px;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid rgba(148, 163, 184, .10);
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .low { background: rgba(34,197,94,.14); color: #86efac; }
        .medium { background: rgba(234,179,8,.14); color: #fde68a; }
        .high { background: rgba(249,115,22,.14); color: #fdba74; }
        .critical { background: rgba(239,68,68,.16); color: #fca5a5; }
        .status-badge { background: rgba(59,130,246,.14); color: #93c5fd; }

        .success {
            background: rgba(22,163,74,.12);
            border: 1px solid rgba(22,163,74,.3);
            color: #bbf7d0;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 16px;
        }

        .error-box {
            background: rgba(220,38,38,.12);
            border: 1px solid rgba(220,38,38,.28);
            color: #fecaca;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 16px;
        }

        input, textarea, select {
            width: 100%;
            padding: 11px;
            border-radius: 10px;
            border: 1px solid rgba(148,163,184,.2);
            background: rgba(8, 15, 28, .7);
            color: #f8fafc;
            margin-top: 8px;
            margin-bottom: 14px;
        }

        textarea { min-height: 100px; }

        .form-inline {
            display: inline;
        }

        .mini-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .feed-item {
            padding: 10px 0;
            border-bottom: 1px solid rgba(148,163,184,.08);
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .feed-item:last-child {
            border-bottom: none;
        }

        .scroll-feed {
            max-height: 280px;
            overflow: auto;
        }

        .check-item {
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(30, 41, 59, .45);
            margin-bottom: 10px;
        }

        .user-panel {
            position: absolute;
            bottom: 24px;
            left: 18px;
            right: 18px;
            background: rgba(15, 23, 42, .95);
            border: 1px solid rgba(148, 163, 184, .12);
            border-radius: 14px;
            padding: 12px;
        }

        @media (max-width: 1000px) {
            .sidebar { position: relative; width: 100%; }
            .main { margin-left: 0; }
            .grid { grid-template-columns: repeat(2, 1fr); }
            .mini-grid { grid-template-columns: 1fr; }
            .topbar { flex-direction: column; align-items: flex-start; gap: 12px; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="brand">Agadir <span>SOC</span></div>
    <div class="subtitle">Cyber Security Operations Center Simulator</div>

    <div class="nav-title">Dashboard</div>
    <a class="nav-link" href="{{ route('dashboard') }}">Overview</a>

    <div class="nav-title">Incidents</div>
    <a class="nav-link" href="{{ route('alerts.index') }}">Alerts Center</a>
    <a class="nav-link" href="{{ route('alerts.history') }}">Audit History</a>

    <div class="nav-title">Session</div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-dark" style="width:100%;">Logout</button>
    </form>

    <div class="user-panel">
        <div style="font-weight:bold;">{{ auth()->user()->name }}</div>
        <div class="role">{{ auth()->user()->role }}</div>
    </div>
</div>

<div class="main">
    <div class="topbar">
        <div class="status-line">
            <span><span class="status-dot"></span> Systems Operational</span>
            <span>📅 <span id="live-date">Loading...</span></span>
        </div>

        <div class="header-right">
            <div class="incident-pill">
                ⚠ {{ \App\Models\Alert::whereIn('status', ['New', 'In Progress'])->count() }} Active Incidents
            </div>

            <div class="user-badge">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="user-info">
                <div>{{ auth()->user()->name }}</div>
                <div class="role">{{ auth()->user()->role }}</div>
            </div>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="error-box">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script>
    function updateLiveDate() {
        const now = new Date();
        const options = {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('live-date').textContent = now.toLocaleString('en-US', options);
    }

    updateLiveDate();
    setInterval(updateLiveDate, 1000);
</script>

</body>
</html>
