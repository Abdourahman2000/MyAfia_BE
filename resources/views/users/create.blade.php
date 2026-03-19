<x-app-layout>
    @section('title', 'MyAfia Créer un nouvel utilisateur')
    @section('css')
        <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
    @endsection
    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <x-breadcrumb.wrapper title="Créer un nouvel utilisateur">
                    <x-breadcrumb.item title="Tableau de bord" />
                    <x-breadcrumb.item title="Utilisateurs" />
                    <x-breadcrumb.item title="Créer" type="active" />
                </x-breadcrumb.wrapper>

                <div>
                    <x-sessions.sessionAny />
                    <x-sessions.sessionAlert type="add" />
                    <x-sessions.sessionAlert type="delete" />
                    <x-sessions.sessionAlert type="edit" />
                    <x-sessions.sessionAlert type="error" />
                </div>

                <form class="row g-3 mt-0 bg-white mb-5 create_user_form p-4 rounded-1" method="post"
                    action="{{ route('users.create') }}">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label" for="name">Nom</label>
                        <input type="text" class="form-control" placeholder="Name" aria-label="Name" id="name"
                            name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="cnss@cnss.dj"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="form-label mb-1">Genre</label>
                            <div class="col-xl-6">
                                <div class="form-check">
                                    <input value="m" class="form-check-input" type="radio" name="gender"
                                        id="male" checked required>
                                    <label class="form-check-label" for="male">
                                        Male
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-check">
                                    <input value="f" class="form-check-input" type="radio" name="gender"
                                        id="female" required>
                                    <label class="form-check-label" for="female">
                                        Female
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="place" id="place" class="form-check-label d-block">Lieu</label>
                        <select class="js-example-basic-single" name="place_id" required>
                            <option value="">Sélectionnez un lieu</option>
                            @foreach ($places as $place)
                                <option value="{{ $place->id }}">{{ $place->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="type" id="type" class="form-check-label d-block">Type</label>
                        <select class="js-example-basic-single select2" name="type" required>
                            <option value="agent">Agent</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <hr>
                        <label class="form-label fw-bold">Privilèges</label>
                        <div class="d-flex flex-wrap gap-4 mt-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="canprint" name="canprint"
                                    value="1">
                                <label class="form-check-label" for="canprint">Autoriser l'impression</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="canexcept" name="canexcept"
                                    value="1">
                                <label class="form-check-label" for="canexcept">Autoriser les exceptions</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="canprintfamily" name="canprintfamily"
                                    value="1">
                                <label class="form-check-label" for="canprintfamily">Autoriser l'impression
                                    familiale</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="canbiometrie" name="canbiometrie"
                                    value="1">
                                <label class="form-check-label" for="canbiometrie">Autoriser la biométrisation</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Créer un utilisateur</button>
                    </div>
                </form>


            </div>
        </div>
        <!-- End::app-content -->


    @endsection
    @section('js')
        <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/select2.js') }}"></script>
    @endsection

</x-app-layout>
