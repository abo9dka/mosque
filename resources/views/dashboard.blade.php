<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>لوحة تحكم المسجد</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <style>

    </style>
</head>

<body>

    <div class="navbar">
        <div class="logo">
            🕌 <span>نظام المسجد</span>
        </div>
        <div class="user-box">
            <span>👋 {{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">خروج</button>
            </form>
        </div>
    </div>

    <div class="hero-poem">
        <div>لا يصنع الأبطال إلا في مساجدنا الفساح</div>
        <div>في روضة القرآن في ظل الأحاديث الصحاح</div>
        <div>شعب بغير عقيدة ورق تذريه الرياح</div>
        <div>من خان حي على الصلاة يخون حي على الكفاح</div>
    </div>

    <div class="container">

        <div class="stats">
            <a href="{{ route('dashboard', ['filter' => 'all']) }}" class="stat {{ request('filter') == 'all' || !request('filter') ? 'active' : '' }}">
                <h4>عدد الطلاب</h4>
                <h2>{{ count($students) }}</h2>
            </a>
            <a href="{{ route('dashboard', ['filter' => 'حاضر']) }}" class="stat {{ request('filter') == 'حاضر' ? 'active' : '' }}">
                <h4>الحضور اليوم</h4>
                <h2>{{ $presentCount }}</h2>
            </a>
            <a href="{{ route('dashboard', ['filter' => 'غائب']) }}" class="stat {{ request('filter') == 'غائب' ? 'active' : '' }}">
                <h4>الغياب اليوم</h4>
                <h2>{{ $absentCount }}</h2>
            </a>
            <a href="{{ route('dashboard', ['filter' => 'متأخر']) }}" class="stat {{ request('filter') == 'متأخر' ? 'active' : '' }}">
                <h4>المتأخرين اليوم</h4>
                <h2>{{ $lateCount }}</h2>
            </a>
        </div>

        <div class="header" id="students">
            <h2>👨‍🎓 إدارة الطلاب</h2>
            <div class="btn-group">
                <a href="{{ route('attendance') }}" class="btn blue">
                    📅 تسجيل الحضور
                </a>
                <a href="{{ route('student.create') }}" class="btn">
                    ➕ إضافة طالب
                </a>
            </div>
        </div>

        @if(count($students))
        <div class="grid" id="studentsGrid">
            @foreach($students as $student)
            <div class="card fade">
                <div class="avatar">👦</div>
                <div class="name">{{ $student->name }}</div>
                <div class="phone">
                    <i class="fa-solid fa-phone" style="font-size: 12px;"></i>
                    {{ $student->phone_number ?? 'غير مسجل' }}
                </div>

                <div class="actions">
                    <a href="{{ route('student.follow', $student->id) }}" class="btn2 follow">
                        📝 متابعة الطالب
                    </a>
                    <a href="{{ route('student.edit', $student->id) }}" class="btn2 edit">
                        ✏️ تعديل
                    </a>
                    <form method="POST" action="{{ route('student.delete', $student->id) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطالب؟')" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn2 delete">
                            🗑️ حذف
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty">
            لا يوجد طلاب حالياً في النظام 🕌
        </div>
        @endif

    </div>

    <script>
        // تأثير الظهور التدريجي للبطاقات بشكل ناعم جداً
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.fade');
            cards.forEach((c, i) => {
                setTimeout(() => {
                    c.classList.add('show');
                }, i * 60); // تسريع التأثير قليلاً ليعطي شعوراً بالسلاسة
            });
        });

        // النزول التلقائي السلس عند استخدام الفلتر
        window.addEventListener('load', () => {
            const url = new URL(window.location);
            if (url.searchParams.get('filter')) {
                setTimeout(() => {
                    const target = document.getElementById('students');
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                }, 400);
            }
        });
    </script>
</body>

</html>