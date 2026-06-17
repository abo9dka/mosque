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
    <form method="POST" action="#">
        @csrf

        <div class="grid">

            <div>
                <label>السورة</label>
                <input type="text" name="surah" placeholder="مثال: البقرة">
            </div>

            <div>
                <label>من آية</label>
                <input type="number" name="ayah_from">
            </div>

            <div>
                <label>إلى آية</label>
                <input type="number" name="ayah_to">
            </div>

            <div>
                <label>عدد الآيات</label>
                <input type="number" name="ayah_count">
            </div>

        </div>

        <button type="submit">💾 حفظ التقدم</button>

    </form>

    <!-- HISTORY -->
    <div class="card">
        <div class="title">📊 سجل التقدم</div>

        <p style="color:#777">
            سيتم عرض التسميعات السابقة هنا بشكل مرتب (سورة + آيات + تاريخ).
        </p>

        <span class="badge">جاهز للتطوير لاحقاً</span>
    </div>

</body>

</html>