<x-app-layout>
    @section('title', 'MyAfia Create a new')
    @section('css')
        <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
        <!-- Sweetalerts CSS -->
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
        {{-- <script src="{{ asset('assets') }}/js/sweet-alerts.js"></script> --}}
        <script>
            $(document).ready(function() {
                // Example: Trigger AJAX on button click
                $('#fetchPatientsBtn').click(function(e) {
                    e.preventDefault();
                    const ssn = $('#ssn').val(); // Get SSN from some input field

                    $.ajax({
                        url: "{{ route('ajax.getPatients') }}", // Adjust with your route
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF Token
                            ssn: ssn
                        },
                        success: function(response) {
                            if (response.status) {
                                const patients = response.data;
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

                                        $('.care_access').text(
                                            `${patient.Acces_soin}`);
                                        if (patient['Acces_soin'].toLowerCase() == 'oui') {
                                            $('.care_access').removeClass(
                                                'care_access_yes');
                                            $('.care_access').removeClass('care_access_no');
                                            $('.care_access').addClass('care_access_yes');
                                        } else {
                                            $('.care_access').removeClass(
                                                'care_access_yes');
                                            $('.care_access').removeClass('care_access_no');
                                            $('.care_access').addClass('care_access_no');
                                        }
                                    }
                                    if (patient['Acces_soin'].toLowerCase() == 'oui') {
                                        if (patient['disactivated'] == true) {
                                            html += `
                            <div class="box_item" style="border-radius:.2rem; border-top:2px solid #198754db; border-bottom:2px solid #198754db;">
                                <img src="${patient.Photo}" alt="user avatar" />
                                <h5>${patient.Nom}</h5>
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span>${patient.SSN}</span>
                                    <span class="patient_age">Age ${patient.Age}</span>
                                </div>
                                <p class="patient_blocked bg-danger">Blocked</p>
                            </div>
                        `;
                                        } else {
                                            html += `
                            <div class="box_item" style="border-radius:.2rem; border-top:2px solid #198754db; border-bottom:2px solid #198754db;">
                                <img src="${patient.Photo}" alt="user avatar" />
                                <h5>${patient.Nom}</h5>
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span>${patient.SSN}</span>
                                    <span class="patient_age">Age ${patient.Age}</span>
                                </div>
                                <a class="btn btn-primary-light btn-wave print_fiche" 
                                data-ssn="${patient.SSN}" data-memberID="${patient.MemberID}" data-relationCode="${patient.RelationCode}" data-name="${patient.Nom}">Imprimer</a>
                            </div>
                        `;
                                        }

                                    } else {

                                        html += `
                            <div class="box_item" style="border-radius:.2rem; border-top:2px solid #C4290AFF; border-bottom:2px solid #C4290AFF;">
                                <img src="${patient.Photo}" alt="user avatar" />
                                <h5>${patient.Nom}</h5>
                                <div class="d-flex justify-content-between align-items-center w-100">
                                    <span>${patient.SSN}</span>
                                    <span class="patient_age">Age ${patient.Age}</span>
                                </div>
                            </div>
                        `;
                                    }
                                });

                                // Inject the new HTML into the box_of_item container
                                $('.box_of_item').html(html);

                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            const response = JSON.parse(xhr.responseText);
                            // console.error(xhr.responseText);
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
                e.preventDefault(); // Prevent the default action (optional, if the <a> should not follow a link)

                // Get the data from the clicked element
                let ssn = $(this).data('ssn');
                let memberId = $(this).data('memberid');
                let relationCode = $(this).data('relationcode');
                let name = $(this).data('name');

                // Send the AJAX request
                $.ajax({
                    url: "{{ route('ajax.storeFiche') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
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
                        // console.log('Error:', xhr, status, error);
                        // alert('An error occurred. Please try again.');
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error while processing your request',
                        })
                    }
                });
            });
        </script>


        @include('includes.print.printExternal')

    @endsection

</x-app-layout>
