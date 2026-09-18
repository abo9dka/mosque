@php
    $todayName = \App\Support\ArabicDate::dayName(now()->dayOfWeek);
@endphp
<div class="card" style="margin-bottom: 14px;">
    <div class="section-title">
        <span><i class="fa-solid fa-list-check"></i> برنامج اليوم — {{ $todayName }}</span>
    </div>

    @if($todayScheduleItems->isEmpty())
        <div class="empty-state">لم يُضَف برنامج ليوم {{ $todayName }} بعد.</div>
    @else
        <div class="today-schedule-timeline">
            @foreach($todayScheduleItems as $item)
                <div class="today-schedule-step">
                    <div class="step-num">{{ $loop->iteration }}</div>
                    <div class="step-text">{{ $item->content }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
