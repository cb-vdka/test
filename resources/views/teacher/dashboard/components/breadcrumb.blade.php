<div class="page-header" style="margin: 0 !important;">
    <h3 class="fw-bold mb-3"></h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home">
            <a href="{{ route('teacher.teaching_schedule.index') }}">
                <i class="fas fa-home"></i>
            </a>
        </li>
        @if(isset($breadcrumb))
            @foreach($breadcrumb as $index => $item)
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    @if($item['url'])
                        <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
                    @else
                        <span>{{ $item['title'] }}</span>
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
</div>
