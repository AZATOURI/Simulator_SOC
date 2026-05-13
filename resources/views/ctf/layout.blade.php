<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agadir SOC CTF Lab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            color: #e5e7eb;
            background:
                linear-gradient(rgba(2, 6, 23, .88), rgba(2, 6, 23, .94)),
                url('{{ asset('images/background.jpg') }}') center center / cover no-repeat;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(56,189,248,.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56,189,248,.06) 1px, transparent 1px);
            background-size: 34px 34px;
            animation: gridMove 18s linear infinite;
            pointer-events: none;
            opacity: .4;
        }

        @keyframes gridMove {
            from { transform: translateY(0); }
            to { transform: translateY(34px); }
        }

        .orb {
            position: fixed;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            filter: blur(30px);
            opacity: .18;
            background: #38bdf8;
            animation: floatOrb 8s ease-in-out infinite;
            pointer-events: none;
        }

        .orb.one { top: 8%; left: 6%; }
        .orb.two { bottom: 8%; right: 7%; background:#2563eb; animation-delay:2s; }

        @keyframes floatOrb {
            0%,100% { transform: translate(0,0); }
            50% { transform: translate(20px,-20px); }
        }

        .page {
            position: relative;
            z-index: 2;
            width: min(1180px, 94%);
            margin: auto;
            padding: 28px 0;
        }

        .glass {
            background: rgba(15, 23, 42, .82);
            border: 1px solid rgba(56,189,248,.18);
            box-shadow: 0 24px 70px rgba(0,0,0,.35);
            border-radius: 22px;
            backdrop-filter: blur(10px);
        }

        .brand {
            font-size: 34px;
            font-weight: 900;
            letter-spacing: 1px;
            color: #f8fafc;
        }

        .brand span { color: #38bdf8; }

        .muted { color: #94a3b8; }

        .topbar {
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:16px;
            padding: 22px;
            margin-bottom: 20px;
        }

        .status {
            display:inline-block;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(34,197,94,.13);
            color: #86efac;
            border: 1px solid rgba(34,197,94,.25);
            font-weight: bold;
            font-size: 13px;
        }

        .stats {
            display:grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            padding: 18px;
            transition:.25s ease;
        }

        .stat-card:hover, .challenge-card:hover {
            transform: translateY(-4px);
            border-color: rgba(56,189,248,.45);
        }

        .stat-title {
            color:#94a3b8;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 900;
            color:#f8fafc;
        }

        .submit-panel {
            padding: 20px;
            margin-bottom: 20px;
        }

        .submit-row {
            display:grid;
            grid-template-columns: 1fr 180px;
            gap: 12px;
        }

        input, button {
            border: 0;
            outline: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 15px;
        }

        input {
            background: rgba(2, 6, 23, .88);
            color: #f8fafc;
            border: 1px solid rgba(148,163,184,.18);
        }

        input:focus {
            border-color:#38bdf8;
            box-shadow: 0 0 0 3px rgba(56,189,248,.12);
        }

        button, .btn {
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color:white;
            font-weight:800;
            cursor:pointer;
            text-decoration:none;
            display:inline-block;
            text-align:center;
            transition:.2s ease;
        }

        button:hover, .btn:hover { transform: translateY(-2px); }

        .btn-dark {
            background: #334155;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }

        .alert {
            padding: 13px 14px;
            border-radius: 12px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .alert.success {
            background: rgba(22,163,74,.14);
            border:1px solid rgba(22,163,74,.3);
            color:#bbf7d0;
        }

        .alert.error {
            background: rgba(220,38,38,.14);
            border:1px solid rgba(220,38,38,.3);
            color:#fecaca;
        }

        .alert.fake {
            background: rgba(245,158,11,.14);
            border:1px solid rgba(245,158,11,.3);
            color:#fde68a;
        }

        .categories {
            display:flex;
            flex-wrap:wrap;
            gap:10px;
            margin: 14px 0 20px;
        }

        .category {
            padding:8px 12px;
            border-radius:999px;
            background:rgba(30,41,59,.75);
            border:1px solid rgba(148,163,184,.14);
            color:#cbd5e1;
            font-weight:bold;
            font-size:13px;
        }

        .challenge-grid {
            display:grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .challenge-card {
            padding: 18px;
            transition:.25s ease;
        }

        .challenge-head {
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:12px;
        }

        .challenge-title {
            font-size: 20px;
            font-weight: 900;
            color:#f8fafc;
            margin-bottom: 8px;
        }

        .badge {
            display:inline-block;
            padding:5px 9px;
            border-radius:999px;
            font-size:12px;
            font-weight:900;
            margin-right:5px;
        }

        .easy { background: rgba(34,197,94,.14); color:#86efac; }
        .medium { background: rgba(234,179,8,.14); color:#fde68a; }
        .hard { background: rgba(249,115,22,.14); color:#fdba74; }
        .expert { background: rgba(239,68,68,.16); color:#fca5a5; }
        .solved { background: rgba(34,197,94,.16); color:#bbf7d0; }
        .locked { background: rgba(148,163,184,.14); color:#cbd5e1; }

        .fragment-box {
            padding: 18px;
            margin-bottom: 20px;
        }

        .fragment-grid {
            display:grid;
            grid-template-columns: repeat(4, 1fr);
            gap:12px;
            margin-top: 12px;
        }

        .fragment {
            padding: 14px;
            background:rgba(2,6,23,.66);
            border:1px solid rgba(148,163,184,.13);
            border-radius:14px;
        }

        .terminal {
            background:#020617;
            border:1px solid rgba(148,163,184,.16);
            border-radius:16px;
            overflow:hidden;
            margin: 18px 0;
        }

        .terminal-title {
            background:rgba(30,41,59,.95);
            padding:11px 14px;
            color:#94a3b8;
            font-weight:700;
        }

        pre {
            margin:0;
            padding:18px;
            white-space:pre-wrap;
            line-height:1.6;
            color:#93c5fd;
        }

        .nickname-screen {
            min-height: 100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
        }

        .nickname-card {
            width:min(520px, 94%);
            padding: 28px;
            text-align:center;
        }

        .logo {
            width:78px;
            height:78px;
            margin:0 auto 16px;
            border-radius:22px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:rgba(15,23,42,.75);
            border:1px solid rgba(56,189,248,.25);
        }

        .progress-wrap {
            height: 10px;
            background: rgba(2,6,23,.8);
            border-radius: 999px;
            overflow: hidden;
            border:1px solid rgba(148,163,184,.12);
            margin-top:10px;
        }

        .progress-bar {
            height:100%;
            background: linear-gradient(90deg,#0ea5e9,#22c55e);
            animation: glow 2s infinite;
        }

        @keyframes glow {
            0%,100% { filter: brightness(1); }
            50% { filter: brightness(1.4); }
        }

        @media(max-width: 900px) {
            .stats, .fragment-grid, .challenge-grid {
                grid-template-columns:1fr;
            }

            .submit-row {
                grid-template-columns:1fr;
            }

            .topbar {
                flex-direction:column;
                align-items:flex-start;
            }
        }
    </style>

    @stack('head')
</head>
<body>
<div class="orb one"></div>
<div class="orb two"></div>

@yield('content')

@stack('scripts')
</body>
</html>
