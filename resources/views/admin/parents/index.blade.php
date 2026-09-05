<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إدارة أولياء الأمور</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

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

        .parent-card .name {
            font-weight: 800;
            font-size: var(--text-lg);
            margin-bottom: 4px;
        }

        .parent-card .phone {
            color: var(--ink-muted);
            font-size: var(--text-sm);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .parent-card .badge-row {
            margin-bottom: 12px;
        }

        .parent-card .actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
    </style>
</head>
<body>

    @include('partials.navbar', ['title' => 'لوحة المدير'])

    <div class="page">
        <div class="page-header">
            <h2><i class="fa-solid fa-users"></i> إدارة حسابات أولياء الأمور</h2>
            <a href="{{ route('admin.parents.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> إضافة ولي أمر
            </a>
        </div>

        @if(session('success'))
            <div class="flash"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        @if($parents->isEmpty())
            <div class="empty-state">لا يوجد حسابات أولياء أمور بعد.</div>
        @else
            <div class="grid">
                @foreach($parents as $parent)
                    <div class="card parent-card">
                        <div class="name">{{ $parent->name }}</div>
                        <div class="phone"><i class="fa-solid fa-phone"></i> {{ $parent->phone }}</div>
                        <div class="badge-row">
                            <span class="chip green">
                                <i class="fa-solid fa-child"></i>
                                {{ $parent->children_count }} {{ $parent->children_count == 1 ? 'ابن مسجل' : 'أبناء مسجلين' }}
                            </span>
                        </div>
                        <div class="actions">
                            <a href="{{ route('admin.parents.edit', $parent->id) }}" class="btn btn-secondary">
                                <i class="fa-solid fa-pen"></i> تعديل
                            </a>
                            <form method="POST" action="{{ route('admin.parents.destroy', $parent->id) }}" onsubmit="return confirm('هل أنت متأكد من حذف حساب ولي الأمر هذا؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fa-solid fa-trash"></i> حذف الحساب
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
