<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>لوحة الإحصائيات</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-256.png') }}">

    <style>
        .page-title {
            margin: 18px 0 14px;
            font-size: var(--text-xl);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .page-title i {
            color: var(--accent);
        }

        .section-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }

        @media (min-width: 800px) {
            .section-row.cols-2 {
                grid-template-columns: 1fr 1fr;
            }
        }

        .empty-mini {
            padding: 16px;
            text-align: center;
            color: var(--ink-faint);
            font-size: var(--text-sm);
        }
    </style>
</head>
<body>

    @include('partials.navbar')
    @include('partials.admin-tabs', ['active' => 'dashboard'])

    <div class="page page-wide">
        <h2 class="page-title"><i class="fa-solid fa-chart-line"></i> نظرة عامة على النظام</h2>

        <div class="stat-grid" style="margin-bottom: 14px;">
            <div class="stat-tile">
                <div class="stat-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                <div class="stat-value">{{ $totalTeachers }}</div>
                <div class="stat-label">الأساتذة</div>
            </div>
            <div class="stat-tile">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div class="stat-value">{{ $totalParents }}</div>
                <div class="stat-label">أولياء الأمور</div>
            </div>
            <div class="stat-tile">
                <div class="stat-icon"><i class="fa-solid fa-user-graduate"></i></div>
                <div class="stat-value">{{ $totalStudents }}</div>
                <div class="stat-label">الطلاب</div>
            </div>
            <div class="stat-tile">
                <div class="stat-icon"><i class="fa-solid fa-link"></i></div>
                <div class="stat-value" dir="ltr" style="text-align: right;">{{ $studentsWithParent }} / {{ $totalStudents }}</div>
                <div class="stat-label">مرتبطون بولي أمر</div>
            </div>
            <div class="stat-tile gold">
                <div class="stat-icon"><i class="fa-solid fa-book-open"></i></div>
                <div class="stat-value">{{ $avgCompletion }}%</div>
                <div class="stat-label">متوسط نسبة الحفظ</div>
            </div>
        </div>

        <div class="section-row cols-2" style="margin-bottom: 14px;">
            <div class="section-card">
                <div class="section-title"><i class="fa-solid fa-calendar-day"></i> الحضور اليوم</div>
                @php
                    $todayTotal = $todayAttendance->sum();
                @endphp
                @if($todayTotal === 0)
                    <div class="empty-mini">لم يُسجَّل أي حضور اليوم بعد.</div>
                @else
                    @php
                        $todayRows = [
                            ['label' => 'حاضر', 'icon' => 'fa-circle-check', 'color' => 'var(--accent)', 'count' => $todayAttendance->get('حاضر', 0)],
                            ['label' => 'متأخر', 'icon' => 'fa-clock', 'color' => 'var(--warning)', 'count' => $todayAttendance->get('متأخر', 0)],
                            ['label' => 'غياب بعذر', 'icon' => 'fa-file-lines', 'color' => 'var(--ink-faint)', 'count' => $todayAttendance->get('غياب بعذر', 0)],
                            ['label' => 'غياب بدون عذر', 'icon' => 'fa-circle-xmark', 'color' => 'var(--danger)', 'count' => $todayAttendance->get('غياب بدون عذر', 0)],
                        ];
                    @endphp
                    @foreach($todayRows as $row)
                        <div class="breakdown-row">
                            <div class="breakdown-label"><i class="fa-solid {{ $row['icon'] }}" style="color: {{ $row['color'] }}"></i> {{ $row['label'] }}</div>
                            <div class="breakdown-track">
                                <div class="breakdown-fill" style="width: {{ $todayTotal ? round($row['count'] / $todayTotal * 100) : 0 }}%; background: {{ $row['color'] }}"></div>
                            </div>
                            <div class="breakdown-count">{{ $row['count'] }}</div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="section-card">
                <div class="section-title"><i class="fa-solid fa-calendar-week"></i> الحضور هذا الأسبوع</div>
                @php
                    $weekTotal = $weekAttendance->sum();
                @endphp
                @if($weekTotal === 0)
                    <div class="empty-mini">لا يوجد سجلات حضور لهذا الأسبوع بعد.</div>
                @else
                    @php
                        $weekRows = [
                            ['label' => 'حاضر', 'icon' => 'fa-circle-check', 'color' => 'var(--accent)', 'count' => $weekAttendance->get('حاضر', 0)],
                            ['label' => 'متأخر', 'icon' => 'fa-clock', 'color' => 'var(--warning)', 'count' => $weekAttendance->get('متأخر', 0)],
                            ['label' => 'غياب بعذر', 'icon' => 'fa-file-lines', 'color' => 'var(--ink-faint)', 'count' => $weekAttendance->get('غياب بعذر', 0)],
                            ['label' => 'غياب بدون عذر', 'icon' => 'fa-circle-xmark', 'color' => 'var(--danger)', 'count' => $weekAttendance->get('غياب بدون عذر', 0)],
                        ];
                    @endphp
                    @foreach($weekRows as $row)
                        <div class="breakdown-row">
                            <div class="breakdown-label"><i class="fa-solid {{ $row['icon'] }}" style="color: {{ $row['color'] }}"></i> {{ $row['label'] }}</div>
                            <div class="breakdown-track">
                                <div class="breakdown-fill" style="width: {{ $weekTotal ? round($row['count'] / $weekTotal * 100) : 0 }}%; background: {{ $row['color'] }}"></div>
                            </div>
                            <div class="breakdown-count">{{ $row['count'] }}</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="section-card" style="margin-bottom: 14px;">
            <div class="section-title"><i class="fa-solid fa-book-open-reader"></i> نشاط الحفظ الجديد هذا الأسبوع</div>
            @if($weekLoggedCount === 0)
                <div class="empty-mini">لا يوجد تسجيلات حفظ جديد لهذا الأسبوع بعد.</div>
            @else
                <div class="progress-label">
                    <span>{{ $weekPassedCount }} ناجح من أصل {{ $weekLoggedCount }} تسجيل ({{ $weekFailedCount }} راسب)</span>
                    <span>{{ $weekLoggedCount ? round($weekPassedCount / $weekLoggedCount * 100) : 0 }}%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: {{ $weekLoggedCount ? round($weekPassedCount / $weekLoggedCount * 100) : 0 }}%"></div>
                </div>
            @endif
        </div>

        <div class="section-row cols-2" style="margin-bottom: 14px;">
            <div class="section-card">
                <div class="section-title"><i class="fa-solid fa-trophy" style="color: var(--gold)"></i> الأعلى حفظًا للقرآن</div>
                @if($topByCompletion->isEmpty())
                    <div class="empty-mini">لا يوجد بيانات كافية بعد.</div>
                @else
                    <div class="rank-list">
                        @foreach($topByCompletion as $i => $row)
                            <div class="rank-row">
                                <div class="rank-num">{{ $i + 1 }}</div>
                                <div>
                                    <div class="rank-name">{{ $row['student']->name }}</div>
                                    <div class="rank-sub">{{ $row['memorized'] }} آية</div>
                                </div>
                                <div class="rank-value" style="margin-inline-start: auto;">{{ $row['percent'] }}%</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="section-card">
                <div class="section-title"><i class="fa-solid fa-star" style="color: var(--gold)"></i> الأعلى نقاطًا</div>
                @if($topByPoints->isEmpty())
                    <div class="empty-mini">لا يوجد بيانات كافية بعد.</div>
                @else
                    <div class="rank-list">
                        @foreach($topByPoints as $i => $student)
                            <div class="rank-row">
                                <div class="rank-num">{{ $i + 1 }}</div>
                                <div class="rank-name">{{ $student->name }}</div>
                                <div class="rank-value" style="margin-inline-start: auto;">{{ $student->points }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="section-card">
            <div class="section-title"><i class="fa-solid fa-scale-balanced"></i> توزيع الطلاب على الأساتذة</div>
            @if($teacherLoads->isEmpty())
                <div class="empty-mini">لا يوجد أساتذة بعد.</div>
            @else
                @php
                    $maxLoad = max(1, $teacherLoads->max('students_count'));
                @endphp
                <div class="rank-list">
                    @foreach($teacherLoads as $teacher)
                        <div class="breakdown-row">
                            <div class="breakdown-label" style="width: 160px;"><i class="fa-solid fa-user"></i> {{ $teacher->name }}</div>
                            <div class="breakdown-track">
                                <div class="breakdown-fill" style="width: {{ round($teacher->students_count / $maxLoad * 100) }}%; background: var(--accent);"></div>
                            </div>
                            <div class="breakdown-count">{{ $teacher->students_count }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</body>
</html>
