<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تعديل ولي أمر</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

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
            max-width: 420px;
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
        <h2><i class="fa-solid fa-pen"></i> تعديل بيانات ولي الأمر</h2>

        <form method="POST" action="{{ route('admin.parents.update', $parent->id) }}">
            @csrf
            @method('PUT')

            <div class="field">
                <label>اسم ولي الأمر</label>
                <input type="text" name="name" value="{{ old('name', $parent->name) }}" required>
                @error('name')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone', $parent->phone) }}" inputmode="numeric" required>
                @error('phone')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>كلمة مرور جديدة</label>
                <input type="text" name="password" placeholder="اتركه فارغاً للإبقاء على كلمة المرور الحالية">
                <div class="field-hint">اتركه فارغاً إن كنت لا تريد تغيير كلمة المرور</div>
                @error('password')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fa-solid fa-floppy-disk"></i> حفظ التعديلات
            </button>
        </form>

        <a href="{{ route('admin.parents.index') }}" class="back"><i class="fa-solid fa-arrow-right"></i> الرجوع للقائمة</a>
    </div>

</body>
</html>
