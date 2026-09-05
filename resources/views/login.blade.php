<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>تسجيل الدخول</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 380px;
            padding: 36px 32px;
            border-radius: var(--radius-lg);
            background: var(--surface);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .logo-mark {
            width: 56px;
            height: 56px;
            border-radius: var(--radius);
            background: var(--accent-soft);
            color: var(--accent-strong);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 18px;
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

    <div class="card">

        <div class="logo-mark"><i class="fa-solid fa-mosque"></i></div>

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

</body>

</html>
