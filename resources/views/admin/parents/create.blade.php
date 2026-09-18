<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إضافة ولي أمر</title>

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

        .box {
            width: 100%;
            max-width: 400px;
            padding: 32px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
        }

        h2 {
            text-align: center;
            margin: 0 0 24px;
            color: var(--ink);
            font-weight: 800;
            font-size: var(--text-xl);
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

    <div class="box">
        <h2><i class="fa-solid fa-user-plus"></i> إضافة ولي أمر</h2>

        <form method="POST" action="{{ route('admin.parents.store') }}">
            @csrf

            <div class="field">
                <label>اسم ولي الأمر</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" value="{{ old('phone') }}" inputmode="numeric" required>
                @error('phone')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>كلمة المرور</label>
                <input type="text" name="password" required>
                @error('password')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fa-solid fa-floppy-disk"></i> حفظ الحساب
            </button>
        </form>

        <a href="{{ route('admin.parents.index') }}" class="back"><i class="fa-solid fa-arrow-right"></i> الرجوع للقائمة</a>
    </div>

</body>
</html>
