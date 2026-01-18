<x-app-layout>
    @section('title', "MyAfia Imprimer une fiche d'autorisation")
    @section('css')
        <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
        <!-- Sweetalerts CSS -->
        <link rel="stylesheet" href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css">
        <style>
            .left_side,
            .right_side {
                transition: .3s all;
            }

            .left_side {
                width: 28%;
            }

            .right_side {
                width: 70%;
            }

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

                .pi_left {
                    width: 50%;
                }

                .pi_right {
                    width: 49%;
                }
            }

            @media screen and (max-width: 900px) {
                .box_item {
                    width: 24.2%;
                }

                .left_side {
                    width: 25%;
                }

                .right_side {
                    width: 70%;
                }
            }

            @media screen and (max-width: 800px) {
                .box_item {
                    width: 24.2%;
                }

                .left_side,
                .right_side {
                    width: 100%;
                }
            }



            .birth_p {
                margin: .3rem;
                margin-top: 0;
                font-size: .8rem;
                font-weight: bold;
                background: #eef0f9;
                width: 100%;
                text-align: center;
                padding: .1rem;
                border-radius: .2rem;
            }

            @media screen and (max-width: 550px) {
                .box_item {
                    width: 100%;
                }

                .box_item img {
                    width: unset;
                }
            }
        </style>
    @endsection
    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <x-breadcrumb.wrapper title="Imprimer une fiche d'autorisation">
                    <x-breadcrumb.item title="Tableau de bord" />
                    <x-breadcrumb.item title="Bureau d'entrée" />
                    <x-breadcrumb.item title="Imprimer" type="active" />
                </x-breadcrumb.wrapper>

                <div>
                    <x-sessions.sessionAny />
                    <x-sessions.sessionAlert type="add" />
                    <x-sessions.sessionAlert type="delete" />
                    <x-sessions.sessionAlert type="edit" />
                    <x-sessions.sessionAlert type="error" />
                </div>

                <div class="d-flex justify-content-between; gap-3"
                    style="width: 98%; flex-wrap: wrap; justify-content: space-between;">
                    <form class="g-3 mt-0 bg-white mb-3 create_user_form p-3 rounded-1 d-flex flex-column left_side"
                        method="post" action="#">
                        @csrf
                        <div class="col-12">
                            <label class="form-label" for="ssn">SSN</label>
                            <input type="number" class="form-control" placeholder="Enter the patient SSN" aria-label="SSN"
                                step="1" id="ssn" name="ssn" required>
                        </div>

                        <div class="col-12 mt-auto">
                            <button id="fetchPatientsBtn" type="submit"
                                class="btn btn-primary mt-3 w-100">Rechercher</button>
                        </div>
                    </form>
                    <div class="g-3 mt-0 bg-white mb-3 create_user_form p-3 rounded-1 right_side">
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
                                        <strong>Date de naissance</strong>
                                        <span></span><span class="birth_date"></span>
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
                    <!-- This is where new items will be dynamically inserted -->
                </div>

            </div>
        </div>
        <!-- End::app-content -->

    @endsection
    @section('js')
        <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/select2.js') }}"></script>
        <!-- Sweetalerts JS -->
        <script src="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#fetchPatientsBtn').click(function(e) {
                    e.preventDefault();
                    const ssn = $('#ssn').val();

                    $.ajax({
                        url: "{{ route('ajax.getPatients') }}",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ssn: ssn
                        },
                        success: function(response) {
                            if (response.status) {
                                const patients = response.data;
                                const canPrint = response.canprint;
                                // console.log(canPrint);
                                let html = '';

                                patients.forEach(function(patient) {
                                    if (patient.RelationCode == 1) {
                                        $('.patient_information_message').hide();
                                        $('.patient_information_wrapper').css('display',
                                            'flex');
                                        $('.pi_left_img').attr('src', `${patient.Photo}`);
                                        $('.patient_name').text(`${patient.Nom}`);
                                        $('.company_name').text(
                                            `${patient["Nom de l'employeur"]}`);
                                        $('.matricule').text(
                                            `${patient['Compte Cotisant']}`);
                                        $('.regime').text(
                                            `${patient['Regime Travailleur']}`);

                                        $('.birth_date').text(
                                            `${patient['Date de naissance']}`);

                                        if (patient['disactivated'] == true) {
                                            $('.care_access').text(
                                                'DESACTIVER');
                                            $('.care_access').removeClass(
                                                    'care_access_yes care_access_no')
                                                .addClass('care_access_no');
                                        } else {
                                            $('.care_access').text(
                                                `${patient.Acces_soin}`);


                                            if (patient['Acces_soin'].toLowerCase() ==
                                                'oui') {
                                                $('.care_access').removeClass(
                                                        'care_access_yes care_access_no')
                                                    .addClass('care_access_yes');
                                            } else {
                                                $('.care_access').removeClass(
                                                        'care_access_yes care_access_no')
                                                    .addClass('care_access_no');
                                            }
                                        }

                                    }

                                    if (patient['Acces_soin'].toLowerCase() == 'oui') {
                                        if (patient['disactivated'] == true) {
                                            html += `
                                            <div class="box_item" style="border-radius:.2rem; border-top:2px solid #C4290AFF; border-bottom:2px solid #C4290AFF;">
                                                <img src="${patient.Photo}" alt="user avatar" />
                                                <h5>${patient.Nom}</h5>
                                                <p class="birth_p">${patient['Date de naissance']}</p>
                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                    <span>${patient.SSN}</span>
                                                    <span class="patient_age">Age ${patient.Age}</span>
                                                </div>
                                                <p class="patient_blocked bg-danger">DESACTIVER</p>
                                            </div>`;
                                        } else {
                                            html += `
                                            <div class="box_item" style="border-radius:.2rem; border-top:2px solid #198754db; border-bottom:2px solid #198754db;">
                                                <img src="${patient.Photo}" alt="user avatar" />
                                                <h5>${patient.Nom}</h5>
                                                <p class="birth_p">${patient['Date de naissance']}</p>
                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                    <span>${patient.SSN}</span>
                                                    <span class="patient_age">Age ${patient.Age}</span>
                                                </div>
                                                ${canPrint == 1 ? `<a class="btn btn-primary-light btn-wave print_fiche" data-ssn="${patient.SSN}" data-memberID="${patient.MemberID}" data-relationCode="${patient.RelationCode}" data-name="${patient.Nom}">Imprimer</a>` : ''}
                                            </div>`;
                                        }
                                    } else {
                                        if (patient['disactivated'] == true) {
                                            html += `
                                            <div class="box_item" style="border-radius:.2rem; border-top:2px solid #C4290AFF; border-bottom:2px solid #C4290AFF;">
                                                <img src="${patient.Photo}" alt="user avatar" />
                                                <h5>${patient.Nom}</h5>
                                                <p class="birth_p">${patient['Date de naissance']}</p>
                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                    <span>${patient.SSN}</span>
                                                    <span class="patient_age">Age ${patient.Age}</span>
                                                </div>
                                                <p class="patient_blocked bg-danger">DESACTIVER</p>
                                            </div>`;
                                        } else {
                                            html += `
                                        <div class="box_item" style="border-radius:.2rem; border-top:2px solid #C4290AFF; border-bottom:2px solid #C4290AFF;">
                                            <img src="${patient.Photo}" alt="user avatar" />
                                            <h5>${patient.Nom}</h5>
                                            <p class="birth_p">${patient['Date de naissance']}</p>
                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                <span>${patient.SSN}</span>
                                                <span class="patient_age">Age ${patient.Age}</span>
                                            </div>
                                            ${canPrint == 1 ? `<a href="#" class="btn btn-secondary-light btn-wave exception_button" data-ssn="${patient.SSN}" data-memberid="${patient.MemberID}" data-relationcode="${patient.RelationCode}" data-name="${patient.Nom}"> Exception </a>` : ''}
                                        </div>`;
                                        }

                                    }
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
            });

            $(document).on('click', '.print_fiche', function(e) {
                e.preventDefault();

                let ssn = $(this).data('ssn');
                let memberId = $(this).data('memberid');
                let relationCode = $(this).data('relationcode');
                let name = $(this).data('name');

                $.ajax({
                    url: "{{ route('ajax.storeFiche') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ssn: ssn,
                        member_id: memberId,
                        relation_code: relationCode,
                        name: name
                    },
                    success: function(response) {
                        let id = response.id;
                        printExternal("{{ route('printing.authform', '') }}" + '/' + id);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Erreur lors du traitement de votre demande',
                        })
                    }
                });
            });
        </script>

        @include('includes.print.printExternal')
        <script>
            $(document).on('click', '.exception_button', function(e) {
                e.preventDefault();

                let ssn = $(this).data('ssn');
                let memberId = $(this).data('memberid');
                let relationCode = $(this).data('relationcode');
                let name = $(this).data('name');

                Swal.fire({
                    title: 'Motif de l\'exception',
                    input: 'textarea',
                    inputLabel: 'Raison',
                    inputPlaceholder: 'Saisissez le motif de l\'exception ici...',
                    inputAttributes: {
                        'aria-label': 'Saisissez le motif de l\'exception ici'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Valider',
                    cancelButtonText: 'Annuler',
                    showLoaderOnConfirm: true,
                    preConfirm: (reason) => {
                        if (!reason) {
                            Swal.showValidationMessage('Veuillez saisir un motif')
                            return false;
                        }
                        return $.ajax({
                            url: "{{ route('ajax.storeFiche') }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ssn: ssn,
                                member_id: memberId,
                                relation_code: relationCode,
                                name: name,
                                is_exception: true,
                                exception_reason: reason
                            }
                        }).then(response => {
                            return response;
                        }).catch(error => {
                            Swal.showValidationMessage(
                                `Échec de la requête: ${error.responseJSON.message || 'Erreur inconnue'}`
                            )
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        printExternal("{{ route('printing.authform', '') }}" + '/' + result.value.id);

                        Swal.fire({
                            icon: 'success',
                            title: 'Exception Enregistrée',
                            text: 'L\'exception a été enregistrée et la fiche est en cours d\'impression.'
                        });
                    }
                });
            });
        </script>
    @endsection
</x-app-layout>
