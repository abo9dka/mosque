@php
    $title = $title ?? 'نظام المسجد';
@endphp
<div class="navbar">
    <div class="logo">
        <i class="fa-solid fa-mosque"></i>
        <span>{{ $title }}</span>
    </div>
    <div class="user-box">
        <span class="user-name"><i class="fa-regular fa-circle-user"></i> {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">خروج</button>
        </form>
    </div>
</div>
