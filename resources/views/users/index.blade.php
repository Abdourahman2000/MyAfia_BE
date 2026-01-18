@php
    if (!function_exists('formatPhrase')) {
        function formatPhrase($text)
        {
            return ucwords(str_replace('_', ' ', $text));
        }
    }
@endphp
<x-app-layout>
    @section('title', 'MyAfia Liste des utilisateurs')

    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <x-breadcrumb.wrapper title="Liste des utilisateurs">
                    <x-breadcrumb.item title="Tableau de bord" />
                    <x-breadcrumb.item title="Liste des utilisateurs" type="active" />
                </x-breadcrumb.wrapper>

                <div>
                    <x-sessions.sessionAny />
                    <x-sessions.sessionAlert type="add" />
                    <x-sessions.sessionAlert type="delete" />
                    <x-sessions.sessionAlert type="edit" />
                    <x-sessions.sessionAlert type="error" />
                </div>

                <form action="{{ route('users.index') }}" method="get" class="col-xl-12 pagination_search mb-3">
                    <input type="text" class="form-control rounded-pill" id="input-rounded-pill" name="search"
                        value="{{ request('search') }}" placeholder="Rechercher par nom, email, type ou place">
                    <button type="submit"><i class="ti ti-search"></i></button>
                </form>

                <div class="box_of_item mb-4">
                    @foreach ($users as $user)
                        <div class="box_item">
                            <img src="{{ asset('assets/images/MyAfia_icon.jpg') }}" alt="user avatar" />
                            <h5>{{ $user->name }}</h5>
                            <div
                                style="display: flex; justify-content: center; align-items: center; width:100%; flex-direction:column; text-align:center;">
                                <span class="text-muted small">{{ $user->email }}</span>
                                <span>{{ $user->type }}</span>
                                @php
                                    $currentPlace = null;
                                    if ($user->place_id && isset($places)) {
                                        $currentPlace = $places->find($user->place_id);
                                    }
                                @endphp
                                @if($currentPlace)
                                    <span>{{ $currentPlace->name }}</span>
                                @elseif($user->place)
                                    <span class="text-warning">{{ formatPhrase($user->place) }} <small>(ancien)</small></span>
                                @else
                                    <span class="text-muted"><em>Aucune place</em></span>
                                @endif
                            </div>
                            <a class="btn btn-primary-light btn-wave" style="text-transform: capitalize"
                                href="{{ route('profile.edit', $user) }}">Modifier le
                                profil</a>
                        </div>
                    @endforeach
                </div>
                {{-- {{ $users->links('vendor.pagination.bootstrap-5') }} --}}
                {{ $users->links('vendor.pagination.custom') }}






            </div>
        </div>
        <!-- End::app-content -->


    @endsection

</x-app-layout>
