<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>متابعة {{ $student->name }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

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

        .surah-list {
            display: grid;
            gap: 8px;
            margin-top: 10px;
        }

        .surah-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            background: var(--paper);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: var(--text-sm);
        }

        .surah-row .name { font-weight: 700; }
        .surah-row .count { color: var(--ink-muted); }

        .toggle-btn {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            border-radius: var(--radius);
            border: 1px dashed var(--border);
            background: var(--paper);
            color: var(--ink-muted);
            font-weight: 700;
            font-size: var(--text-sm);
            cursor: pointer;
            font-family: inherit;
        }

        /* POINTS */
        .points-box {
            background: var(--accent-strong);
            color: white;
            border-radius: var(--radius-lg);
            padding: 22px;
            text-align: center;
        }

        .points-value { font-size: 38px; font-weight: 900; }
        .points-label { font-size: var(--text-sm); opacity: .85; }

        /* WEEK ATTENDANCE STRIP */
        .week-strip {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
        }

        .day-box {
            text-align: center;
            padding: 10px 4px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            background: var(--paper);
        }

        .day-box .day-name { font-size: 11px; color: var(--ink-muted); font-weight: 700; margin-bottom: 4px; }
        .day-box .day-date { font-size: 10.5px; color: var(--ink-faint); margin-bottom: 6px; }
        .day-box .day-icon { font-size: 15px; }

        .day-box.present { background: var(--accent-soft); border-color: #CDECDA; color: var(--accent-strong); }
        .day-box.excused { background: var(--paper); border-color: var(--border); color: var(--ink-muted); }
        .day-box.unexcused { background: var(--danger-soft); border-color: #FECDD3; color: var(--danger); }
        .day-box.late { background: var(--warning-soft); border-color: #FDE68A; color: var(--warning); }
    </style>
</head>
<body>

@php
    $dayNames = ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
    $statusClass = [
        \App\Models\AttendanceLog::STATUS_PRESENT => 'present',
        \App\Models\AttendanceLog::STATUS_EXCUSED_ABSENCE => 'excused',
        \App\Models\AttendanceLog::STATUS_UNEXCUSED_ABSENCE => 'unexcused',
        \App\Models\AttendanceLog::STATUS_LATE => 'late',
    ];
    $statusIcon = [
        \App\Models\AttendanceLog::STATUS_PRESENT => 'fa-circle-check',
        \App\Models\AttendanceLog::STATUS_EXCUSED_ABSENCE => 'fa-file-lines',
        \App\Models\AttendanceLog::STATUS_UNEXCUSED_ABSENCE => 'fa-circle-xmark',
        \App\Models\AttendanceLog::STATUS_LATE => 'fa-clock',
    ];
@endphp

<div class="page">

    <a href="{{ route('parent.dashboard') }}" class="back-link"><i class="fa-solid fa-arrow-right"></i> العودة</a>

    <div class="header card" style="margin-bottom:12px">
        <h2 style="margin:0 0 8px; font-size: var(--text-xl); display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-user" style="color:var(--accent)"></i> {{ $student->name }}
        </h2>
        @if($student->grade)
            <p><i class="fa-solid fa-school"></i> الصف: {{ $student->grade }}</p>
        @endif
        @if($student->address)
            <p><i class="fa-solid fa-location-dot"></i> {{ $student->address }}</p>
        @endif
    </div>

    <div class="section-card">
        <div class="section-title"><i class="fa-solid fa-book-open"></i> نسبة حفظ القرآن الكريم</div>
        <div class="progress-label">
            <span>{{ $progress['memorized'] }} من {{ $progress['total'] }} آية</span>
            <span>{{ $progress['percent'] }}%</span>
        </div>
        <div class="progress-track">
            <div class="progress-fill" style="width: {{ $progress['percent'] }}%"></div>
        </div>

        @if(count($progress['bySurah']))
            <button type="button" class="toggle-btn" id="surahToggleBtn" onclick="toggleSurahBreakdown()">إظهار تفاصيل السور <i class="fa-solid fa-chevron-down"></i></button>
            <div id="surahBreakdown" class="surah-list hidden">
                @foreach($progress['bySurah'] as $s)
                    <div class="surah-row">
                        <span class="name">{{ $s['number'] }}. {{ $s['name'] }}</span>
                        <span class="count">{{ $s['memorized'] }} / {{ $s['ayahs'] }} آية</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="section-card">
        <div class="section-title"><i class="fa-solid fa-star"></i> النقاط</div>
        <div class="points-box">
            <div class="points-value">{{ $student->points }}</div>
            <div class="points-label">إجمالي النقاط</div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-title"><i class="fa-solid fa-calendar-days"></i> الحضور هذا الأسبوع</div>
        <div class="week-strip">
            @foreach($weekDays as $i => $day)
                @php
                    $status = $day['log']->status ?? null;
                    $cls = $statusClass[$status] ?? '';
                    $icon = $statusIcon[$status] ?? null;
                @endphp
                <div class="day-box {{ $cls }}">
                    <div class="day-name">{{ $dayNames[$i] }}</div>
                    <div class="day-date">{{ $day['date']->format('m-d') }}</div>
                    <div class="day-icon">
                        @if($icon)
                            <i class="fa-solid {{ $icon }}"></i>
                        @else
                            <i class="fa-regular fa-circle" style="color: var(--ink-faint)"></i>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="section-card">
        <div class="section-title">
            <span><i class="fa-solid fa-book-open"></i> الحفظ الجديد اليوم</span>
            <span class="count-badge">{{ $todayLogs->count() }}</span>
        </div>
        <div class="logs-wrap">
            @forelse($todayLogs as $item)
                <div class="log-item">
                    <div class="log-top">
                        <p class="log-title"><i class="fa-solid fa-book"></i> {{ $item->surah ?? 'بدون سورة' }}</p>
                        <span class="log-date">{{ optional($item->created_at)->format('H:i') }}</span>
                    </div>
                    <div class="chips">
                        @if($item->score !== null)
                            <span class="chip {{ $item->isFailed() ? 'rose' : 'green' }}">
                                <i class="fa-solid {{ $item->isFailed() ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                {{ $item->isFailed() ? 'راسب' : 'ناجح' }}
                            </span>
                        @endif
                        <span class="chip gray"><i class="fa-solid fa-star"></i> {{ $item->score ?? '-' }}</span>
                        <span class="chip gray">من {{ $item->from_ayah ?? '-' }} إلى {{ $item->to_ayah ?? '-' }}</span>
                    </div>
                    @if($item->homework || $item->notes)
                        <div class="log-notes">
                            @if($item->homework)
                                <div class="log-note">
                                    <i class="fa-solid fa-book-open-reader"></i>
                                    <span><span class="note-label">الواجب المنزلي</span>{{ $item->homework }}</span>
                                </div>
                            @endif
                            @if($item->notes)
                                <div class="log-note muted">
                                    <i class="fa-solid fa-note-sticky"></i>
                                    <span><span class="note-label">ملاحظات المعلم</span>{{ $item->notes }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">لم يُسجَّل حفظ جديد اليوم بعد.</div>
            @endforelse
        </div>
    </div>

    <div class="section-card">
        <div class="section-title">
            <span><i class="fa-solid fa-book-open"></i> الحفظ الجديد هذا الأسبوع</span>
            <span class="count-badge">{{ $weekLogs->count() }}</span>
        </div>
        <div class="logs-wrap">
            @forelse($weekLogs as $item)
                <div class="log-item">
                    <div class="log-top">
                        <p class="log-title"><i class="fa-solid fa-book"></i> {{ $item->surah ?? 'بدون سورة' }}</p>
                        <span class="log-date">{{ optional($item->created_at)->format('Y-m-d') }}</span>
                    </div>
                    <div class="chips">
                        @if($item->score !== null)
                            <span class="chip {{ $item->isFailed() ? 'rose' : 'green' }}">
                                <i class="fa-solid {{ $item->isFailed() ? 'fa-circle-xmark' : 'fa-circle-check' }}"></i>
                                {{ $item->isFailed() ? 'راسب' : 'ناجح' }}
                            </span>
                        @endif
                        <span class="chip gray"><i class="fa-solid fa-star"></i> {{ $item->score ?? '-' }}</span>
                        <span class="chip gray">من {{ $item->from_ayah ?? '-' }} إلى {{ $item->to_ayah ?? '-' }}</span>
                    </div>
                    @if($item->homework || $item->notes)
                        <div class="log-notes">
                            @if($item->homework)
                                <div class="log-note">
                                    <i class="fa-solid fa-book-open-reader"></i>
                                    <span><span class="note-label">الواجب المنزلي</span>{{ $item->homework }}</span>
                                </div>
                            @endif
                            @if($item->notes)
                                <div class="log-note muted">
                                    <i class="fa-solid fa-note-sticky"></i>
                                    <span><span class="note-label">ملاحظات المعلم</span>{{ $item->notes }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">لا يوجد تسجيلات حفظ لهذا الأسبوع بعد.</div>
            @endforelse
        </div>
    </div>

    @if($weekReviewLogs->count())
        <div class="section-card">
            <div class="section-title">
                <span><i class="fa-solid fa-rotate"></i> المراجعة الكبرى هذا الأسبوع</span>
                <span class="count-badge">{{ $weekReviewLogs->count() }}</span>
            </div>
            <div class="logs-wrap">
                @foreach($weekReviewLogs as $item)
                    <div class="log-item">
                        <div class="log-top">
                            <p class="log-title"><i class="fa-solid fa-rotate"></i> {{ $item->weekly_memorization ?? 'بدون عنوان' }}</p>
                            <span class="log-date">{{ optional($item->created_at)->format('Y-m-d') }}</span>
                        </div>
                        <div class="chips">
                            <span class="chip amber"><i class="fa-solid fa-star"></i> {{ $item->score ?? '-' }}</span>
                        </div>
                        @if($item->review_homework)
                            <div class="log-notes">
                                <div class="log-note">
                                    <i class="fa-solid fa-file-lines"></i>
                                    <span><span class="note-label">واجب المراجعة</span>{{ $item->review_homework }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

<script>
    function toggleSurahBreakdown() {
        const panel = document.getElementById('surahBreakdown');
        const btn = document.getElementById('surahToggleBtn');
        const nowHidden = panel.classList.toggle('hidden');
        btn.innerHTML = nowHidden
            ? 'إظهار تفاصيل السور <i class="fa-solid fa-chevron-down"></i>'
            : 'إخفاء تفاصيل السور <i class="fa-solid fa-chevron-up"></i>';
    }
</script>

</body>
</html>
