@props(['title', 'icon', 'sub' => false])
<li class="slide has-sub">
    <a href="javascript:void(0);" class="side-menu__item">
        <i class="ti ti-{{ $icon }} side-menu__icon"></i>
        <span class="side-menu__label">{{ $title }}</span>
        <i class="fe fe-chevron-right side-menu__angle"></i>
    </a>
    <ul class="slide-menu child1">
        <li class="slide side-menu__label1">
            <a href="javascript:void(0);">{{ $title }}</a>
        </li>
        {{ $slot }}
    </ul>
</li>