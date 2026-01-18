@props(['type'])
@if (session()->has($type))
    @if ($type == 'error')
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <span>{!! session()->get($type) !!}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                X
            </button>
        </div>
    @else
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <span>{!! session()->get($type) !!}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                X
            </button>
        </div>
    @endif
@endif
