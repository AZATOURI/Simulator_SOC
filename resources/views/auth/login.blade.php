<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agadir SOC - Login</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

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
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
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
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(56, 189, 248, 0.18);
            box-shadow: 0 12px 30px rgba(0,0,0,0.28);
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
            margin-top: 4px;
            color: #cbd5e1;
            font-size: 13px;
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
            width: 100px;
            height: 4px;
            margin: 0 auto 14px;
            border-radius: 999px;
            background: linear-gradient(90deg, transparent, #38bdf8, transparent);
            animation: pulseBar 2s linear infinite;
        }

        @keyframes pulseBar {
            0% { opacity: 0.35; transform: scaleX(0.85); }
            50% { opacity: 1; transform: scaleX(1.1); }
            100% { opacity: 0.35; transform: scaleX(0.85); }
        }

        .card h2 {
            text-align: center;
            margin: 0 0 6px;
            font-size: 24px;
            color: #f8fafc;
        }

        .top-text {
            text-align: center;
            color: #94a3b8;
            margin-bottom: 18px;
            font-size: 14px;
        }

        label {
            display: block;
            color: #e2e8f0;
            font-weight: 700;
            margin-bottom: 6px;
            font-size: 14px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 11px 12px;
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.18);
            background: rgba(2, 6, 23, 0.72);
            color: #f8fafc;
            outline: none;
            font-size: 15px;
            margin-bottom: 12px;
        }

        input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.14);
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 4px 0 14px;
            color: #cbd5e1;
            font-size: 14px;
        }

        .remember-row input {
            accent-color: #38bdf8;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 8px;
        }

        .link {
            color: #93c5fd;
            font-size: 14px;
            text-decoration: none;
        }

        .link:hover {
            text-decoration: underline;
        }

        .btn {
            padding: 12px 18px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #0ea5e9, #2563eb);
            color: white;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.28);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .error-box {
            margin-top: -6px;
            margin-bottom: 10px;
            padding: 9px 11px;
            border-radius: 10px;
            background: rgba(220, 38, 38, 0.12);
            border: 1px solid rgba(220, 38, 38, 0.28);
            color: #fecaca;
            font-size: 13px;
        }

        .success-box {
            margin-bottom: 14px;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(22, 163, 74, 0.12);
            border: 1px solid rgba(22, 163, 74, 0.28);
            color: #bbf7d0;
            font-size: 14px;
        }

        .register-box {
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(8, 15, 28, 0.72);
            border: 1px solid rgba(56, 189, 248, 0.16);
            margin-bottom: 14px;
            color: #cbd5e1;
            font-size: 14px;
            line-height: 1.5;
        }

        .footer-note {
            text-align: center;
            margin-top: 14px;
            color: #94a3b8;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="grid-overlay"></div>

    <div class="wrapper">
        <div class="brand-box">
            <div class="logo-wrap">
                <svg width="45" height="45" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="g1" x1="8" y1="8" x2="56" y2="56" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#38BDF8"/>
                            <stop offset="1" stop-color="#2563EB"/>
                        </linearGradient>
                    </defs>

                    <path d="M12 18C18 10 28 8 36 10C45 12 52 18 54 28C56 37 53 47 44 52C36 57 25 56 17 50"
                          stroke="url(#g1)" stroke-width="4" stroke-linecap="round"/>

                    <path d="M18 24C22 19 29 17 35 19C41 21 46 26 47 33C48 39 45 45 39 49"
                          stroke="url(#g1)" stroke-width="3.5" stroke-linecap="round" opacity="0.9"/>

                    <circle cx="15" cy="47" r="4.5" fill="#38BDF8"/>
                    <circle cx="39" cy="49" r="3.5" fill="#60A5FA"/>
                    <circle cx="54" cy="28" r="3" fill="#38BDF8"/>

                    <path d="M15 47L24 38L32 41L39 49" stroke="#7DD3FC" stroke-width="2.5" stroke-linecap="round"/>

                </svg>
            </div>

            <h1 class="brand-title">Agadir <span>SOC</span></h1>
            <div class="brand-subtitle">Cyber Security Operations Center Simulator</div>
        </div>

        <div class="card">
            <div class="pulse-line"></div>

            <h2>Secure Login</h2>
            <p class="top-text">Access your SOC dashboard and continue investigations.</p>

            <div class="register-box">
                New analyst or admin?
                <a class="link" href="{{ route('choose-role') }}">Choose role and create an account</a>.
            </div>

            @if (session('status'))
                <div class="success-box">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="error-box">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <div class="error-box">{{ $message }}</div>
                    @enderror
                </div>

                <label class="remember-row">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>

                <div class="actions">
                    @if (Route::has('password.request'))
                        <a class="link" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @else
                        <span></span>
                    @endif

                    <button type="submit" class="btn">
                        Log in
                    </button>
                </div>
            </form>

            <div class="footer-note">
                Agadir SOC • Secure Authentication Gateway
            </div>
        </div>
    </div>

</body>
</html>
