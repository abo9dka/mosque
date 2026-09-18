<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>تسجيل الدخول</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-256.png') }}">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
            background:
                radial-gradient(circle at 18% 15%, rgba(188, 171, 123, .10) 0%, transparent 45%),
                radial-gradient(circle at 85% 90%, rgba(188, 171, 123, .08) 0%, transparent 40%),
                linear-gradient(160deg, #1c3c34 0%, var(--accent-strong) 55%, #0d211c 100%);
        }

        .login-wrap {
            width: 100%;
            max-width: 380px;
        }

        .brand {
            text-align: center;
            margin-bottom: 22px;
        }

        .brand img {
            width: 148px;
            max-width: 60%;
            height: auto;
        }

        .card {
            width: 100%;
            padding: 36px 32px;
            border-radius: var(--radius-lg);
            background: var(--surface);
            border: 1px solid var(--border);
            box-shadow: 0 20px 45px rgba(0, 0, 0, .25);
        }

        h2 {
            text-align: center;
            color: var(--ink);
            font-weight: 800;
            font-size: var(--text-xl);
            margin: 0 0 6px;
        }

        .subtitle {
            text-align: center;
            color: var(--ink-muted);
            font-size: var(--text-sm);
            margin-bottom: 26px;
        }

        .input-group {
            position: relative;
            margin-bottom: 14px;
        }

        .input-group i {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink-faint);
            font-size: 14px;
        }

        .input-group input {
            padding-right: 40px;
        }

        button[type="submit"] {
            width: 100%;
            margin-top: 8px;
        }
    </style>

</head>

<body>

    <div class="login-wrap">

        <div class="brand">
            <img src="{{ asset('images/logo-full.png') }}" alt="معهد اقرأ وارتقِ لحفظ القرآن الكريم وتعليمه">
        </div>

        <div class="card">

            <h2>تسجيل الدخول</h2>

            <div class="subtitle">نظام إدارة حلقات المسجد</div>

            @if($errors->any())
            <div class="error-box">
                @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ url('/login') }}" autocomplete="off">

                @csrf

                <div class="input-group">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text"
                        name="phone"
                        placeholder="رقم الهاتف"
                        autocomplete="off"
                        inputmode="numeric"
                        required>
                </div>

                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password"
                        name="password"
                        placeholder="كلمة المرور"
                        autocomplete="new-password"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">دخول</button>

            </form>

        </div>

    </div>

</body>

</html>
