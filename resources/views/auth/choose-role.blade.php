<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agadir SOC</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            color: #f8fafc;
            background:
                linear-gradient(rgba(6, 11, 20, 0.82), rgba(6, 11, 20, 0.88)),
                url('{{ asset('images/background.jpg') }}') center center / cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 16px;
            position: relative;
            overflow: hidden;
        }

        .grid-overlay {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.18;
            pointer-events: none;
        }

        .wrapper {
            width: 100%;
            max-width: 470px;
            position: relative;
            z-index: 2;
        }

        .brand-box {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo-wrap {
            width: 70px;
            height: 70px;
            margin: 0 auto 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 22px;
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(56, 189, 248, 0.18);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.28);
            backdrop-filter: blur(6px);
        }

        .brand-title {
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .brand-title span {
            color: #38bdf8;
        }

        .brand-subtitle {
            margin-top: 6px;
            color: #cbd5e1;
            font-size: 14px;
        }

        .card {
            background: rgba(15, 23, 42, 0.78);
            border: 1px solid rgba(148, 163, 184, 0.15);
            border-radius: 18px;
            padding: 22px;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(10px);
        }

        .pulse-line {
            width: 110px;
            height: 4px;
            margin: 0 auto 18px;
            border-radius: 999px;
            background: linear-gradient(90deg, transparent, #38bdf8, transparent);
            animation: pulseBar 2s linear infinite;
        }

        @keyframes pulseBar {
            0% {
                opacity: 0.35;
                transform: scaleX(0.85);
            }

            50% {
                opacity: 1;
                transform: scaleX(1.1);
            }

            100% {
                opacity: 0.35;
                transform: scaleX(0.85);
            }
        }

        .card h2 {
            text-align: center;
            margin: 0 0 8px;
            font-size: 24px;
            color: #f8fafc;
        }

        .top-text {
            text-align: center;
            color: #94a3b8;
            margin-bottom: 16px;
            font-size: 15px;
        }

        .role-option {
            display: block;
            border: 1px solid rgba(148, 163, 184, 0.16);
            background: rgba(8, 15, 28, 0.72);
            border-radius: 18px;
            padding: 12px 14px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .role-option:hover {
            border-color: rgba(56, 189, 248, 0.45);
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.18);
        }

        .role-option input {
            margin-right: 10px;
            transform: scale(1.15);
            accent-color: #38bdf8;
        }

        .role-title {
            font-size: 17px;
            font-weight: 700;
            color: #f8fafc;
        }

        .role-desc {
            margin-top: 6px;
            color: #94a3b8;
            font-size: 13px;
            line-height: 1.55;
        }

        .section-label {
            display: block;
            margin-top: 16px;
            margin-bottom: 8px;
            color: #e2e8f0;
            font-weight: 700;
        }

        input[type="password"] {
            width: 100%;
            padding: 11px 12px;
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: rgba(2, 6, 23, 0.72);
            color: #f8fafc;
            outline: none;
            font-size: 15px;
        }

        input[type="password"]:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.14);
        }

        .hint-box {
            margin-top: 12px;
            padding: 9px 12px;
            border-radius: 12px;
            background: rgba(30, 41, 59, 0.55);
            border-left: 4px solid #38bdf8;
            color: #cbd5e1;
            font-size: 12px;
            line-height: 1.5;
        }

        .btn {
            width: 100%;
            margin-top: 14px;
            padding: 12px;
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: white;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.28);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .error-box {
            margin-top: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(220, 38, 38, 0.12);
            border: 1px solid rgba(220, 38, 38, 0.28);
            color: #fecaca;
            font-size: 14px;
        }

        .footer-note {
            text-align: center;
            margin-top: 16px;
            color: #94a3b8;
            font-size: 13px;
        }
    </style>
</head>

<!--
<script>
    const signal = "U09De0NPTlNPTEVfU0lHTkFMX0RFVEVDVEVEfQ==";
    console.log("SOC Hint");
</script>
-->

<body>

    <div class="grid-overlay"></div>

    <div class="wrapper">
        <div class="brand-box">
            <div class="logo-wrap">
                <!-- Simple custom logo -->
                <svg width="45" height="45" viewBox="0 0 64 64" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="g1" x1="8" y1="8" x2="56" y2="56"
                            gradientUnits="userSpaceOnUse">
                            <stop stop-color="#38BDF8" />
                            <stop offset="1" stop-color="#2563EB" />
                        </linearGradient>
                    </defs>

                    <path d="M12 18C18 10 28 8 36 10C45 12 52 18 54 28C56 37 53 47 44 52C36 57 25 56 17 50"
                        stroke="url(#g1)" stroke-width="4" stroke-linecap="round" />

                    <path d="M18 24C22 19 29 17 35 19C41 21 46 26 47 33C48 39 45 45 39 49" stroke="url(#g1)"
                        stroke-width="3.5" stroke-linecap="round" opacity="0.9" />

                    <circle cx="15" cy="47" r="4.5" fill="#38BDF8" />
                    <circle cx="39" cy="49" r="3.5" fill="#60A5FA" />
                    <circle cx="54" cy="28" r="3" fill="#38BDF8" />

                    <path d="M15 47L24 38L32 41L39 49" stroke="#7DD3FC" stroke-width="2.5" stroke-linecap="round" />
                </svg>
            </div>

            <h1 class="brand-title">Agadir <span>SOC</span></h1>
            <div class="brand-subtitle">Cyber Security Operations Center Simulator</div>
        </div>

        <div class="card">
            <div class="pulse-line"></div>

            <h2>Choose SOC Role</h2>
            <p class="top-text">Select your role before creating an account.</p>

            <form method="POST" action="{{ route('choose-role.store') }}">
                @csrf

                <label class="role-option">
                    <input type="radio" name="role" value="analyste" checked>
                    <span class="role-title">SOC Analyste</span>
                    <div class="role-desc">
                        Can investigate alerts, update incident status, add notes, send reports, and view audit history.
                    </div>
                </label>

                <label class="role-option">
                    <input type="radio" name="role" value="admin">
                    <span class="role-title">SOC Admin</span>
                    <div class="role-desc">
                        Can create, edit, delete alerts, manage the simulator, and supervise the full SOC workflow.
                    </div>
                </label>

                @error('role')
                    <div class="error-box">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn">
                    Continue to Register
                </button>
            </form>

            <div class="footer-note">
                Agadir SOC • Secure Access Gateway
            </div>
        </div>
    </div>

</body>

</html>
