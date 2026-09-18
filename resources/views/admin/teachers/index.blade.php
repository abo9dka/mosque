<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إدارة الأساتذة</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-256.png') }}">

    <style>
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 18px;
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

        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        @media (min-width: 640px) {
            .grid { grid-template-columns: 1fr 1fr; }
        }

        .teacher-card .name {
            font-weight: 800;
            font-size: var(--text-lg);
            margin-bottom: 4px;
        }

        .teacher-card .phone {
            color: var(--ink-muted);
            font-size: var(--text-sm);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .teacher-card .badge-row {
            margin-bottom: 12px;
        }

        .teacher-card .actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .teacher-card .actions .btn-manage {
            grid-column: span 2;
        }
    </style>
</head>
<body>

    @include('partials.navbar')
    @include('partials.admin-tabs', ['active' => 'teachers'])

    <div class="page">
        <div class="page-header">
            <h2><i class="fa-solid fa-chalkboard-user"></i> إدارة حسابات الأساتذة</h2>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> إضافة أستاذ
            </a>
        </div>

        @if(session('success'))
            <div class="flash"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
        @endif

        @if($teachers->isEmpty())
            <div class="empty-state">لا يوجد حسابات أساتذة بعد.</div>
        @else
            <div class="grid">
                @foreach($teachers as $teacher)
                    <div class="card teacher-card">
                        <div class="name">{{ $teacher->name }}</div>
                        <div class="phone"><i class="fa-solid fa-phone"></i> {{ $teacher->phone }}</div>
                        <div class="badge-row">
                            <span class="chip green">
                                <i class="fa-solid fa-user-graduate"></i>
                                {{ $teacher->students_count }} {{ $teacher->students_count == 1 ? 'طالب' : 'طلاب' }}
                            </span>
                        </div>
                        <div class="actions">
                            <a href="{{ route('admin.teachers.show', $teacher->id) }}" class="btn btn-info btn-manage">
                                <i class="fa-solid fa-users-gear"></i> إدارة الطلاب
                            </a>
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-secondary">
                                <i class="fa-solid fa-pen"></i> تعديل
                            </a>
                            <form method="POST" action="{{ route('admin.teachers.destroy', $teacher->id) }}" onsubmit="return confirm('هل أنت متأكد من حذف حساب هذا الأستاذ؟')">
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
        @endif
    </div>

</body>
</html>
