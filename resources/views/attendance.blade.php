<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>تسجيل الحضور</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #0b3a2a, #146c43);
            --primary-color: #146c43;
            --primary-dark: #0b3a2a;
            --bg-gradient: linear-gradient(135deg, #f4f7f5, #e8efe9);
            --text-main: #1e2922;
            --radius-lg: 20px;
            --radius-md: 12px;
            --shadow-sm: 0 4px 6px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 10px 25px rgba(20, 108, 67, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            padding: 30px 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 800;
            color: var(--primary-dark);
        }

        form {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
        }

        .row {
            background: #fff;
            padding: 14px;
            border-radius: var(--radius-md);
            margin-bottom: 12px;
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .name {
            font-weight: bold;
            font-size: 16px;
        }

        .actions {
            display: flex;
            gap: 6px;
        }

        input[type="radio"] {
            display: none;
        }

        .label {
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
        }

        .present { background: #dcfce7; color: #16a34a; }
        .absent { background: #fee2e2; color: #dc2626; }
        .late { background: #fef3c7; color: #d97706; }

        input[value="حاضر"]:checked + .present {
            background: #16a34a;
            color: white;
        }

        input[value="غائب"]:checked + .absent {
            background: #dc2626;
            color: white;
        }

        input[value="متأخر"]:checked + .late {
            background: #d97706;
            color: white;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: var(--primary-gradient);
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        /* MOBILE */
        @media (max-width: 550px) {
            .row {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .actions {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
            }

            .label {
                text-align: center;
                width: 100%;
                padding: 10px 0;
            }
        }
        .top-bar {
            max-width: 800px;
            margin: 0 auto 10px;
            display: flex;
            justify-content: flex-start; /* RTL → right side */
        }

        .back-btn {
            background: white;
            padding: 8px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--primary-dark);
            font-weight: 700;
            box-shadow: var(--shadow-sm);
            transition: all 0.25s ease;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
    </style>


</head>

<body>
<div class="top-bar">
    <a href="{{ url()->previous() }}" class="back-btn">
        ← رجوع
    </a>
</div>
<h2>📅 تسجيل حضور الطلاب</h2>

<form method="POST" action="{{ route('attendance.store') }}">
    @csrf


    <div id="studentsGrid">
        @foreach($students as $student)

            @php
                $status = $attendanceLogs[$student->id]->status ?? null;
            @endphp

            <div class="row">
                <div class="name">{{ $student->name }}</div>

                <div class="actions">

                    <input type="radio"
                           name="attendance[{{ $student->id }}]"
                           value="حاضر"
                           id="p{{ $student->id }}"
                        {{ $status == 'حاضر' ? 'checked' : '' }}>
                    <label class="label present" for="p{{ $student->id }}">حاضر</label>

                    <input type="radio"
                           name="attendance[{{ $student->id }}]"
                           value="غائب"
                           id="a{{ $student->id }}"
                        {{ $status == 'غائب' ? 'checked' : '' }}>
                    <label class="label absent" for="a{{ $student->id }}">غائب</label>

                    <input type="radio"
                           name="attendance[{{ $student->id }}]"
                           value="متأخر"
                           id="l{{ $student->id }}"
                        {{ $status == 'متأخر' ? 'checked' : '' }}>
                    <label class="label late" for="l{{ $student->id }}">متأخر</label>

                </div>
            </div>

        @endforeach
    </div>

    <button type="submit">
        💾 حفظ قائمة الحضور
    </button>


</form>

</body>
</html>
