@if ($paginator->hasPages())
    <nav aria-label="Page navigation" class="pagination-style-1 mt-4 mb-5">
        <ul class="pagination mb-0">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0);" aria-disabled="true">
                        <i class="ri-arrow-left-s-line align-middle"></i>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')">
                        <i class="ri-arrow-left-s-line align-middle"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <a class="page-link" href="javascript:void(0);">
                            <i class="bi bi-three-dots"></i>
                        </a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <a class="page-link" href="javascript:void(0);">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')">
                        <i class="ri-arrow-right-s-line align-middle"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0);" aria-disabled="true">
                        <i class="ri-arrow-right-s-line align-middle"></i>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif
