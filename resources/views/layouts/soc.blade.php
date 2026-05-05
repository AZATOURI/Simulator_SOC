<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enterprise SOC Simulator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(59,130,246,.18), transparent 35%),
                linear-gradient(135deg, #020617 0%, #0f172a 45%, #111827 100%);
            color: #e5e7eb;
            min-height: 100vh;
        }
        a { color: inherit; text-decoration: none; }
        .sidebar {
            position: fixed;
            left: 0; top: 0; bottom: 0;
            width: 260px;
            background: rgba(2, 6, 23, .92);
            border-right: 1px solid rgba(148, 163, 184, .18);
            padding: 24px;
        }
        .brand {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #f8fafc;
        }
        .brand span { color: #38bdf8; }
        .subtitle {
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 30px;
        }
        .nav-link {
            display: block;
            padding: 12px 14px;
            margin-bottom: 8px;
            border-radius: 12px;
            color: #cbd5e1;
            background: rgba(15, 23, 42, .65);
            border: 1px solid transparent;
        }
        .nav-link:hover {
            border-color: rgba(56, 189, 248, .35);
            background: rgba(30, 41, 59, .85);
        }
        .user-box {
            position: absolute;
            bottom: 24px;
            left: 24px;
            right: 24px;
            background: rgba(15, 23, 42, .95);
            border: 1px solid rgba(148, 163, 184, .16);
            padding: 14px;
            border-radius: 14px;
        }
        .role {
            display: inline-block;
            margin-top: 6px;
            padding: 4px 8px;
            background: rgba(56, 189, 248, .12);
            color: #7dd3fc;
            border-radius: 999px;
            font-size: 12px;
        }
        .main {
            margin-left: 260px;
            padding: 28px;
        }
        .topbar {
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom: 24px;
        }
        h1 { margin: 0 0 10px; color: #f8fafc; }
        .muted { color: #94a3b8; }
        .card {
            background: rgba(15, 23, 42, .86);
            border: 1px solid rgba(148, 163, 184, .16);
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .25);
            margin-bottom: 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }
        .stat h3 {
            font-size: 13px;
            color: #94a3b8;
            margin: 0 0 10px;
        }
        .stat .number {
            font-size: 34px;
            font-weight: bold;
            color: #f8fafc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 14px;
        }
        th {
            background: rgba(30, 41, 59, .95);
            color: #cbd5e1;
            padding: 13px;
            font-size: 13px;
            text-align: left;
        }
        td {
            padding: 13px;
            border-bottom: 1px solid rgba(148, 163, 184, .12);
            color: #e5e7eb;
            vertical-align: top;
        }
        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }
        .low { background: rgba(34,197,94,.16); color:#86efac; }
        .medium { background: rgba(234,179,8,.16); color:#fde68a; }
        .high { background: rgba(249,115,22,.16); color:#fdba74; }
        .critical { background: rgba(239,68,68,.18); color:#fca5a5; }
        .status { background: rgba(59,130,246,.14); color:#93c5fd; }
        .btn {
            display:inline-block;
            border:0;
            padding: 9px 12px;
            border-radius: 10px;
            cursor:pointer;
            font-weight:bold;
            margin: 2px;
        }
        .btn-primary { background:#2563eb; color:white; }
        .btn-danger { background:#dc2626; color:white; }
        .btn-warning { background:#d97706; color:white; }
        .btn-success { background:#16a34a; color:white; }
        .btn-dark { background:#334155; color:white; }
        input, textarea, select {
            width: 100%;
            padding: 11px;
            border-radius: 10px;
            border: 1px solid rgba(148, 163, 184, .25);
            background: rgba(2, 6, 23, .65);
            color: #f8fafc;
            margin: 8px 0 14px;
        }
        label { color:#cbd5e1; font-size: 14px; }
        .success {
            background: rgba(22, 163, 74, .14);
            border: 1px solid rgba(22, 163, 74, .35);
            color: #bbf7d0;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 16px;
        }
        .error-box {
            background: rgba(220, 38, 38, .12);
            border: 1px solid rgba(220, 38, 38, .35);
            color: #fecaca;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 16px;
        }
        .form-inline { display:inline; }
        @media(max-width: 900px) {
            .sidebar { position: relative; width: 100%; }
            .main { margin-left: 0; }
            .grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="brand">Enterprise <span>SOC</span></div>
    <div class="subtitle">Security Operations Center Simulator</div>

    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
    <a class="nav-link" href="{{ route('alerts.index') }}">Alerts Center</a>
    <a class="nav-link" href="{{ route('alerts.history') }}">Audit History</a>

    <form method="POST" action="{{ route('logout') }}" style="margin-top:14px;">
        @csrf
        <button class="btn btn-dark" style="width:100%;">Logout</button>
    </form>

    <div class="user-box">
        <strong>{{ auth()->user()->name }}</strong><br>
        <span class="role">{{ auth()->user()->role }}</span>
    </div>
</div>

<div class="main">
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error-box">{{ session('error') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>
