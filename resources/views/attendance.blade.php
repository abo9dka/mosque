<!DOCTYPE html>

<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>تسجيل الحضور</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <style>
        body {
            padding: 24px 12px 40px;
        }

        h2 {
            text-align: center;
            margin: 0 0 20px;
            font-weight: 800;
            color: var(--ink);
            font-size: var(--text-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        h2 i {
            color: var(--accent);
        }

        form.attendance-form {
            max-width: 760px;
            margin: 0 auto;
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 18px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xs);
        }

        .row {
            background: var(--surface);
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .row .name {
            font-weight: 700;
            font-size: var(--text-base);
        }

        .actions {
            display: flex;
            gap: 6px;
        }

        input[type="radio"] {
            display: none;
        }

        .status-label {
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-weight: 700;
            font-size: var(--text-xs);
            background: var(--paper);
            color: var(--ink-muted);
            border: 1px solid transparent;
        }

        .status-label.present { background: var(--accent-soft); color: var(--accent-strong); }
        .status-label.late { background: var(--warning-soft); color: #92400E; }

        input[value="حاضر"]:checked + .status-label.present {
            background: var(--accent);
            color: #fff;
        }

        input[value="متأخر"]:checked + .status-label.late {
            background: var(--warning);
            color: #fff;
        }

        .absent-toggle {
            border: none;
            font-family: inherit;
        }

        .absent-toggle.active {
            background: var(--danger);
            color: white;
        }

        .absence-menu {
            width: 100%;
            margin-top: 12px;
            padding: 12px;
            background: var(--danger-soft);
            border: 1px solid #FECACA;
            border-radius: var(--radius);
            display: none;
        }

        .absence-menu.open {
            display: block;
        }

        .absence-options {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .absence-options label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: var(--text-sm);
            cursor: pointer;
            padding: 6px 10px;
            border-radius: var(--radius-sm);
            background: var(--surface);
            color: var(--ink-muted);
            border: 1px solid var(--border);
        }

        .absence-options label:has(input:checked) {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }

        .reason-input {
            width: 100%;
            display: none;
        }

        .reason-input.visible {
            display: block;
        }

        .submit-row {
            max-width: 760px;
            margin: 16px auto 0;
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

            .status-label,
            .absent-toggle {
                text-align: center;
                width: 100%;
                padding: 10px 0;
            }
        }

        .top-bar {
            max-width: 760px;
            margin: 0 auto 14px;
            display: flex;
            justify-content: flex-start;
        }

        .today-date {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            max-width: 760px;
            margin: 0 auto 20px;
            padding: 10px 18px;
            background: var(--accent-soft);
            color: var(--accent-strong);
            border: 1px solid #CDECDA;
            border-radius: var(--radius-full);
            font-weight: 800;
            font-size: var(--text-sm);
            width: fit-content;
        }

        .today-date i {
            font-size: var(--text-xs);
        }
    </style>


</head>

<body>
<div class="top-bar">
    <a href="{{ url()->previous() }}" class="back-link">
        <i class="fa-solid fa-arrow-right"></i> رجوع
    </a>
</div>
<h2><i class="fa-solid fa-calendar-days"></i> تسجيل حضور الطلاب</h2>

<div class="today-date"><i class="fa-solid fa-calendar-day"></i> {{ $todayLabel }}</div>

<form class="attendance-form" method="POST" action="{{ route('attendance.store') }}">
    @csrf


    <div id="studentsGrid">
        @foreach($students as $student)

            @php
                $status = $attendanceLogs[$student->id]->status ?? null;
                $reason = $attendanceLogs[$student->id]->absence_reason ?? '';
                $isAbsent = in_array($status, ['غياب بعذر', 'غياب بدون عذر']);
            @endphp

            <div class="row">
                <div class="name">{{ $student->name }}</div>

                <div class="actions">

                    <input type="radio"
                           name="attendance[{{ $student->id }}]"
                           value="حاضر"
                           id="p{{ $student->id }}"
                        {{ $status == 'حاضر' ? 'checked' : '' }}
                           onchange="onAttendanceChange({{ $student->id }})">
                    <label class="status-label present" for="p{{ $student->id }}">حاضر</label>

                    <button type="button"
                            class="status-label absent-toggle {{ $isAbsent ? 'active' : '' }}"
                            id="toggle{{ $student->id }}"
                            onclick="toggleAbsenceMenu({{ $student->id }})">
                        غائب <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i>
                    </button>

                    <input type="radio"
                           name="attendance[{{ $student->id }}]"
                           value="متأخر"
                           id="l{{ $student->id }}"
                        {{ $status == 'متأخر' ? 'checked' : '' }}
                           onchange="onAttendanceChange({{ $student->id }})">
                    <label class="status-label late" for="l{{ $student->id }}">متأخر</label>

                </div>

                <div class="absence-menu {{ $isAbsent ? 'open' : '' }}" id="menu{{ $student->id }}">
                    <div class="absence-options">
                        <label>
                            <input type="radio"
                                   name="attendance[{{ $student->id }}]"
                                   value="غياب بعذر"
                                   id="ae{{ $student->id }}"
                                {{ $status == 'غياب بعذر' ? 'checked' : '' }}
                                   onchange="onAttendanceChange({{ $student->id }})">
                            <span>غياب بعذر</span>
                        </label>
                        <label>
                            <input type="radio"
                                   name="attendance[{{ $student->id }}]"
                                   value="غياب بدون عذر"
                                   id="au{{ $student->id }}"
                                {{ $status == 'غياب بدون عذر' ? 'checked' : '' }}
                                   onchange="onAttendanceChange({{ $student->id }})">
                            <span>غياب بدون عذر</span>
                        </label>
                    </div>

                    <input type="text"
                           name="absence_reason[{{ $student->id }}]"
                           id="reason{{ $student->id }}"
                           class="reason-input {{ $status == 'غياب بعذر' ? 'visible' : '' }}"
                           placeholder="اذكر سبب الغياب..."
                           value="{{ $reason }}">
                </div>
            </div>

        @endforeach
    </div>

    <div class="submit-row">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa-solid fa-floppy-disk"></i> حفظ قائمة الحضور
        </button>
    </div>
</form>

<script>
    function toggleAbsenceMenu(id) {
        const menu = document.getElementById('menu' + id);
        menu.classList.toggle('open');
    }

    function onAttendanceChange(id) {
        const excused = document.getElementById('ae' + id).checked;
        const unexcused = document.getElementById('au' + id).checked;
        const reasonField = document.getElementById('reason' + id);
        const toggleBtn = document.getElementById('toggle' + id);
        const menu = document.getElementById('menu' + id);

        toggleBtn.classList.toggle('active', excused || unexcused);
        reasonField.classList.toggle('visible', excused);

        if (!excused) {
            reasonField.value = '';
        }

        if (excused || unexcused) {
            menu.classList.add('open');
        }
    }
</script>

</body>
</html>
