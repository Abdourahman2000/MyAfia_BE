@props(['title' => 'Home', 'type' => 'normal'])
@if ($type == 'active')
    <li class="breadcrumb-item"><a href="javascript:void(0);">{{ $title }}</a></li>
@else
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endif
