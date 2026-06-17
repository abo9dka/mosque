<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>تسجيل الدخول</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(-45deg, #0d3b2e, #14532d, #1e6b46, #123524);
            background-size: 400% 400%;
            animation: bg 12s ease infinite;
        }

        @keyframes bg {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* CARD */
        .card {
            width: 420px;
            padding: 40px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
            animation: show .7s ease;
        }

        @keyframes show {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* LOGO */
        .logo {
            font-size: 50px;
            text-align: center;
            margin-bottom: 10px;
        }

        h2 {
            text-align: center;
            color: white;
            font-weight: 800;
        }

        .subtitle {
            text-align: center;
            color: #d8e6df;
            margin-bottom: 25px;
        }

        /* INPUT */
        .input-group {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #1e6b46;
        }

        input {
            width: 100%;
            padding: 14px 45px 14px 15px;
            border: none;
            outline: none;
            border-radius: 12px;
            font-size: 15px;
            transition: .2s;
        }

        input:focus {
            transform: scale(1.02);
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.4);
        }

        /* BUTTON */
        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            background: linear-gradient(135deg, #d4af37, #ffd700);
            transition: .3s;
        }

        button:hover {
            transform: translateY(-3px);
        }

        /* ERROR */
        .error {
            background: #ffe5e5;
            color: #c00;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>

</head>

<body>

    <div class="card">

        <div class="logo">🕌</div>

        <h2>تسجيل الدخول</h2>

        <div class="subtitle">نظام إدارة حلقات المسجد</div>

        @if($errors->any())
        <div class="error">
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

            <button>دخول</button>

        </form>

    </div>

</body>

</html>