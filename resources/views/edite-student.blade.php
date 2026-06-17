<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>تعديل الطالب</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f4f7f6, #eef5f1);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* CARD */
        .card {
            width: 420px;
            background: white;
            padding: 25px;
            border-radius: 22px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
            animation: fade .4s ease-in-out;
        }

        @keyframes fade {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            color: #198754;
            font-weight: 900;
            margin-bottom: 20px;
        }

        /* INPUTS */
        label {
            font-weight: 700;
            color: #0f3d2e;
            display: block;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #ddd;
            outline: none;
            margin-bottom: 15px;
            transition: .3s;
        }

        input:focus {
            border-color: #198754;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, .1);
        }

        /* BUTTON */
        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #198754, #0f3d2e);
            color: white;
            font-weight: 800;
            cursor: pointer;
            transition: .3s;
        }

        button:hover {
            transform: translateY(-3px);
        }

        /* BACK */
        .back {
            display: block;
            text-align: center;
            margin-top: 12px;
            color: #666;
            text-decoration: none;
            font-weight: 700;
        }

        .back:hover {
            color: #198754;
        }

        .avatar {
            width: 70px;
            height: 70px;
            background: #198754;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin: 0 auto 15px;
        }
    </style>

</head>

<body>

    <div class="card">

        <div class="avatar">👦</div>

        <h2>تعديل بيانات الطالب</h2>

        <form method="POST" action="{{ route('student.update', $student->id) }}">

            @csrf
            @method('PUT')

            <label>اسم الطالب</label>
            <input type="text" name="name" value="{{ $student->name }}" required>

            <label>رقم الهاتف</label>
            <input type="text" name="phone_number" value="{{ $student->phone_number }}">

            <button type="submit">💾 حفظ التعديلات</button>

        </form>

        <a href="{{ route('dashboard') }}" class="back">⬅ الرجوع للوحة التحكم</a>

    </div>

</body>

</html>