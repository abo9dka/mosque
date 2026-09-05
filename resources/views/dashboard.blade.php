<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>لوحة تحكم المسجد</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .page-header h2 {
            margin: 0;
            font-size: var(--text-xl);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .page-header h2 i {
            color: var(--accent);
        }

        .btn-group {
            display: flex;
            gap: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 16px;
        }

        .student-card {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .student-card .avatar {
            width: 56px;
            height: 56px;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .student-card .name {
            font-size: var(--text-lg);
            font-weight: 800;
        }

        .student-card .parent-line {
            font-size: var(--text-sm);
            color: var(--ink-muted);
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 16px;
        }

        .student-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .student-actions .btn-follow {
            grid-column: span 2;
        }

        .student-actions form {
            display: contents;
        }

        @media (max-width: 640px) {
            .btn-group {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar', ['title' => 'نظام المسجد'])

    <div class="hero-poem">
        <div>لا يصنع الأبطال إلا في مساجدنا الفساح</div>
        <div>في روضة القرآن في ظل الأحاديث الصحاح</div>
        <div>شعب بغير عقيدة ورق تذريه الرياح</div>
        <div>من خان حي على الصلاة يخون حي على الكفاح</div>
    </div>

    <div class="page page-wide">

        <div class="page-header" id="students">
            <h2><i class="fa-solid fa-user-graduate"></i> إدارة الطلاب</h2>
            <div class="btn-group">
                <a href="{{ route('attendance') }}" class="btn btn-info">
                    <i class="fa-solid fa-calendar-days"></i> تسجيل الحضور
                </a>
                <a href="{{ route('student.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> إضافة طالب
                </a>
            </div>
        </div>

        @if(count($students))
        <div class="grid" id="studentsGrid">
            @foreach($students as $student)
            <div class="card student-card">
                <div class="avatar"><i class="fa-solid fa-user"></i></div>
                <div class="name">{{ $student->name }}</div>
                <div class="parent-line">
                    <i class="fa-solid fa-phone" style="font-size: 12px;"></i>
                    {{ $student->parent ? "{$student->parent->name} — {$student->parent->phone}" : 'لا يوجد ولي أمر' }}
                </div>

                <div class="student-actions">
                    <a href="{{ route('student.follow', $student->id) }}" class="btn btn-primary btn-follow">
                        <i class="fa-solid fa-book-open"></i> متابعة الطالب
                    </a>
                    <a href="{{ route('student.edit', $student->id) }}" class="btn btn-secondary">
                        <i class="fa-solid fa-pen"></i> تعديل
                    </a>
                    <form method="POST" action="{{ route('student.delete', $student->id) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطالب؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fa-solid fa-trash"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">لا يوجد طلاب حالياً في النظام</div>
        @endif

    </div>

</body>

</html>
