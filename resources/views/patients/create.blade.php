<x-app-layout>
    @section('title', 'MyAfia Create a new')
    @section('css')
        <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
    @endsection
    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <x-breadcrumb.wrapper title="Create a new user">
                    <x-breadcrumb.item title="Dashboard" />
                    <x-breadcrumb.item title="Users" />
                    <x-breadcrumb.item title="Create" type="active" />
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
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control" placeholder="Name" aria-label="Name" id="name"
                            name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="cnss@cnss.dj"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="form-label mb-1">Gender</label>
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
                        <label for="place" id="place" class="form-check-label d-block">Place</label>
                        <select class="js-example-basic-single" name="place" required>
                        <option value="depart_amu">AMU</option>
                            <option value="agence_lagarde">Place Lagarde</option>
                            <option value="agence_pk12">Agence PK12</option>
                            <option value="agence_nord">Agence de Nord</option>
                            <option value="agence_sud">Agence de Sud</option>
                            <option value="dar_El_hanan">Maternité de Dar El hanan</option>
                            <option value="hopital_regional_arta">Hôpital régional d'Arta</option>
                            <option value="hopital_regional_ali_Sabieh">Hôpital régional d'Ali-Sabieh</option>
                            <option value="hopital_fnp">FNP</option>
                            <option value="alrahma_hospital">Hôpital Al Rahma</option>
                            <option value="hopital_general_peltier">Hôpital général peltier</option>
                            <option value="hopital_militaire">Hôpital Militaire</option>
                            <option value="hopital_de_balbala_cheikho">Hopital de Balbala (Cheikho)</option>
                            <option value="clinique_le_heron">Clinique Le Héron</option>
                            <option value="clinique_affi">Clinique AFFI</option>
                            <option value="somclinique">Somclinique</option>
                            <option value="centre_mutualis">Centre Mutualis</option>
                            <option value="polyclinique_pk12">Polyclinique PK12</option>
                            <option value="polyclinique_farah_had">Polyclinique Farah-Had</option>
                            <option value="polyclinique_hayabley">Polyclinique Hayabley</option>
                            <option value="dev_dba">DEV/DBA</option>
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
                        <button type="submit" class="btn btn-primary">Create User</button>
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
