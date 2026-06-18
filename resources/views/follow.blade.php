<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>متابعة الطالب</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/follow.css') }}">

</head>

<body>

    <a href="{{ route('dashboard') }}" class="back">⬅ العودة</a>

    <!-- HEADER -->
    <div class="header">
        <h2>📘 متابعة الطالب</h2>
        <p>👤 {{ $student->name }} | 📞 {{ $student->phone_number ?? 'لا يوجد رقم' }}</p>
    </div>

    <!-- FORM -->
    <form action="{{ route('student.follow.store', $student->id) }}" method="POST"> @csrf

        <div class="grid">
            <div>
                <label>الجزء</label>
                <input type="number" name="part_number">
            </div>
            <div>
                <label>السورة</label>
                <input type="text" name="surah" placeholder="مثال: البقرة">
            </div>

            <div>
                <label>من آية</label>
                <input type="number" name="from_ayah">
            </div>

            <div>
                <label>إلى آية</label>
                <input type="number" name=" to_ayah">
            </div>

            <div>
                <label>عدد الآيات</label>
                <input type="number" name="ayah_count">
            </div>
            <div>
                <label>العلامة</label>
                <input type="number" name="score" placeholder="مثال: 85">
            </div>
        </div>

        <button type="submit">💾 حفظ التقدم</button>

    </form>

    <!-- HISTORY -->
    <div class="card">
        <div class="title">📊 سجل التقدم</div>

        @forelse($progress as $item)

        <div style="
            background:#f8fafc;
            padding:12px;
            border-radius:12px;
            margin-bottom:10px;
            border-right:4px solid #22c55e;
        ">

            <strong>📖 {{ $item->surah }}</strong>
            <div style="font-size:14px; color:#555; margin-top:5px;">
                من آية {{ $item->from_ayah }}
                إلى آية {{ $item->to_ayah }}
            </div>

            <div style="font-size:13px; color:#777; margin-top:5px;">
                ⭐ العلامة: {{ $item->score ?? '-' }} |
                📦 الجزء: {{ $item->part_number ?? '-' }}
            </div>

            <small style="color:#999;">
                🕒 {{ $item->created_at->format('Y-m-d H:i') }}
            </small>

        </div>

        @empty

        <p style="color:#777">لا يوجد تسجيلات بعد.</p>

        @endforelse
    </div>

</body>

</html>