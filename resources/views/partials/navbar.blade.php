@php
    $title =  'اقْرَأْ وَارْتَقِ';
@endphp
<div class="navbar">
    <div class="logo">
        <img src="{{ asset('images/logo-icon.png') }}" alt="شعار المعهد">
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
