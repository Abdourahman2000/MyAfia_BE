@php
    use Illuminate\Support\Carbon;
@endphp
<x-app-layout>
    @section('title', 'MyAfia Profile')
    @section('css')
        <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
    @endsection

    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <x-breadcrumb.wrapper title="Profile">
                    <x-breadcrumb.item title="Dashboard" />
                    <x-breadcrumb.item title="Profile" />
                    <x-breadcrumb.item title="{{ $user->name }}" type="current" />
                </x-breadcrumb.wrapper>

                <div>
                    <x-sessions.sessionAny />
                    <x-sessions.sessionAlert type="add" />
                    <x-sessions.sessionAlert type="delete" />
                    <x-sessions.sessionAlert type="edit" />
                    <x-sessions.sessionAlert type="error" />
                </div>

                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                        <div class="card custom-card">
                            <img src="{{ asset('assets/images/MyAfia_icon.jpg') }}" alt="user avatar"
                                style="padding:1rem;" />
                            <div class="card-body">
                                <h5 class="card-title">{{ $user->name }}</h5>
                                <p class="card-text m-0">{{ $user->email }}</p>
                                <p class="card-text m-0" id="currentPlaceDisplay">
                                    @php
                                        $currentPlace = null;
                                        if ($user->place_id) {
                                            $currentPlace = $places->find($user->place_id);
                                        }
                                    @endphp
                                    @if($currentPlace)
                                        <strong>Place:</strong> {{ $currentPlace->name }}
                                    @elseif($user->place)
                                        <strong>Place (ancien):</strong> {{ $user->place }}
                                    @else
                                        <span class="text-muted"><em>Aucune place assignée</em></span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9">
                        <div class="row row-sm">
                            <div class="col-sm-12 col-lg-4 col-md-12">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="counter-status d-flex md-mb-0">
                                            <div class="counter-icon bg-primary-transparent">
                                                <i class="icon-layers text-primary"></i>
                                            </div>
                                            <div class="ms-auto">
                                                <h5 class="fs-13">Fiche d'autorisation</h5>
                                                <h2 class="mb-0 fs-22 mb-1 mt-1" style="font-size:1rem; text-align:right;">
                                                    {{ number_format($fiche_user_today) }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 col-md-12">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="counter-status d-flex md-mb-0">
                                            <div class="counter-icon bg-danger-transparent">
                                                <i class="icon-layers text-danger"></i>
                                            </div>
                                            <div class="ms-auto">
                                                <h5 class="fs-13">Membre depuis</h5>
                                                <h2 class="mb-0 fs-22 mb-1 mt-1" style="font-size:1rem; text-align:right;">
                                                    {{ Carbon::parse($user->created_at)->format('d/m/Y') }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 col-md-12">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="counter-status d-flex md-mb-0">
                                            <div class="counter-icon bg-success-transparent">
                                                <i class="icon-layers text-success"></i>
                                            </div>
                                            <div class="ms-auto">
                                                <h5 class="fs-13">Genre</h5>
                                                <h2 class="mb-0 fs-22 mb-1 mt-1" style="font-size:1rem; text-align:right;">
                                                    @if ($user->gender == 'm')
                                                        Homme
                                                    @elseif ($user->gender == 'f')
                                                        Female
                                                    @else
                                                        --
                                                    @endif
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Réinitialiser le mot de passe
                                        </div>
                                    </div>
                                    <form action="{{ route('profile.resetPassword', $user) }}" method="POST"
                                        class="card-body">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-key">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                                                    <path d="M15 9h.01" />
                                                </svg>
                                            </span>
                                            <input type="password" class="form-control password_field"
                                                placeholder="Mot de passe" aria-label="password" name="password"
                                                aria-describedby="button-addon1">
                                            <button type="button" class="btn generatePassword"
                                                style="background:rgb(var(--light-rgb)); color:var(--default-text-color); font-weight:bold; border:1px solid var(--input-border)">Générer</button>
                                            <button type="button" class="btn showHidePassword"
                                                style="background:rgb(var(--light-rgb)); color:var(--default-text-color); font-weight:bold; border:1px solid var(--input-border)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path
                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </button>
                                        </div>
                                        <button class="btn btn-primary w-100">Réinitialiser</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Ajout des boutons switch -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Options supplémentaires
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!-- Place Selection -->
                                        <div class="mb-3">
                                            <label for="placeSelect" class="form-label">
                                                <i class="ri-map-pin-line"></i> Assigner une place
                                            </label>
                                            <select class="form-control js-example-basic-single" id="placeSelect" style="width: 100%;">
                                                <option value="">Sélectionner une place...</option>
                                                @foreach($places as $place)
                                                    <option value="{{ $place->id }}" 
                                                            {{ $user->place_id == $place->id ? 'selected' : '' }}>
                                                        {{ $place->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="printSwitch"
                                                {{ $user->canprint ? 'checked' : '' }}>
                                            <label class="form-check-label" for="printSwitch">Autoriser
                                                l'impression</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="exceptSwitch"
                                                {{ $user->canexcept ? 'checked' : '' }}>
                                            <label class="form-check-label" for="exceptSwitch">Autoriser les
                                                exceptions</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="printFamilySwitch"
                                                {{ $user->canprintfamily ? 'checked' : '' }}>
                                            <label class="form-check-label" for="printFamilySwitch">Autoriser l'impression
                                                familiale</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast pour afficher les messages -->
        <div id="toast"
            class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-3"
            role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <!-- End::app-content -->
    @endsection

    @section('js')
        <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {

                // Initialize Select2 for place selection
                $('#placeSelect').select2({
                    placeholder: 'Sélectionner une place...',
                    allowClear: true,
                    width: '100%'
                }).on('select2:open', function() {
                    // Auto-focus the search input when dropdown opens
                    setTimeout(function() {
                        document.querySelector('.select2-search__field').focus();
                    }, 100);
                });


                $('#toast').toast({
                    autohide: true, // Masquer automatiquement après quelques secondes
                    delay: 3000 // Durée d'affichage en millisecondes (3 secondes)
                });
                $('.generatePassword').on('click', function() {
                    function generatePassword() {
                        var shortForms = ['af', 'myaf', 'afia', 'myafia', 'cnss', 'cn_afia'];
                        var shortForm1 = shortForms[Math.floor(Math.random() * shortForms.length)];
                        var shortForm2 = shortForms[Math.floor(Math.random() * shortForms.length)];
                        var randomNum = Math.floor(10000 + Math.random() * 90000);
                        var specialChars = '@#$%&*';
                        var specialChar1 = specialChars[Math.floor(Math.random() * specialChars.length)];
                        var specialChar2 = specialChars[Math.floor(Math.random() * specialChars.length)];
                        var password1 = shortForm1 + '_' + randomNum + specialChar1 + '***';
                        var password2 = shortForm2 + '@_' + randomNum + specialChar2 + '**';
                        var finalPassword = Math.random() < 0.5 ? password1 : password2;
                        return finalPassword;
                    }
                    var newPassword = generatePassword();
                    $('.password_field').val(newPassword);
                });

                $('.showHidePassword').on('click', function() {
                    var passwordField = $('.password_field');
                    var icon = $(this).find('svg');
                    if (passwordField.attr('type') === 'password') {
                        passwordField.attr('type', 'text');
                        icon.html(
                            '<path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" />'
                        );
                    } else {
                        passwordField.attr('type', 'password');
                        icon.html(
                            '<path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />'
                        );
                    }
                });

                // Gestion du sélecteur de place
                $('#placeSelect').on('change', function() {
                    const placeId = $(this).val();
                    const placeName = $(this).find('option:selected').text();

                    $.ajax({
                        url: "{{ route('profile.updatePlace', $user) }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            place_id: placeId || null
                        },
                        success: function(response) {
                            if (response.success) {
                                // Mettre à jour l'affichage de la place dans le profil
                                const displayText = response.place_name ? 
                                    '<strong>Place:</strong> ' + response.place_name :
                                    '<span class="text-muted"><em>Aucune place assignée</em></span>';
                                $('#currentPlaceDisplay').html(displayText);

                                // Afficher un toast de succès
                                const toastMessage = response.place_name ?
                                    `Place mise à jour vers: ${response.place_name}` :
                                    "Place supprimée avec succès.";
                                $('#toastMessage').text(toastMessage);
                                $('#toast').toast('show');
                            } else {
                                console.error('Failed to update place.');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                            // Afficher un toast d'erreur
                            $('#toastMessage').text(
                                "Une erreur s'est produite lors de la mise à jour de la place."
                            );
                            $('#toast').toast('show');
                        }
                    });
                });

                // Gestion des switchs

                // Gestion du switch d'impression
                $('#printSwitch').on('change', function() {
                    const isChecked = $(this).is(':checked') ? 1 : 0;
                    const userId = {{ $user->id }};

                    $.ajax({
                        url: "{{ route('profile.togglePrint', $user) }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            canprint: isChecked
                        },
                        success: function(response) {
                            if (response.success) {
                                // Afficher un toast de succès
                                const toastMessage = response.canprint ?
                                    "L'option d'impression a été activée avec succès." :
                                    "L'option d'impression a été désactivée avec succès.";
                                $('#toastMessage').text(toastMessage);
                                $('#toast').toast('show');
                            } else {
                                console.error('Failed to update print option.');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                            // Afficher un toast d'erreur
                            $('#toastMessage').text(
                                "Une erreur s'est produite lors de la mise à jour de l'option d'impression."
                            );
                            $('#toast').toast('show');
                        }
                    });
                });


                $('#exceptSwitch').on('change', function() {
                    const isChecked = $(this).is(':checked') ? 1 : 0;
                    const userId = {{ $user->id }};

                    $.ajax({
                        url: "{{ route('profile.toggleExcept', $user) }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            canexcept: isChecked
                        },
                        success: function(response) {
                            if (response.success) {
                                // Afficher un toast de succès
                                const toastMessage = response.canexcept ?
                                    "L'option d'exception a été activée avec succès." :
                                    "L'option d'exception a été désactivée avec succès.";
                                $('#toastMessage').text(toastMessage);
                                $('#toast').toast('show');
                            } else {
                                console.error('Failed to update exception option.');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                            // Afficher un toast d'erreur
                            $('#toastMessage').text(
                                "Une erreur s'est produite lors de la mise à jour de l'option d'exception."
                            );
                            $('#toast').toast('show');
                        }
                    });
                });

                $('#printFamilySwitch').on('change', function() {
                    const isChecked = $(this).is(':checked') ? 1 : 0;
                    const userId = {{ $user->id }};

                    $.ajax({
                        url: "{{ route('profile.togglePrintFamily', $user) }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            canprintfamily: isChecked
                        },
                        success: function(response) {
                            if (response.success) {
                                // Afficher un toast de succès
                                const toastMessage = response.canprintfamily ?
                                    "L'option d'impression familiale a été activée avec succès." :
                                    "L'option d'impression familiale a été désactivée avec succès.";
                                $('#toastMessage').text(toastMessage);
                                $('#toast').toast('show');
                            } else {
                                console.error('Failed to update family print option.');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr.responseText);
                            // Afficher un toast d'erreur
                            $('#toastMessage').text(
                                "Une erreur s'est produite lors de la mise à jour de l'option d'impression familiale."
                            );
                            $('#toast').toast('show');
                        }
                    });
                });
            });
        </script>
    @endsection
</x-app-layout>
