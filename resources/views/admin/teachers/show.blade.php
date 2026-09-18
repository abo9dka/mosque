<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إدارة طلاب {{ $teacher->name }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-256.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <style>
        .header p {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--ink-muted);
            font-size: var(--text-sm);
            margin: 4px 0 0;
        }

        .header p i {
            width: 14px;
            color: var(--accent);
        }

        .student-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 8px;
        }

        .student-row input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: var(--accent);
            flex-shrink: 0;
            cursor: pointer;
        }

        .student-row .student-name {
            font-weight: 700;
            font-size: var(--text-sm);
        }

        .student-row .student-grade {
            color: var(--ink-muted);
            font-size: var(--text-xs);
        }

        .select-all-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
            font-size: var(--text-sm);
            font-weight: 700;
            color: var(--ink-muted);
        }

        .select-all-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .transfer-bar {
            display: flex;
            gap: 10px;
            align-items: flex-end;
            flex-wrap: wrap;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .transfer-bar .field {
            flex: 1;
            min-width: 220px;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <div class="page">

        <a href="{{ route('admin.teachers.index') }}" class="back-link"><i class="fa-solid fa-arrow-right"></i> العودة لقائمة الأساتذة</a>

        <div class="header card" style="margin: 12px 0;">
            <h2 style="margin:0 0 8px; font-size: var(--text-xl); display:flex; align-items:center; gap:8px;">
                <i class="fa-solid fa-chalkboard-user" style="color:var(--accent)"></i> {{ $teacher->name }}
            </h2>
            <p><i class="fa-solid fa-phone"></i> {{ $teacher->phone }}</p>
            <p><i class="fa-solid fa-user-graduate"></i> {{ $students->count() }} {{ $students->count() == 1 ? 'طالب' : 'طلاب' }}</p>
        </div>

        @if(session('success'))
            <div class="flash"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
        @endif

        <div class="section-card">
            <div class="section-title"><i class="fa-solid fa-users-gear"></i> طلاب الأستاذ ونقلهم لأستاذ آخر</div>

            @if($students->isEmpty())
                <div class="empty-state">لا يوجد طلاب مسجلون لدى هذا الأستاذ حاليًا.</div>
            @else
                <form method="POST" action="{{ route('admin.teachers.transferStudents', $teacher->id) }}" id="transferForm">
                    @csrf

                    <div class="select-all-row">
                        <input type="checkbox" id="selectAll">
                        <label for="selectAll">تحديد الكل</label>
                    </div>

                    @foreach($students as $student)
                        <div class="student-row">
                            <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="student-checkbox" id="student{{ $student->id }}">
                            <label for="student{{ $student->id }}" style="flex:1; cursor:pointer;">
                                <div class="student-name">{{ $student->name }}</div>
                                @if($student->grade)
                                    <div class="student-grade">الصف: {{ $student->grade }}</div>
                                @endif
                            </label>
                        </div>
                    @endforeach

                    @if($otherTeachers->isEmpty())
                        <div class="empty-state" style="margin-top: 12px;">لا يوجد أساتذة آخرون لنقل الطلاب إليهم حاليًا.</div>
                    @else
                        <div class="transfer-bar">
                            <div class="field">
                                <label>نقل الطلاب المحددين إلى</label>
                                <select name="to_teacher_id" id="teacher-select">
                                    <option value=""></option>
                                    @foreach($otherTeachers as $other)
                                        <option value="{{ $other->id }}">{{ $other->name }} — {{ $other->phone }}</option>
                                    @endforeach
                                </select>
                                @error('to_teacher_id')<div class="field-error">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-right-left"></i> نقل الطلاب المحددين
                            </button>
                        </div>
                    @endif
                </form>
            @endif
        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    const teacherSelectEl = document.getElementById('teacher-select');
    if (teacherSelectEl) {
        new TomSelect('#teacher-select', {
            create: false,
            placeholder: 'ابحث عن الأستاذ بالاسم أو رقم الهاتف...',
            maxOptions: 1000,
        });
    }

    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.student-checkbox').forEach(cb => { cb.checked = selectAll.checked; });
        });
    }

    document.getElementById('transferForm')?.addEventListener('submit', function (e) {
        const anyChecked = document.querySelectorAll('.student-checkbox:checked').length > 0;
        if (!anyChecked) {
            e.preventDefault();
            alert('الرجاء تحديد طالب واحد على الأقل لنقله.');
        }
    });
</script>

</body>
</html>
