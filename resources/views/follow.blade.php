<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>متابعة الطالب</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-256.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    <style>
        .page {
            max-width: 920px;
        }

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

        /* TABS */
        .tabs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 4px;
            margin-bottom: 14px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .tabs::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            min-width: 140px;
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--ink);
            border-radius: var(--radius);
            padding: 11px 14px;
            font-family: inherit;
            font-weight: 700;
            font-size: var(--text-sm);
            cursor: pointer;
            touch-action: manipulation;
        }

        .tab-btn.active {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* FORM GRID */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .field.span-2 {
            grid-column: 1 / -1;
        }

        /* POINTS */
        .points-box {
            background: var(--accent-strong);
            color: white;
            border-radius: var(--radius-lg);
            padding: 22px;
            text-align: center;
            margin-bottom: 16px;
            border-top: 3px solid var(--gold);
        }

        .points-value {
            font-size: 38px;
            font-weight: 900;
            color: var(--gold);
        }

        .points-label {
            font-size: var(--text-sm);
            opacity: .85;
        }

        .points-form {
            display: flex;
            gap: 10px;
        }

        .points-form input {
            flex: 1;
        }

        /* MOBILE TWEAKS */
        @media (min-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }

            .field.span-2 {
                grid-column: span 2;
            }

            .tab-btn {
                min-width: 170px;
            }
        }

        @media (max-width: 550px) {
            .points-form {
                flex-direction: column;
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

    <a href="{{ route('dashboard') }}" class="back-link"><i class="fa-solid fa-arrow-right"></i> العودة</a>

    <div class="header card">
        <h2 style="margin:0 0 8px; font-size: var(--text-xl); display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-book-open" style="color:var(--accent)"></i> متابعة الطالب
        </h2>
        <p><i class="fa-solid fa-user"></i> {{ $student->name }}</p>
        <p><i class="fa-solid fa-phone"></i> {{ $student->phone_number ?? 'لا يوجد رقم' }}</p>
    </div>

    @if(session('success'))
        <div class="flash"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
    @endif

    <!-- TABS -->
    <div class="tabs">
        <button class="tab-btn active" onclick="showTab('new', this)"><i class="fa-solid fa-book-open"></i> الحفظ الجديد</button>
        <button class="tab-btn" onclick="showTab('review', this)"><i class="fa-solid fa-rotate"></i> المراجعة الكبرى</button>
        <button class="tab-btn" onclick="showTab('points', this)"><i class="fa-solid fa-star"></i> النقاط</button>
    </div>

    <!-- NEW MEMORIZATION -->
    <div id="new" class="tab-content active">
        <div class="section-card">
            <div class="section-title">
                <span>الحفظ الجديد</span>
                <span class="count-badge">{{ $memorizationLogs->count() }}</span>
            </div>

            <form action="{{ route('student.follow.store', $student->id) }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="field span-2">
                        <label>السورة</label>
                        <select name="surah" id="surah-select">
                            <option value=""></option>
                            @foreach($surahs as $surah)
                                <option
                                    value="{{ $surah['name'] }}"
                                    data-number="{{ $surah['number'] }}"
                                    data-ayahs="{{ $surah['ayahs'] }}"
                                    @selected(old('surah') === $surah['name'])
                                >{{ $surah['number'] }}. {{ $surah['name'] }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="surah_number" id="surah_number" value="{{ old('surah_number') }}">
                        @error('surah')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label>من آية</label>
                        <select name="from_ayah" id="from-ayah-select" disabled></select>
                        @error('from_ayah')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field">
                        <label>إلى آية</label>
                        <select name="to_ayah" id="to-ayah-select" disabled></select>
                        @error('to_ayah')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
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

                <button type="submit" class="btn btn-primary btn-block" style="margin-top:12px">
                    <i class="fa-solid fa-floppy-disk"></i> حفظ الحفظ الجديد
                </button>
            </form>
        </div>

        <div class="section-card">
            <div class="section-title">
                <span>سجل الحفظ الجديد</span>
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
                            'failed' => $item->isFailed(),
                        ];
                    @endphp

                    <button type="button" class="log-item" data-log='@json($logData)'>
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
                                        <span><span class="note-label">ملاحظات</span>{{ $item->notes }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
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
                <span>المراجعة الكبرى</span>
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

                <button type="submit" class="btn btn-info btn-block" style="margin-top:12px">
                    <i class="fa-solid fa-floppy-disk"></i> حفظ المراجعة الكبرى
                </button>
            </form>
        </div>

        <div class="section-card">
            <div class="section-title">
                <span>سجل المراجعة الكبرى</span>
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
                    </button>
                @empty
                    <div class="empty-state">لا يوجد تسجيلات للمراجعة الكبرى بعد.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- POINTS -->
    <div id="points" class="tab-content">
        <div class="section-card">

            <div class="section-title">
                <span>النقاط</span>
            </div>

            <div class="points-box">
                <div class="points-value">{{ $student->points ?? 0 }}</div>
                <div class="points-label">إجمالي النقاط</div>
            </div>

            <form method="POST" action="{{ route('students.addPoints', $student->id) }}" class="points-form">
                @csrf
                <input type="number" name="points" placeholder="أضف نقاط..." min="1" required>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> إضافة
                </button>
            </form>

            <button type="button" class="btn btn-danger btn-block" style="margin-top:10px" onclick="openSubtractPointsModal()">
                <i class="fa-solid fa-minus"></i> خصم نقاط
            </button>

        </div>

    </div>

    <!-- SUBTRACT POINTS MODAL -->
    <div id="subtractPointsModal" class="modal" aria-hidden="true">
        <div class="modal-sheet" role="dialog" aria-modal="true">
            <div class="modal-handle"></div>

            <div class="modal-head">
                <div>
                    <h3>خصم نقاط</h3>
                    <div class="modal-sub">كم عدد النقاط التي تريد خصمها من الطالب؟</div>
                </div>
                <button type="button" class="modal-close" onclick="closeSubtractPointsModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('students.subtractPoints', $student->id) }}" class="points-form">
                    @csrf

                    <input type="number"
                           name="points"
                           placeholder="عدد النقاط المراد خصمها..."
                           min="1"
                           required
                           autofocus>

                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-minus"></i> خصم
                    </button>
                </form>
            </div>
        </div>
    </div>

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
            <button type="button" class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <div class="modal-body" id="modal-body"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    (function () {
        const QURAN_SURAHS = @json($surahs);

        const surahSelectEl = document.getElementById('surah-select');
        const surahNumberInput = document.getElementById('surah_number');
        const fromSelectEl = document.getElementById('from-ayah-select');
        const toSelectEl = document.getElementById('to-ayah-select');

        if (!surahSelectEl || !fromSelectEl || !toSelectEl) return;

        const MAX_AYAHS_IN_A_SURAH = 300; // أطول سورة (البقرة) 286 آية

        function buildAyahOptions(count, min) {
            const opts = [];
            for (let i = (min || 1); i <= count; i++) {
                opts.push({ value: String(i), text: String(i) });
            }
            return opts;
        }

        // كِلا حقلي الآيات يُنشآن فورًا (بمظهر Tom Select الموحّد) ويبقيان
        // معطّلين حتى تُختار السورة، بدل التحوّل من/إلى select عادي كل مرة.
        const tsFrom = new TomSelect(fromSelectEl, {
            create: false,
            placeholder: 'اختر السورة أولاً',
            valueField: 'value',
            labelField: 'text',
            searchField: ['text'],
            options: [],
            maxOptions: MAX_AYAHS_IN_A_SURAH,
            onChange: function (value) {
                const fromVal = parseInt(value, 10) || 1;
                rebuildToOptions(currentAyahCount, fromVal);
            },
        });
        tsFrom.disable();

        const tsTo = new TomSelect(toSelectEl, {
            create: false,
            placeholder: 'اختر السورة أولاً',
            valueField: 'value',
            labelField: 'text',
            searchField: ['text'],
            options: [],
            maxOptions: MAX_AYAHS_IN_A_SURAH,
        });
        tsTo.disable();

        let currentAyahCount = 0;

        function rebuildToOptions(ayahCount, minFrom, presetTo) {
            tsTo.clear(true);
            tsTo.clearOptions();
            tsTo.addOptions(buildAyahOptions(ayahCount, minFrom));
            tsTo.refreshOptions(false);

            if (presetTo && Number(presetTo) >= minFrom) {
                tsTo.setValue(String(presetTo), true);
            }
        }

        function populateAyahSelects(ayahCount, presetFrom, presetTo) {
            currentAyahCount = ayahCount || 0;

            tsFrom.clear(true);
            tsFrom.clearOptions();
            tsTo.clear(true);
            tsTo.clearOptions();

            if (!currentAyahCount) {
                tsFrom.disable();
                tsTo.disable();
                tsFrom.control_input.placeholder = 'اختر السورة أولاً';
                tsTo.control_input.placeholder = 'اختر السورة أولاً';
                return;
            }

            tsFrom.addOptions(buildAyahOptions(currentAyahCount));
            tsFrom.refreshOptions(false);
            tsFrom.enable();
            tsTo.enable();
            tsFrom.control_input.placeholder = 'من آية';
            tsTo.control_input.placeholder = 'إلى آية';

            const initialFrom = presetFrom || 1;
            rebuildToOptions(currentAyahCount, initialFrom, presetTo);

            if (presetFrom) {
                tsFrom.setValue(String(presetFrom), true);
            }
        }

        const tsSurah = new TomSelect(surahSelectEl, {
            create: false,
            placeholder: 'ابحث عن السورة...',
            maxOptions: 114,
            onChange: function (value) {
                const opt = QURAN_SURAHS.find(s => s.name === value);
                surahNumberInput.value = opt ? opt.number : '';
                populateAyahSelects(opt ? opt.ayahs : 0);
            },
        });

        // إعادة بناء الحالة بعد فشل التحقق من الصحة (old())
        const oldSurah = @json(old('surah'));
        const oldFrom = @json(old('from_ayah'));
        const oldTo = @json(old('to_ayah'));

        if (oldSurah) {
            const opt = QURAN_SURAHS.find(s => s.name === oldSurah);
            if (opt) {
                tsSurah.setValue(oldSurah, true);
                surahNumberInput.value = opt.number;
                populateAyahSelects(opt.ayahs, oldFrom, oldTo);
            }
        }
    })();

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
        subtitle.innerHTML = item.created_at ? `<i class="fa-solid fa-calendar-days"></i> ${escapeHtml(item.created_at)}` : '';

        let content = `<div class="detail-list">`;
        content += detailRow('تاريخ الإنشاء', item.created_at ?? '-');

        if (item.type === 'memorization') {
            const hasScore = item.score !== null && item.score !== undefined && item.score !== '';
            content += detailRow('السورة', item.surah);
            content += detailRow('من آية', item.from_ayah);
            content += detailRow('إلى آية', item.to_ayah);
            content += detailRow('العلامة', item.score);
            content += detailRow('الحالة', hasScore ? (item.failed ? 'راسب — غير محتسب ضمن نسبة الحفظ' : 'ناجح') : '-');
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

    function openSubtractPointsModal() {
        const modal = document.getElementById('subtractPointsModal');
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
    }

    function closeSubtractPointsModal() {
        const modal = document.getElementById('subtractPointsModal');
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

        if (e.target.id === 'subtractPointsModal') {
            closeSubtractPointsModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
            closeSubtractPointsModal();
        }
    });
</script>

</body>
</html>
