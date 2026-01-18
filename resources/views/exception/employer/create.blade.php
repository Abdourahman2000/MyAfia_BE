<x-app-layout>
    @section('title', "MyAfia Exception Employeur")
    @section('css')
    <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
        <!-- Sweetalerts CSS -->
        <link rel="stylesheet" href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css">


        <style>
            .pi_right_block {
                margin-bottom: 1rem;
                padding: 0.75rem;
                background-color: #f8f9fa;
                border-radius: 0.375rem;
                border: 1px solid #e9ecef;
            }
        
            .pi_right_block strong {
                display: block;
                color: #495057;
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }
        
            .care_access {
                display: inline-block;
                padding: 0.25rem 0.5rem;
                border-radius: 0.25rem;
                font-weight: 500;
            }
        
            .care_access_yes {
                background-color: #d1e7dd;
                color: #0f5132;
            }
        
            .care_access_no {
                background-color: #f8d7da;
                color: #842029;
            }
        </style>
@endsection
    
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <x-breadcrumb.wrapper title="Gestion des exceptions employeur">
            <x-breadcrumb.item title="Tableau de bord" />
            <x-breadcrumb.item title="Exception" />
            <x-breadcrumb.item title="Employeur" type="active" />
        </x-breadcrumb.wrapper>

        <div class="d-flex justify-content-between gap-3" style="width: 98%;">
            <!-- Formulaire de recherche -->
            <form class="g-3 mt-0 bg-white mb-3 create_user_form p-3 rounded-1 col-5">
                @csrf
                <div class="col-12">
                    <label class="form-label" for="compte_cotisant">Compte Cotisant</label>
                    <input type="text" class="form-control" placeholder="Entrez le compte cotisant" 
                        id="compte_cotisant" name="compte_cotisant" required>
                </div>
                <div class="col-12 mt-3">
                    <button id="fetchEmployerBtn" type="submit" class="btn btn-primary w-100">
                        Rechercher
                    </button>
                </div>
            </form>

            <!-- Information employeur -->
            <div class="g-3 mt-0 bg-white mb-3 p-3 rounded-1 col-7">
                <h5 style="font-size: .9rem;">Informations sur l'employeur</h5>
                <div class="employer_information">
                    <p class="employer_information_message">Recherchez un compte cotisant pour afficher les informations</p>
                    <div class="employer_information_wrapper" style="display: none">
                        <!-- Les informations de l'employeur seront affichées ici -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#fetchEmployerBtn').click(function(e) {
            e.preventDefault();
            const compteCotisant = $('#compte_cotisant').val();

            $.ajax({
                url: "{{ route('ajax.getEmployerForException') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    compte_cotisant: compteCotisant
                },
                success: function(response) {
                    if (response.status) {
                        $('.employer_information_message').hide();
                        $('.employer_information_wrapper').show();
                        
                        let html = `
                            <div class="pi_right">
                                <div class="pi_right_block">
                                    <strong>Nom employeur</strong>
                                    <span>${response.data.nom_employeur}</span>
                                </div>
                                <div class="pi_right_block">
                                    <strong>Compte Cotisant</strong>
                                    <span>${response.data.compte_cotisant}</span>
                                </div>
                                <div class="mt-4">
                                    <label class="form-label">Date fin exception</label>
                                    <input type="date" class="form-control mb-3 exception_date" required>
                                    <button class="btn btn-primary update_employer_exception w-100" 
                                        data-compte="${response.data.compte_cotisant}"
                                        data-nom="${response.data.nom_employeur}">
                                        Mettre à jour l'accès aux soins
                                    </button>
                                </div>
                            </div>`;

                        $('.employer_information_wrapper').html(html);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: response.message || 'Une erreur est survenue'
                    });
                }
            });
        });

        $(document).on('click', '.update_employer_exception', function(e) {
    e.preventDefault();
    const button = $(this);
    const dateInput = $('.exception_date');
    const selectedDate = dateInput.val();

    if (!selectedDate) {
        Swal.fire({
            icon: 'error',
            title: 'Date requise',
            text: 'Veuillez sélectionner une date',
        });
        return;
    }

    Swal.fire({
        title: 'Confirmation',
        html: `
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="protocolCheck">
                <label class="form-check-label" for="protocolCheck">
                    Protocol d'accord
                </label>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Valider',
        cancelButtonText: 'Annuler',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const isChecked = document.getElementById('protocolCheck').checked;
            if (!isChecked) {
                Swal.showValidationMessage('Veuillez accepter le protocol d\'accord');
                return false;
            }

            return $.ajax({
                url: "{{ route('ajax.updateEmployerAccess') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    compte_cotisant: button.data('compte'),
                    nom_employeur: button.data('nom'),
                    date_fin_exception: selectedDate
                }
            }).catch(error => {
                Swal.showValidationMessage(
                    `Échec de la requête: ${error.responseJSON?.message || 'Erreur inconnue'}`
                );
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed && result.value && result.value.status) {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: `${result.value.message} (${result.value.count} patients mis à jour)`,
                timer: 2000
            }).then(() => {
                // Recharger la page après le message de succès
                location.reload();
            });
        } else if (result.isConfirmed && result.value && !result.value.status) {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: result.value.message
            });
        }
    });
});
    });
</script>
@endsection
</x-app-layout>