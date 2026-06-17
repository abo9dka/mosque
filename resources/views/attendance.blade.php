<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>تسجيل الحضور</title>

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
            padding: 30px;
        }

        /* TITLE */
        h2 {
            text-align: center;
            color: #198754;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: 800;
        }

        /* FORM */
        form {
            max-width: 850px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, .08);
        }

        /* STUDENT CARD */
        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 12px;
            background: #f8f9fa;
            transition: .3s;
        }

        .row:hover {
            transform: translateY(-3px);
            background: #eef5f1;
        }

        .name {
            font-weight: 800;
            color: #0f3d2e;
            font-size: 18px;
        }

        /* BUTTON GROUP */
        .actions {
            display: flex;
            gap: 10px;
        }

        input[type="radio"] {
            display: none;
        }

        /* BUTTON STYLE */
        .label {
            padding: 8px 14px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            transition: .3s;
            border: 2px solid transparent;
        }

        /* STATES */
        .present {
            background: #e8f5e9;
            color: #198754;
        }

        .absent {
            background: #fdecea;
            color: #dc3545;
        }

        .late {
            background: #fff3cd;
            color: #d39e00;
        }

        /* ACTIVE EFFECT */
        input:checked+.label {
            transform: scale(1.05);
            border: 2px solid #333;
        }

        /* SUBMIT */
        button {
            width: 100%;
            margin-top: 20px;
            padding: 14px;
            border: none;
            border-radius: 15px;
            background: linear-gradient(135deg, #198754, #0f3d2e);
            color: white;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            transition: .3s;
        }

        button:hover {
            transform: translateY(-3px);
        }
    </style>

</head>

<body>

    <h2>📅 تسجيل حضور الطلاب</h2>

    <form method="POST" action="{{ route('attendance.store') }}">

        @csrf

        @foreach($students as $student)

        <div class="row">

            <div class="name">
                {{ $student->name }}
            </div>

            <div class="actions">

                <!-- حاضر -->
                <input type="radio" name="attendance[{{ $student->id }}]" value="حاضر" id="p{{ $student->id }}">
                <label class="label present" for="p{{ $student->id }}">حاضر</label>

                <!-- غائب -->
                <input type="radio" name="attendance[{{ $student->id }}]" value="غائب" id="a{{ $student->id }}">
                <label class="label absent" for="a{{ $student->id }}">غائب</label>

                <!-- متأخر -->
                <input type="radio" name="attendance[{{ $student->id }}]" value="متأخر" id="l{{ $student->id }}">
                <label class="label late" for="l{{ $student->id }}">متأخر</label>

            </div>

        </div>

        @endforeach

        <button type="submit">
            💾 حفظ الحضور
        </button>

    </form>

</body>

</html>