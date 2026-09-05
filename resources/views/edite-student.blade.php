<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>تعديل الطالب</title>

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

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
            background: var(--surface);
            border: 1px solid var(--border);
            padding: 28px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
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

        <h2><i class="fa-solid fa-pen"></i> تعديل بيانات الطالب</h2>

        <form method="POST" action="{{ route('student.update', $student->id) }}">

            @csrf
            @method('PUT')

            <div class="field">
                <label>اسم الطالب</label>
                <input type="text" name="name" value="{{ old('name', $student->name) }}" required>
                @error('name')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label>ولي الأمر</label>
                <select name="parent_id" id="parent-select">
                    <option value=""></option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" @selected(old('parent_id', $student->parent_id) == $parent->id)>{{ $parent->name }} — {{ $parent->phone }}</option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label>الصف</label>
                <input type="text" name="grade" value="{{ old('grade', $student->grade) }}">
                @error('grade')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label>عنوان السكن</label>
                <input type="text" name="address" value="{{ old('address', $student->address) }}">
                @error('address')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">
                <i class="fa-solid fa-floppy-disk"></i> حفظ التعديلات
            </button>

        </form>

        <a href="{{ route('dashboard') }}" class="back"><i class="fa-solid fa-arrow-right"></i> الرجوع للوحة التحكم</a>

    </div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#parent-select', {
        create: false,
        placeholder: 'ابحث عن ولي الأمر بالاسم أو رقم الهاتف...',
        maxOptions: 1000,
    });
</script>

</body>

</html>
