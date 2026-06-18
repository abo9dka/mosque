<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>تسجيل الحضور</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        /* ==========================================
           CORE STYLES & VARIABLES
           ========================================== */
        :root {
            --primary-gradient: linear-gradient(135deg, #0b3a2a, #146c43);
            --primary-color: #146c43;
            --primary-dark: #0b3a2a;
            --bg-gradient: linear-gradient(135deg, #f4f7f5, #e8efe9);
            --text-main: #1e2922;
            --radius-lg: 20px;
            --radius-md: 12px;
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 10px 25px -5px rgba(20, 108, 67, 0.08);
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
            padding: 40px 20px;
            color: var(--text-main);
        }

        /* TITLE */
        h2 {
            text-align: center;
            color: var(--primary-dark);
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* CONTAINER FORM */
        form {
            max-width: 800px;
            margin: auto;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid rgba(20, 108, 67, 0.05);
        }

        /* STUDENT ROW */
        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            border-radius: var(--radius-md);
            margin-bottom: 12px;
            background: white;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0, 0, 0, 0.01);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .row:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            border-color: rgba(20, 108, 67, 0.1);
        }

        .name {
            font-weight: 700;
            color: var(--primary-dark);
            font-size: 17px;
        }

        /* ACTIONS & BUTTONS */
        .actions {
            display: flex;
            gap: 8px;
        }

        input[type="radio"] {
            display: none;
        }

        .label {
            padding: 8px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.25s ease;
            border: 2px solid transparent;
            user-select: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* DEFAULT STATES (HOVER EFFECTS) */
        .present {
            background: #f0fdf4;
            color: #16a34a;
        }

        .present:hover {
            background: #dcfce7;
        }

        .absent {
            background: #fff5f5;
            color: #dc2626;
        }

        .absent:hover {
            background: #fee2e2;
        }

        .late {
            background: #fffbeb;
            color: #d97706;
        }

        .late:hover {
            background: #fef3c7;
        }

        /* ACTIVE SELECTION STATES (PREMIUM VISUAL EFFECT) */
        #studentsGrid input[value="حاضر"]:checked+.present {
            background: #16a34a;
            color: white;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }

        #studentsGrid input[value="غائب"]:checked+.absent {
            background: #dc2626;
            color: white;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        #studentsGrid input[value="متأخر"]:checked+.late {
            background: #d97706;
            color: white;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
        }

        /* SUBMIT BUTTON */
        button {
            width: 100%;
            margin-top: 25px;
            padding: 14px;
            border: none;
            border-radius: var(--radius-md);
            background: var(--primary-gradient);
            color: white;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(20, 108, 67, 0.2);
        }

        button:hover {
            transform: translateY(-3px);
            filter: brightness(1.1);
            box-shadow: 0 6px 20px rgba(20, 108, 67, 0.3);
        }

        button:active {
            transform: scale(0.98);
        }

        /* ==========================================
           اسطورية MEDIA QUERIES (RESPONSIVE)
           ========================================== */

        /* تابلت والأجهزة المتوسطة */
        @media (max-width: 768px) {
            body {
                padding: 20px 12px;
            }

            form {
                padding: 20px 15px;
            }

            h2 {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .row {
                padding: 14px 16px;
            }

            .name {
                font-size: 16px;
            }

            .label {
                padding: 7px 14px;
                font-size: 13px;
            }
        }

        /* الجوالات الذكية (هنا السحر التلقائي) */
        @media (max-width: 550px) {
            .row {
                flex-direction: column;
                /* تحويل التوزيع رأسي لحماية الهيكل */
                align-items: flex-start;
                gap: 14px;
                padding: 16px;
            }

            .name {
                width: 100%;
                font-size: 16px;
                border-bottom: 1px dashed rgba(20, 108, 67, 0.1);
                padding-bottom: 8px;
            }

            .actions {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                /* تقسيم الأزرار الـ 3 بالتساوي */
                gap: 6px;
            }

            .label {
                width: 100%;
                padding: 10px 0;
                /* مساحة ضغط ممتازة ومريحة للإصبع */
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

    <h2>📅 تسجيل حضور الطلاب</h2>

    <form method="POST" action="{{ route('attendance.store') }}">
        @csrf

        <div id="studentsGrid">
            @foreach($students as $student)
            <div class="row">
                <div class="name">
                    {{ $student->name }}
                </div>

                <div class="actions">
                    <input type="radio" name="attendance[{{ $student->id }}]" value="حاضر" id="p{{ $student->id }}">
                    <label class="label present" for="p{{ $student->id }}">حاضر</label>

                    <input type="radio" name="attendance[{{ $student->id }}]" value="غائب" id="a{{ $student->id }}">
                    <label class="label absent" for="a{{ $student->id }}">غائب</label>

                    <input type="radio" name="attendance[{{ $student->id }}]" value="متأخر" id="l{{ $student->id }}">
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