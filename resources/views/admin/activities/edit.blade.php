<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تعديل نشاط</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-256.png') }}">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 440px;
        }

        h2 {
            text-align: center;
            color: var(--ink);
            font-weight: 800;
            font-size: var(--text-xl);
            margin: 0 0 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        h2 i {
            color: var(--accent);
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 14px;
            color: var(--ink-muted);
            text-decoration: none;
            font-weight: 700;
            font-size: var(--text-sm);
        }

        .back:hover {
            color: var(--accent);
        }
    </style>
</head>
<body>

    <div class="card">
        <h2><i class="fa-solid fa-pen"></i> تعديل النشاط</h2>

        <form method="POST" action="{{ route('admin.activities.update', $activity->id) }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label>اسم النشاط</label>
                <input type="text" name="title" value="{{ old('title', $activity->title) }}" required>
                @error('title')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>تفاصيل النشاط (اختياري)</label>
                <textarea name="description" placeholder="أي تفاصيل إضافية عن النشاط...">{{ old('description', $activity->description) }}</textarea>
                @error('description')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>تاريخ النشاط</label>
                <input type="date" name="date" value="{{ old('date', $activity->date->format('Y-m-d')) }}" required>
                @error('date')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>عدد الطلاب المشتركين</label>
                <input type="number" name="students_count" min="0" value="{{ old('students_count', $activity->students_count) }}" required>
                @error('students_count')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fa-solid fa-floppy-disk"></i> حفظ التعديلات
            </button>
        </form>

        <a href="{{ route('admin.activities.index') }}" class="back"><i class="fa-solid fa-arrow-right"></i> الرجوع للقائمة</a>
    </div>

</body>
</html>
