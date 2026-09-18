<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إدارة النشاطات</title>

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

        .activity-card {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .activity-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .activity-title {
            font-weight: 800;
            font-size: var(--text-lg);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .activity-title i {
            color: var(--accent);
        }

        .activity-date {
            font-size: var(--text-xs);
            color: var(--ink-muted);
            white-space: nowrap;
            background: var(--paper);
            border: 1px solid var(--border);
            padding: 5px 10px;
            border-radius: var(--radius-full);
            flex-shrink: 0;
        }

        .activity-description {
            font-size: var(--text-sm);
            color: var(--ink-muted);
            line-height: 1.7;
            white-space: pre-line;
        }

        .activity-actions {
            display: flex;
            gap: 8px;
            margin-top: 4px;
        }

        .activity-actions form {
            flex: 1;
        }
    </style>
</head>
<body>

    @include('partials.navbar')
    @include('partials.admin-tabs', ['active' => 'activities'])

    <div class="page">
        <div class="page-header">
            <h2><i class="fa-solid fa-calendar-days"></i> إدارة نشاطات المسجد</h2>
            <a href="{{ route('admin.activities.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> إضافة نشاط
            </a>
        </div>

        @if(session('success'))
            <div class="flash"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}</div>
        @endif

        <div class="stat-grid" style="margin-bottom: 16px;">
            <div class="stat-tile">
                <div class="stat-icon"><i class="fa-solid fa-calendar-days"></i></div>
                <div class="stat-value">{{ $totalActivities }}</div>
                <div class="stat-label">إجمالي النشاطات</div>
            </div>
            <div class="stat-tile">
                <div class="stat-icon"><i class="fa-solid fa-user-graduate"></i></div>
                <div class="stat-value">{{ $totalParticipations }}</div>
                <div class="stat-label">إجمالي المشاركات</div>
            </div>
            <div class="stat-tile gold">
                <div class="stat-icon"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="stat-value">{{ $thisMonthCount }}</div>
                <div class="stat-label">نشاطات هذا الشهر</div>
            </div>
        </div>

        @if($activities->isEmpty())
            <div class="empty-state">لا يوجد نشاطات مسجلة بعد.</div>
        @else
            <div class="logs-wrap">
                @foreach($activities as $activity)
                    <div class="card activity-card">
                        <div class="activity-top">
                            <div class="activity-title"><i class="fa-solid fa-star"></i> {{ $activity->title }}</div>
                            <div class="activity-date"><i class="fa-solid fa-calendar-day"></i> {{ $activity->dateLabel }}</div>
                        </div>

                        @if($activity->description)
                            <div class="activity-description">{{ $activity->description }}</div>
                        @endif

                        <div class="chips">
                            <span class="chip green">
                                <i class="fa-solid fa-user-graduate"></i>
                                {{ $activity->students_count }} {{ $activity->students_count == 1 ? 'طالب مشترك' : 'طلاب مشتركون' }}
                            </span>
                        </div>

                        <div class="activity-actions">
                            <a href="{{ route('admin.activities.edit', $activity->id) }}" class="btn btn-secondary btn-block">
                                <i class="fa-solid fa-pen"></i> تعديل
                            </a>
                            <form method="POST" action="{{ route('admin.activities.destroy', $activity->id) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا النشاط؟')">
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
