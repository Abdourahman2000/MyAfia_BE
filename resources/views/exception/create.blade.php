<x-app-layout>
    @section('title', "MyAfia Exception")
    @section('css')
        <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css">
        <style>
            .box_item {
                width: 13.42%;
            }

            @media screen and (max-width: 1250px) {
                .box_item {
                    width: 15.8%;
                }
            }

            @media screen and (max-width: 1072px) {
                .box_item {
                    width: 19.1%;
                }
            }

            @media screen and (max-width: 800px) {
                .box_item {
                    width: 24.2%;
                }
            }
        </style>
    @endsection
    @section('content')
        <div class="main-content app-content">
            <div class="container-fluid">

                <x-breadcrumb.wrapper title="Gestion des exceptions">
                    <x-breadcrumb.item title="Tableau de bord" />
                    <x-breadcrumb.item title="Exception" />
                    <x-breadcrumb.item title="Créer" type="active" />
                </x-breadcrumb.wrapper>

                <div>
                    <x-sessions.sessionAny />
                    <x-sessions.sessionAlert type="add" />
                    <x-sessions.sessionAlert type="delete" />
                    <x-sessions.sessionAlert type="edit" />
                    <x-sessions.sessionAlert type="error" />
                </div>

                <div class="d-flex justify-content-between; gap-3" style="width: 98%;">
                    <form class="g-3 mt-0 bg-white mb-3 create_user_form p-3 rounded-1 col-5 d-flex flex-column"
                        method="post" action="#">
                        @csrf
                        <div class="col-12">
                            <label class="form-label" for="ssn">SSN</label>
                            <input type="text" class="form-control" placeholder="Enter the patient SSN" aria-label="SSN"
                                id="ssn" name="ssn" required>
                        </div>

                        <div class="col-12 mt-auto">
                            <button id="fetchPatientsBtn" type="submit"
                                class="btn btn-primary mt-3 w-100">Rechercher</button>
                        </div>
                    </form>
                    <div class="g-3 mt-0 bg-white mb-3 create_user_form p-3 rounded-1 col-7">
                        <h5 style="font-size: .9rem;">Informations sur le patient (Assuré principal)</h5>
                        <div class="patient_information">
                            <p style="font-size: .8rem;" class="patient_information_message">Recherche d'un numéro
                                d'identification personnel (ssn) pour obtenir toutes les données disponibles</p>
                            <div class="patient_information_wrapper justify-content-between" style="display: none">
                                <div class="pi_left">
                                    <img class="pi_left_img" src="" alt="user avatar" />
                                    <h6 style="font-size: .8rem; margin-top:.5rem;" class="patient_name"></h6>
                                </div>
                                <div class="pi_right">
                                    <div class="pi_right_block">
                                        <strong>Nom travailleur</strong>
                                        <span class="company_name"></span>
                                    </div>
                                    <div class="pi_right_block">
                                        <strong>Matricule</strong>
                                        <span class="matricule"></span>
                                    </div>
                                    <div class="pi_right_block">
                                        <strong>Regime Assurée</strong>
                                        <span class="regime"></span>
                                    </div>
                                    <div class="pi_right_block">
                                        <strong>Accès au soins</strong>
                                        <span class="care_access"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box_of_item mb-4">
                    <!-- Items will be dynamically inserted here -->
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
                $('#fetchPatientsBtn').click(function(e) {
                    e.preventDefault();
                    const ssn = $('#ssn').val();

                    $.ajax({
                        url: "{{ route('ajax.getPatientForException') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ssn: ssn
                        },
                        success: function(response) {
                            if (response.status) {
                                const patients = response.data;
                                let html = '';
                                patients.forEach(function(patient) {
                                    if (patient.RelationCode == 1) {
                                        $('.patient_information_message').hide();
                                        $('.patient_information_wrapper').css('display', 'flex');
                                        $('.pi_left_img').attr('src', `${patient.Photo}`);
                                        $('.patient_name').text(`${patient.Nom}`);
                                        $('.company_name').text(`${patient["Nom de l'employeur"]}`);
                                        $('.matricule').text(`${patient['Compte Cotisant']}`);
                                        $('.regime').text(`${patient['Regime Travailleur']}`);
                                        $('.care_access').text(`${patient.Acces_soin}`);
                                        
                                        if (patient['Acces_soin'].toLowerCase() == 'oui') {
                                            $('.care_access').removeClass('care_access_yes care_access_no').addClass('care_access_yes');
                                        } else {
                                            $('.care_access').removeClass('care_access_yes care_access_no').addClass('care_access_no');
                                        }
                                    }

                                    html += `
                                    <div class="box_item" style="border-radius:.2rem; border-top:2px solid ${patient['Acces_soin'].toLowerCase() == 'oui' ? '#198754db' : '#C4290AFF'}; border-bottom:2px solid ${patient['Acces_soin'].toLowerCase() == 'oui' ? '#198754db' : '#C4290AFF'};">
                                        <img src="${patient.Photo}" alt="user avatar" />
                                        <h5>${patient.Nom}</h5>
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <span>${patient.SSN}</span>
                                            <span class="patient_age">Age ${patient.Age}</span>
                                        </div>
                                        <input type="date" class="form-control mb-2 exception_date" required>
                                        <a href="#" class="btn btn-primary-light btn-wave update_exception" 
                                            data-ssn="${patient.SSN}" 
                                            data-memberid="${patient.MemberID}" 
                                            data-relationcode="${patient.RelationCode}" 
                                            data-name="${patient.Nom}">
                                            Mettre à jour
                                        </a>
                                    </div>`;
                                });

                                $('.box_of_item').html(html);
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            const response = JSON.parse(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message,
                            })
                        }
                    });
                });

                $(document).on('click', '.update_exception', function(e) {
    e.preventDefault();
    const button = $(this);
    const dateInput = button.siblings('.exception_date');
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
        title: 'Motif de la mise à jour',
        input: 'textarea',
        inputLabel: 'Raison',
        inputPlaceholder: 'Saisissez le motif de la mise à jour...',
        showCancelButton: true,
        confirmButtonText: 'Valider',
        cancelButtonText: 'Annuler',
        showLoaderOnConfirm: true,
        preConfirm: (reason) => {
            if (!reason) {
                Swal.showValidationMessage('Veuillez saisir un motif');
                return false;
            }

            return $.ajax({
                url: "{{ route('ajax.updateFamilyAccess') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ssn: button.data('ssn'),
                    name: button.data('name'),
                    date_fin_exception: selectedDate, // Modifié ici
                    reason: reason
                }
            }).catch(error => {
                Swal.showValidationMessage(
                    `Échec de la requête: ${error.responseJSON?.message || 'Erreur inconnue'}`
                )
            });
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Mise à jour effectuée',
                text: 'Les informations ont été mises à jour avec succès.'
            }).then(() => {
                // Optionnel : rafraîchir la page ou les données
                location.reload();
            });
        }
    });
});
            });
        </script>
    @endsection
</x-app-layout>