<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>إضافة طالب</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            /* 🎨 خلفية احترافية جديدة */
            background: radial-gradient(circle at top left, #0f3d2e, transparent 40%),
                radial-gradient(circle at bottom right, #198754, transparent 40%),
                linear-gradient(135deg, #0b1f17, #f4f7f6);

            position: relative;
            overflow: hidden;
        }

        /* glowing blobs */
        body::before,
        body::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
        }

        body::before {
            width: 400px;
            height: 400px;
            background: rgba(25, 135, 84, 0.35);
            top: -100px;
            left: -120px;
        }

        body::after {
            width: 450px;
            height: 450px;
            background: rgba(13, 110, 253, 0.25);
            bottom: -150px;
            right: -150px;
        }

        /* BOX */
        .box {
            position: relative;
            z-index: 1;

            width: 400px;
            padding: 40px;

            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(18px);

            border-radius: 25px;

            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.25),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);

            animation: pop .5s ease;
        }

        /* TITLE */
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #0f3d2e;
            font-weight: 900;
            font-size: 28px;
            letter-spacing: 1px;
        }

        /* INPUT */
        input {
            width: 100%;
            padding: 14px 15px;
            margin-bottom: 15px;

            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;

            outline: none;
            font-size: 14px;

            transition: .3s;

            background: rgba(255, 255, 255, 0.7);
        }

        input:focus {
            border-color: #198754;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.15);
            transform: translateY(-2px);
        }

        /* BUTTON */
        button {
            width: 100%;
            padding: 14px;

            border: none;
            border-radius: 14px;

            background: linear-gradient(135deg, #198754, #0f3d2e);
            color: #fff;

            font-weight: 900;
            font-size: 15px;

            cursor: pointer;
            transition: .3s;

            box-shadow: 0 10px 25px rgba(25, 135, 84, 0.25);
        }

        button:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(25, 135, 84, 0.35);
        }

        /* animation */
        @keyframes pop {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>

</head>

<body>

    <div class="box">

        <h2>➕ إضافة طالب</h2>

        <form method="POST" action="{{ route('student.store') }}">

            @csrf

            <input type="text" name="name" placeholder="اسم الطالب" required>

            <input type="text" name="phone_number" placeholder="رقم الهاتف">

            <button type="submit">💾 حفظ الطالب</button>

        </form>

    </div>

</body>

</html>