@if(!empty($items) && is_array($items))
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
    @foreach($items as $i => $it)
      @if(!empty($it['url']) && $i < count($items)-1)
        <li class="breadcrumb-item"><a href="{{ $it['url'] }}">{{ $it['label'] }}</a></li>
      @else
        <li class="breadcrumb-item active" aria-current="page">{{ $it['label'] }}</li>
      @endif
    @endforeach
  </ol>
</nav>
@endif
