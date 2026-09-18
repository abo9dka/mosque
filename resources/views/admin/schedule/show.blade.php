<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>برنامج يوم {{ $dayName }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-256.png') }}">

    <style>
        .day-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .day-header .day-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius);
            background: var(--accent-soft);
            color: var(--accent-strong);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .day-header h2 {
            margin: 0;
            font-size: var(--text-xl);
        }

        .day-header p {
            margin: 2px 0 0;
            font-size: var(--text-sm);
            color: var(--ink-muted);
        }

        .add-step-form {
            display: flex;
            gap: 10px;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .add-step-form .field {
            flex: 1;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <div class="page">

        <a href="{{ route('admin.schedule.index') }}" class="back-link"><i class="fa-solid fa-arrow-right"></i> العودة للجدول الأسبوعي</a>

        <div class="day-header" style="margin-top: 14px;">
            <div class="day-icon"><i class="fa-solid fa-calendar-day"></i></div>
            <div>
                <h2>برنامج يوم {{ $dayName }}</h2>
                <p>رتّب أقسام برنامج هذا اليوم كما ستظهر للأستاذ وولي الأمر</p>
            </div>
        </div>

        @if(session('success'))
            <div class="flash"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        <div class="section-card">
            <div class="section-title"><i class="fa-solid fa-list-check"></i> أقسام البرنامج</div>

            @if($items->isEmpty())
                <div class="empty-state">لم تُضَف أي أقسام لبرنامج هذا اليوم بعد.</div>
            @else
                <div class="schedule-list" id="scheduleList">
                    @foreach($items as $item)
                        <div class="schedule-item">
                            <div class="step-num">{{ $loop->iteration }}</div>

                            <div class="step-text" id="text-{{ $item->id }}">{{ $item->content }}</div>

                            <form class="step-edit-form hidden" id="editform-{{ $item->id }}" method="POST" action="{{ route('admin.schedule.items.update', $item->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="text" name="content" value="{{ $item->content }}" required maxlength="500">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-check"></i></button>
                                <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit({{ $item->id }})"><i class="fa-solid fa-xmark"></i></button>
                            </form>

                            <div class="step-actions" id="actions-{{ $item->id }}">
                                <button type="button" onclick="toggleEdit({{ $item->id }})" title="تعديل">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.schedule.items.move', $item->id) }}">
                                    @csrf
                                    <input type="hidden" name="direction" value="up">
                                    <button type="submit" title="نقل للأعلى" {{ $loop->first ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-chevron-up"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.schedule.items.move', $item->id) }}">
                                    @csrf
                                    <input type="hidden" name="direction" value="down">
                                    <button type="submit" title="نقل للأسفل" {{ $loop->last ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.schedule.items.destroy', $item->id) }}" onsubmit="return confirm('حذف هذا القسم؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="danger" title="حذف">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <form class="add-step-form" method="POST" action="{{ route('admin.schedule.items.store', $day) }}">
                @csrf
                <div class="field">
                    <input type="text" name="content" placeholder="مثال: 10 دقائق من كتاب الجزء الرشيدي" required maxlength="500" value="{{ old('content') }}">
                    @error('content')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> إضافة
                </button>
            </form>
        </div>

    </div>

<script>
    function toggleEdit(id) {
        document.getElementById('text-' + id).classList.toggle('hidden');
        document.getElementById('editform-' + id).classList.toggle('hidden');
        document.getElementById('actions-' + id).classList.toggle('hidden');
    }
</script>

</body>
</html>
