<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>الجدول الأسبوعي</title>

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

        .day-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        @media (min-width: 640px) {
            .day-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (min-width: 960px) {
            .day-grid { grid-template-columns: repeat(3, 1fr); }
        }

        .day-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            text-decoration: none;
            color: inherit;
            transition: border-color .15s ease;
        }

        .day-card:hover {
            border-color: var(--accent);
        }

        .day-card .day-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .day-card .day-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius);
            background: var(--accent-soft);
            color: var(--accent-strong);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .day-card.today .day-icon {
            background: var(--gold-soft);
            color: var(--gold-strong);
        }

        .day-card .day-name {
            font-weight: 800;
            font-size: var(--text-lg);
        }

        .day-card .day-count {
            font-size: var(--text-xs);
            color: var(--ink-muted);
            font-weight: 700;
        }

        .today-badge {
            font-size: 10px;
            font-weight: 800;
            color: var(--gold-strong);
            background: var(--gold-soft);
            border: 1px solid var(--gold);
            padding: 2px 8px;
            border-radius: var(--radius-full);
            margin-inline-start: 8px;
        }
    </style>
</head>
<body>

    @include('partials.navbar')
    @include('partials.admin-tabs', ['active' => 'schedule'])

    <div class="page">
        <div class="page-header">
            <h2><i class="fa-solid fa-list-check"></i> الجدول الأسبوعي</h2>
        </div>

        @if(session('success'))
            <div class="flash"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        <div class="day-grid">
            @foreach($days as $d)
                @php $isToday = $d['day'] === now()->dayOfWeek; @endphp
                <a href="{{ route('admin.schedule.show', $d['day']) }}" class="card day-card {{ $isToday ? 'today' : '' }}">
                    <div class="day-info">
                        <div class="day-icon"><i class="fa-solid fa-calendar-day"></i></div>
                        <div>
                            <div class="day-name">{{ $d['name'] }} @if($isToday)<span class="today-badge">اليوم</span>@endif</div>
                            <div class="day-count">{{ $d['count'] }} {{ $d['count'] == 1 ? 'قسم' : 'أقسام' }}</div>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-left" style="color: var(--ink-faint)"></i>
                </a>
            @endforeach
        </div>
    </div>

</body>
</html>
