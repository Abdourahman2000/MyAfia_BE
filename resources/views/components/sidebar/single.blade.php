@props(['title', 'icon' => 'ti-home-2', 'badge' => false, 'link' => '#'])
<li class="slide">
    <a href="{{ $link }}" class="side-menu__item">
        <i class="ti ti-{{ $icon }} side-menu__icon"></i>
        <span class="side-menu__label">{{ $title }}</span>
        @if ($badge != false)
            <span class="badge bg-success ms-auto menu-badge">{{ $badge }}</span>
        @endif
    </a>
</li>
