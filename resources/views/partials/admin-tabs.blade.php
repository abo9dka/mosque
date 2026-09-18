@php
    $active = $active ?? '';
@endphp
<div class="admin-tabs">
    <a href="{{ route('admin.dashboard') }}" class="admin-tab {{ $active === 'dashboard' ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line"></i> الإحصائيات
    </a>
    <a href="{{ route('admin.teachers.index') }}" class="admin-tab {{ $active === 'teachers' ? 'active' : '' }}">
        <i class="fa-solid fa-chalkboard-user"></i> الأساتذة
    </a>
    <a href="{{ route('admin.parents.index') }}" class="admin-tab {{ $active === 'parents' ? 'active' : '' }}">
        <i class="fa-solid fa-users"></i> أولياء الأمور
    </a>
    <a href="{{ route('admin.activities.index') }}" class="admin-tab {{ $active === 'activities' ? 'active' : '' }}">
        <i class="fa-solid fa-calendar-days"></i> إدارة النشاطات
    </a>
    <a href="{{ route('admin.schedule.index') }}" class="admin-tab {{ $active === 'schedule' ? 'active' : '' }}">
        <i class="fa-solid fa-list-check"></i> الجدول الأسبوعي
    </a>
</div>
