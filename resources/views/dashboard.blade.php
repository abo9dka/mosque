<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>لوحة تحكم المسجد</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">

        <div class="logo">
            🕌 نظام المسجد
        </div>

        <div class="user-box">

            👋 {{ Auth::user()->name }}

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout">خروج</button>
            </form>

        </div>

    </div>

    <div class="container">

        <!-- STATS -->
        <div class="stats">

            <a href="{{ route('dashboard', ['filter' => 'all']) }}" class="stat">
                <h4>عدد الطلاب</h4>
                <h2>{{ count($students) }}</h2>
            </a>
            <a href="{{ route('dashboard', ['filter' => 'حاضر']) }}" class="stat">
                <h4>الحضور اليوم</h4>
                <h2>{{ $presentCount }}</h2>
            </a>

            <a href="{{ route('dashboard', ['filter' => 'غائب']) }}" class="stat">
                <h4>الغياب اليوم</h4>
                <h2>{{ $absentCount }}</h2>
            </a>

            <a href="{{ route('dashboard', ['filter' => 'متأخر']) }}" class="stat">
                <h4>المتأخرين اليوم</h4>
                <h2>{{ $lateCount }}</h2>
            </a>

        </div>
        <!-- HEADER -->
        <div class="header" id="students">

            <h2>👨‍🎓 الطلاب</h2>

            <div class="btn-group">

                <!-- زر تسجيل الحضور -->
                <a href="{{ route('attendance') }}" class="btn blue">
                    📅 تسجيل الحضور
                </a>

                <!-- زر إضافة طالب -->
                <a href="{{ route('student.create') }}" class="btn">
                    ➕ إضافة طالب
                </a>

            </div>

        </div>

        <!-- CONTENT -->

        @if(count($students))

        <div class="grid">

            @foreach($students as $student)

            <div class="card fade">

                <div class="avatar">👦</div>

                <div class="name">{{ $student->name }}</div>

                <div class="phone">📞 {{ $student->phone_number ?? 'غير مسجل' }}</div>

                <div class="actions">

                    <a href="{{ route('student.follow', $student->id) }}" class="btn2 follow">
                        📝 متابعة
                    </a>

                    <a href="{{ route('student.edit', $student->id) }}" class="btn2 edit">
                        ✏️ تعديل
                    </a>

                    <form method="POST" action="{{ route('student.delete', $student->id) }}" onsubmit="return confirm('هل أنت متأكد؟')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn2 delete" style="background:#dc3545;color:white;">
                            🗑️ حذف
                        </button>

                    </form>

                </div>

            </div>

            @endforeach

        </div>

        @else

        <div class="empty">
            لا يوجد طلاب حالياً 🕌
        </div>

        @endif

    </div>

    <script>
        const cards = document.querySelectorAll('.fade');

        cards.forEach((c, i) => {
            setTimeout(() => {
                c.classList.add('show');
            }, i * 100);
        });



        window.addEventListener('load', () => {

            const url = new URL(window.location);

            if (url.searchParams.get('filter')) {

                setTimeout(() => {

                    window.scrollTo({
                        top: document.getElementById('students').offsetTop - 100,
                        behavior: 'smooth'
                    });

                }, 500);

            }

        });
    </script>

</body>

</html>