@props(['title' => 'Default title', 'type' => 'normal'])
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div class="my-auto">
        <h5 class="page-title fs-21 mb-1">{{ $title }}</h5>
        <nav>
            <ol class="breadcrumb mb-0">
                {{ $slot }}
            </ol>
        </nav>
    </div>

    @if ($type == 'normal')
        <div class="btn-list">
            <a href="#" class="mb-4" style="margin: 0">
                <button class="btn btn-primary btn-wave label-btn" style="margin:0; padding:.3rem 3rem">
                    <i class="ri-edit-line label-btn-icon me-2"></i>
                    Create
                </button>
            </a>
        </div>
    @endif

    @if ($type == 'Retour')
        <div>
            <button
                style="padding:5px 15px; background:#f61a1aff; color:white; border:none; cursor:pointer; border-radius:15px;"
                onmouseover="this.style.backgroundColor='#cc0808ff'"
                onmouseout="this.style.backgroundColor='#f61a1aff'"
            >
                Retour
            </button>

        </div>
    @endif

</div>
<!-- Page Header Close -->
