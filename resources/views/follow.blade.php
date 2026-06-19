<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>متابعة الطالب</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg: #f3f6fb;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --green: #16a34a;
            --green-2: #dcfce7;
            --blue: #2563eb;
            --blue-2: #dbeafe;
            --amber: #d97706;
            --amber-2: #fef3c7;
            --rose: #e11d48;
            --shadow: 0 10px 30px rgba(15, 23, 42, .08);
            --radius: 18px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: var(--bg);
            margin: 0;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        .page {
            width: 100%;
            max-width: 920px;
            margin: 0 auto;
            padding: 12px;
        }

        .back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: var(--text);
            background: rgba(255,255,255,.85);
            border: 1px solid var(--line);
            padding: 10px 14px;
            border-radius: 999px;
            box-shadow: var(--shadow);
            font-weight: 700;
            margin-bottom: 12px;
        }

        .header {
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
            border: 1px solid var(--line);
            padding: 14px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 12px;
        }

        .header h2 {
            margin: 0 0 6px;
            font-size: 20px;
            line-height: 1.35;
        }

        .header p {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .flash {
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        /* TABS */
        .tabs {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding-bottom: 4px;
            margin-bottom: 12px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .tabs::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            min-width: 150px;
            flex: 0 0 auto;
            border: 1px solid var(--line);
            background: rgba(255,255,255,.9);
            color: var(--text);
            border-radius: 14px;
            padding: 12px 14px;
            font-family: inherit;
            font-weight: 800;
            cursor: pointer;
            box-shadow: var(--shadow);
            transition: .2s ease;
            touch-action: manipulation;
        }

        .tab-btn.active {
            background: var(--green);
            color: #fff;
            border-color: var(--green);
            transform: translateY(-1px);
        }

        .tab-btn:nth-child(2).active {
            background: var(--blue);
            border-color: var(--blue);
        }

        .tab-btn:nth-child(3).active {
            background: var(--amber);
            border-color: var(--amber);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* CARDS */
        .section-card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px;
            margin-bottom: 12px;
        }

        .section-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }

        .section-title h3 {
            margin: 0;
            font-size: 16px;
        }

        .count-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 28px;
            padding: 0 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
            background: #f8fafc;
            color: var(--muted);
            border: 1px solid var(--line);
        }

        /* FORMS */
        form {
            margin: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field label {
            font-size: 13px;
            color: var(--muted);
            font-weight: 700;
        }

        .field input,
        .field textarea {
            width: 100%;
            border: 1px solid var(--line);
            background: #fff;
            border-radius: 14px;
            padding: 12px 14px;
            font-family: inherit;
            font-size: 15px;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .field input:focus,
        .field textarea:focus {
            border-color: rgba(37, 99, 235, .45);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .08);
        }

        .field textarea {
            min-height: 96px;
            resize: vertical;
        }

        .field.span-2 {
            grid-column: 1 / -1;
        }

        .submit-btn {
            width: 100%;
            border: none;
            border-radius: 16px;
            padding: 13px 16px;
            margin-top: 12px;
            font-family: inherit;
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, var(--green) 0%, #22c55e 100%);
            box-shadow: 0 10px 25px rgba(22, 163, 74, .22);
            cursor: pointer;
            touch-action: manipulation;
        }

        .submit-btn.review {
            background: linear-gradient(135deg, var(--blue) 0%, #3b82f6 100%);
            box-shadow: 0 10px 25px rgba(37, 99, 235, .22);
        }

        /* LOGS */
        .logs-wrap {
            display: grid;
            gap: 10px;
        }

        .log-item {
            width: 100%;
            text-align: right;
            border: 1px solid var(--line);
            background: #fff;
            border-radius: 16px;
            padding: 12px;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(15, 23, 42, .05);
            transition: transform .15s ease, border-color .15s ease;
            touch-action: manipulation;
            font-family: inherit;
        }

        .log-item:active {
            transform: scale(.99);
        }

        .log-top {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .log-title {
            margin: 0;
            font-size: 15px;
            line-height: 1.5;
            font-weight: 800;
            color: var(--text);
        }

        .log-date {
            font-size: 12px;
            color: var(--muted);
            white-space: nowrap;
            background: #f8fafc;
            border: 1px solid var(--line);
            padding: 5px 8px;
            border-radius: 999px;
        }

        .chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 700;
            border-radius: 999px;
            padding: 6px 10px;
            border: 1px solid transparent;
        }

        .chip.green {
            background: var(--green-2);
            color: #166534;
            border-color: #bbf7d0;
        }

        .chip.blue {
            background: var(--blue-2);
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .chip.amber {
            background: var(--amber-2);
            color: #92400e;
            border-color: #fde68a;
        }

        .chip.gray {
            background: #f1f5f9;
            color: #475569;
            border-color: var(--line);
        }

        .empty-state {
            padding: 14px;
            text-align: center;
            color: var(--muted);
            border: 1px dashed var(--line);
            border-radius: 16px;
            background: #fbfdff;
        }

        /* MODAL */
        .modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .55);
            display: none;
            align-items: flex-end;
            justify-content: center;
            z-index: 9999;
            padding: 12px;
        }

        .modal.open {
            display: flex;
        }

        .modal-sheet {
            width: 100%;
            max-width: 620px;
            background: #fff;
            border-radius: 24px 24px 18px 18px;
            box-shadow: 0 -10px 35px rgba(15, 23, 42, .22);
            overflow: hidden;
            animation: slideUp .18s ease-out;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        @keyframes slideUp {
            from { transform: translateY(18px); opacity: .8; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-handle {
            width: 48px;
            height: 5px;
            border-radius: 999px;
            background: #cbd5e1;
            margin: 10px auto 0;
        }

        .modal-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 16px;
            border-bottom: 1px solid var(--line);
        }

        .modal-head h3 {
            margin: 0 0 6px;
            font-size: 18px;
        }

        .modal-sub {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .close-btn {
            border: none;
            background: #f1f5f9;
            color: var(--text);
            width: 38px;
            height: 38px;
            border-radius: 12px;
            font-size: 18px;
            cursor: pointer;
            flex: 0 0 auto;
        }

        .modal-body {
            padding: 16px;
            overflow-y: auto;
        }

        .detail-list {
            display: grid;
            gap: 10px;
        }

        .detail-row {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 12px;
            background: #f8fafc;
            border: 1px solid var(--line);
            border-radius: 14px;
        }

        .detail-label {
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
        }

        .detail-value {
            color: var(--text);
            font-size: 15px;
            font-weight: 700;
            line-height: 1.7;
            word-break: break-word;
        }

        .detail-value.muted {
            color: var(--muted);
            font-weight: 600;
        }

        .type-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            width: fit-content;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .type-pill.green {
            background: #ecfdf5;
            color: #166534;
            border-color: #bbf7d0;
        }

        .type-pill.amber {
            background: #fffbeb;
            color: #92400e;
            border-color: #fde68a;
        }

        .hidden {
            display: none !important;
        }

        /* MOBILE TWEAKS */
        @media (min-width: 640px) {
            .page {
                padding: 16px;
            }

            .header {
                padding: 18px;
            }

            .form-grid {
                grid-template-columns: 1fr 1fr;
            }

            .field.span-2 {
                grid-column: span 2;
            }

            .tab-btn {
                min-width: 180px;
            }
        }
    </style>
</head>

<body>
@php
    $progressCollection = collect($progress ?? []);
    $memorizationLogs = $progressCollection->where('type', 'memorization')->sortByDesc('created_at')->values();
    $reviewLogs = $progressCollection->where('type', 'big_review')->sortByDesc('created_at')->values();
@endphp

<div class="page">

    <a href="{{ route('dashboard') }}" class="back">⬅ العودة</a>

    <div class="header">
        <h2>📘 متابعة الطالب</h2>
        <p>👤 {{ $student->name }}</p>
        <p>📞 {{ $student->phone_number ?? 'لا يوجد رقم' }}</p>
    </div>

    @if(session('success'))
        <div class="flash">{{ session('success') }}</div>
    @endif

    <!-- TABS -->
    <div class="tabs">
        <button class="tab-btn active" onclick="showTab('new', this)">📘 الحفظ الجديد</button>
        <button class="tab-btn" onclick="showTab('review', this)">📊 المراجعة الكبرى</button>
        <button class="tab-btn" onclick="showTab('points', this)">⭐ النقاط</button>
    </div>

    <!-- NEW MEMORIZATION -->
    <div id="new" class="tab-content active">
        <div class="section-card">
            <div class="section-title">
                <h3>الحفظ الجديد</h3>
                <span class="count-badge">{{ $memorizationLogs->count() }}</span>
            </div>

            <form action="{{ route('student.follow.store', $student->id) }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="field span-2">
                        <label>السورة</label>
                        <input type="text" name="surah" placeholder="مثال: البقرة" value="{{ old('surah') }}">
                    </div>

                    <div class="field">
                        <label>من آية</label>
                        <input type="number" name="from_ayah" placeholder="1" value="{{ old('from_ayah') }}">
                    </div>

                    <div class="field">
                        <label>إلى آية</label>
                        <input type="number" name="to_ayah" placeholder="5" value="{{ old('to_ayah') }}">
                    </div>

                    <div class="field">
                        <label>العلامة</label>
                        <input type="number" name="score" placeholder="9" value="{{ old('score') }}">
                    </div>

                    <div class="field">
                        <label>الواجب المنزلي</label>
                        <input type="text" name="homework" placeholder="مثال: مراجعة الآيات 1-5 من سورة النبأ" value="{{ old('homework') }}">
                    </div>

                    <div class="field">
                        <label>المراجعة اليومية</label>
                        <input type="text" name="daily_review" placeholder="مثال: النبأ 4 - 10" value="{{ old('daily_review') }}">
                    </div>

                    <div class="field">
                        <label>علامة المراجعة</label>
                        <input type="number" name="review_score" placeholder="9" value="{{ old('review_score') }}">
                    </div>

                    <div class="field">
                        <label>واجب المراجعة</label>
                        <input type="text" name="review_homework" placeholder="" value="{{ old('review_homework') }}">
                    </div>

                    <div class="field span-2">
                        <label>ملاحظات</label>
                        <textarea name="notes" placeholder="أي ملاحظات مهمة...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="submit-btn">💾 حفظ الحفظ الجديد</button>
            </form>
        </div>

        <div class="section-card">
            <div class="section-title">
                <h3>سجل الحفظ الجديد</h3>
                <span class="count-badge">{{ $memorizationLogs->count() }}</span>
            </div>

            <div class="logs-wrap">
                @forelse($memorizationLogs as $item)
                    @php
                        $logData = [
                            'type' => $item->type,
                            'created_at' => optional($item->created_at)->format('Y-m-d H:i'),
                            'surah' => $item->surah,
                            'from_ayah' => $item->from_ayah,
                            'to_ayah' => $item->to_ayah,
                            'score' => $item->score,
                            'homework' => $item->homework,
                            'daily_review' => $item->daily_review,
                            'review_score' => $item->review_score,
                            'review_homework' => $item->review_homework,
                            'notes' => $item->notes,
                        ];
                    @endphp

                    <button type="button" class="log-item" data-log='@json($logData)'>
                        <div class="log-top">
                            <p class="log-title">📖 {{ $item->surah ?? 'بدون سورة' }}</p>
                            <span class="log-date">{{ optional($item->created_at)->format('Y-m-d') }}</span>
                        </div>

                        <div class="chips">
                            <span class="chip green">⭐ {{ $item->score ?? '-' }}</span>
                            <span class="chip gray">من {{ $item->from_ayah ?? '-' }} إلى {{ $item->to_ayah ?? '-' }}</span>
                            @if($item->homework)
                                <span class="chip blue">📚 الواجب</span>
                            @endif
                        </div>
                    </button>
                @empty
                    <div class="empty-state">لا يوجد تسجيلات للحفظ الجديد بعد.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- BIG REVIEW -->
    <div id="review" class="tab-content">
        <div class="section-card">
            <div class="section-title">
                <h3>المراجعة الكبرى</h3>
                <span class="count-badge">{{ $reviewLogs->count() }}</span>
            </div>

            <form action="{{ route('student.review.store', $student->id) }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="field span-2">
                        <label>المحفوظ خلال الأسبوع</label>
                        <input type="text" name="weekly_memorization" placeholder="مثال: سورة النبأ و العاديات...." value="{{ old('weekly_memorization') }}">
                    </div>

                    <div class="field">
                        <label>العلامة</label>
                        <input type="number" name="score" placeholder="8" value="{{ old('score') }}">
                    </div>

                    <div class="field">
                        <label>واجب المراجعة</label>
                        <input type="text" name="review_homework" placeholder="مثال: مراجعة سورة العاديات 2 - 8" value="{{ old('review_homework') }}">
                    </div>
                </div>

                <button type="submit" class="submit-btn review">💾 حفظ المراجعة الكبرى</button>
            </form>
        </div>

        <div class="section-card">
            <div class="section-title">
                <h3>سجل المراجعة الكبرى</h3>
                <span class="count-badge">{{ $reviewLogs->count() }}</span>
            </div>

            <div class="logs-wrap">
                @forelse($reviewLogs as $item)
                    @php
                        $logData = [
                            'type' => $item->type,
                            'created_at' => optional($item->created_at)->format('Y-m-d H:i'),
                            'weekly_memorization' => $item->weekly_memorization,
                            'score' => $item->score,
                            'review_homework' => $item->review_homework,
                        ];
                    @endphp

                    <button type="button" class="log-item" data-log='@json($logData)'>
                        <div class="log-top">
                            <p class="log-title">📗 {{ $item->weekly_memorization ?? 'بدون عنوان' }}</p>
                            <span class="log-date">{{ optional($item->created_at)->format('Y-m-d') }}</span>
                        </div>

                        <div class="chips">
                            <span class="chip amber">⭐ {{ $item->score ?? '-' }}</span>
                            @if($item->review_homework)
                                <span class="chip gray">📝 واجب المراجعة</span>
                            @endif
                        </div>
                    </button>
                @empty
                    <div class="empty-state">لا يوجد تسجيلات للمراجعة الكبرى بعد.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- POINTS -->
    <!-- POINTS -->

    <div id="points" class="tab-content">
        <div class="section-card">

            ```
            <div class="section-title">
                <h3>النقاط</h3>
            </div>

            <!-- Current Points Display -->
            <div class="points-box">
                <div class="points-value">
                    {{ $student->points ?? 0 }}
                </div>
                <div class="points-label">إجمالي النقاط</div>
            </div>

            <!-- Add Points Form -->
            <form method="POST" action="{{ route('students.addPoints', $student->id) }}" class="points-form">
                @csrf

                <input type="number"
                       name="points"
                       placeholder="أضف نقاط..."
                       min="1"
                       required
                       class="points-input">

                <button type="submit" class="points-btn">
                    ➕ إضافة نقاط
                </button>
            </form>

        </div>
        ```

    </div>

    <style>
        .points-box {
            background: linear-gradient(135deg, #146c43, #0b3a2a);
            color: white;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(20,108,67,0.2);
        }

        .points-value {
            font-size: 42px;
            font-weight: 900;
        }

        .points-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .points-form {
            display: flex;
            gap: 10px;
        }

        .points-input {
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
        }

        .points-btn {
            padding: 12px 16px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #0b3a2a, #146c43);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .points-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        /* Mobile */
        @media (max-width: 550px) {
            .points-form {
                flex-direction: column;
            }

            .points-btn {
                width: 100%;
            }
        }
    </style>


</div>

<!-- MODAL -->
<div id="modal" class="modal" aria-hidden="true">
    <div class="modal-sheet" role="dialog" aria-modal="true">
        <div class="modal-handle"></div>

        <div class="modal-head">
            <div>
                <h3 id="modal-title">تفاصيل السجل</h3>
                <div class="modal-sub" id="modal-subtitle"></div>
            </div>
            <button type="button" class="close-btn" onclick="closeModal()">✕</button>
        </div>

        <div class="modal-body" id="modal-body"></div>
    </div>
</div>

<script>
    function showTab(tab, el) {
        document.querySelectorAll('.tab-content').forEach(e => e.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(e => e.classList.remove('active'));

        const target = document.getElementById(tab);
        if (target) target.classList.add('active');
        if (el) el.classList.add('active');
    }

    function escapeHtml(value) {
        if (value === null || value === undefined || value === '') return '-';
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function detailRow(label, value) {
        return `
            <div class="detail-row">
                <div class="detail-label">${escapeHtml(label)}</div>
                <div class="detail-value ${value === '-' ? 'muted' : ''}">${escapeHtml(value)}</div>
            </div>
        `;
    }

    function openModal(item) {
        const title = document.getElementById('modal-title');
        const subtitle = document.getElementById('modal-subtitle');
        const body = document.getElementById('modal-body');

        let typeLabel = 'سجل';
        let pillClass = 'type-pill';

        if (item.type === 'memorization') {
            typeLabel = 'الحفظ الجديد';
            pillClass += ' green';
        } else if (item.type === 'big_review') {
            typeLabel = 'المراجعة الكبرى';
            pillClass += ' amber';
        }

        title.innerHTML = `<span class="${pillClass}">${escapeHtml(typeLabel)}</span>`;
        subtitle.textContent = item.created_at ? `📅 ${item.created_at}` : '';

        let content = `<div class="detail-list">`;
        content += detailRow('تاريخ الإنشاء', item.created_at ?? '-');

        if (item.type === 'memorization') {
            content += detailRow('السورة', item.surah);
            content += detailRow('من آية', item.from_ayah);
            content += detailRow('إلى آية', item.to_ayah);
            content += detailRow('العلامة', item.score);
            content += detailRow('الواجب المنزلي', item.homework);
            content += detailRow('المراجعة اليومية', item.daily_review);
            content += detailRow('علامة المراجعة', item.review_score);
            content += detailRow('واجب المراجعة', item.review_homework);
            content += detailRow('ملاحظات', item.notes);
        } else if (item.type === 'big_review') {
            content += detailRow('المحفوظ خلال الأسبوع', item.weekly_memorization);
            content += detailRow('العلامة', item.score);
            content += detailRow('واجب المراجعة', item.review_homework);
        } else {
            content += detailRow('البيان', 'نوع غير معروف');
        }

        content += `</div>`;
        body.innerHTML = content;

        const modal = document.getElementById('modal');
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeModal() {
        const modal = document.getElementById('modal');
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
    }

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.log-item');
        if (btn && btn.dataset.log) {
            try {
                const data = JSON.parse(btn.dataset.log);
                openModal(data);
            } catch (error) {
                console.error('Invalid log data', error);
            }
        }

        if (e.target.id === 'modal') {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeModal();
    });
</script>

</body>
</html>
