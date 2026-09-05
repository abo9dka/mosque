<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>لوحة ولي الأمر</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <style>
        .page-title {
            margin: 4px 0 16px;
            font-size: var(--text-xl);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .page-title i {
            color: var(--accent);
        }

        .child-card {
            display: block;
            text-decoration: none;
            color: inherit;
            margin-bottom: 14px;
            transition: border-color .15s ease;
        }

        .child-card:hover {
            border-color: var(--accent);
        }

        .child-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 14px;
        }

        .child-name {
            font-size: var(--text-lg);
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .child-name i {
            color: var(--accent);
        }

        .child-grade {
            color: var(--ink-muted);
            font-size: var(--text-sm);
            margin-top: 2px;
        }

        .points-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--warning-soft);
            color: #92400e;
            border: 1px solid #fde68a;
            padding: 6px 12px;
            border-radius: var(--radius-full);
            font-weight: 800;
            font-size: var(--text-sm);
            white-space: nowrap;
        }

        .progress-row {
            margin-bottom: 12px;
        }

        .more {
            margin-top: 12px;
            text-align: center;
            font-size: var(--text-sm);
            font-weight: 800;
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
    </style>
</head>
<body>

    @include('partials.navbar')

    <div class="page">
        <h2 class="page-title"><i class="fa-solid fa-users"></i> أبناؤكم</h2>

        @if($children->isEmpty())
            <div class="empty-state">لا يوجد أبناء مرتبطين بحسابك بعد. الرجاء التواصل مع إدارة المسجد.</div>
        @else
            @foreach($children as $student)
                @php
                    $progress = $student->quran_progress;
                    $weekCounts = $student->week_attendance_counts;
                @endphp
                <a href="{{ route('parent.student.show', $student->id) }}" class="card child-card">
                    <div class="child-top">
                        <div>
                            <div class="child-name"><i class="fa-solid fa-user"></i> {{ $student->name }}</div>
                            @if($student->grade)
                                <div class="child-grade">الصف: {{ $student->grade }}</div>
                            @endif
                        </div>
                        <div class="points-pill"><i class="fa-solid fa-star"></i> {{ $student->points }} نقطة</div>
                    </div>

                    <div class="progress-row">
                        <div class="progress-label">
                            <span>حفظ القرآن الكريم</span>
                            <span>{{ $progress['percent'] }}% ({{ $progress['memorized'] }} / {{ $progress['total'] }} آية)</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" style="width: {{ $progress['percent'] }}%"></div>
                        </div>
                    </div>

                    <div class="chips">
                        @if($student->today_status)
                            <span class="chip green"><i class="fa-solid fa-calendar-days"></i> اليوم: {{ $student->today_status }}</span>
                        @else
                            <span class="chip gray"><i class="fa-solid fa-calendar-days"></i> لم يُسجَّل حضور اليوم بعد</span>
                        @endif

                        @if($weekCounts->get('غياب بدون عذر'))
                            <span class="chip rose">غياب بدون عذر: {{ $weekCounts->get('غياب بدون عذر') }}</span>
                        @endif
                        @if($weekCounts->get('متأخر'))
                            <span class="chip amber">تأخير: {{ $weekCounts->get('متأخر') }}</span>
                        @endif
                    </div>

                    <div class="more">عرض التفاصيل <i class="fa-solid fa-arrow-left"></i></div>
                </a>
            @endforeach
        @endif
    </div>

</body>
</html>
