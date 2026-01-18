<x-app-layout>
    @section('title', 'MyAfia Recherche avancée')
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

                <x-breadcrumb.wrapper title="Recherche avancée">
                    <x-breadcrumb.item title="Tableau de bord" />
                    <x-breadcrumb.item title="Bureau d'entrée" />
                    <x-breadcrumb.item title="Recherche avancée" type="active" />
                </x-breadcrumb.wrapper>

                <div>
                    <x-sessions.sessionAny />
                    <x-sessions.sessionAlert type="add" />
                    <x-sessions.sessionAlert type="delete" />
                    <x-sessions.sessionAlert type="edit" />
                    <x-sessions.sessionAlert type="error" />
                </div>


                <div class="d-flex justify-content-between; gap-3" style="width: 100%;">
                    <form class="g-3 mt-0 bg-white mb-3 create_user_form p-3 rounded-1 col-10 d-flex flex-column"
                        method="post" action="#">
                        @csrf
                        <div class="row col-12 m-0">
                            <div class="col-lg-4 col-md-12 col-xs-12 mt-2">
                                <label class="form-label" for="name">Nom du patient</label>
                                <input type="text" class="form-control" placeholder="Enter the patient name"
                                    aria-label="name" id="name" name="name" required>
                            </div>
                            <div class="col-lg-4 col-md-12 col-xs-12 mt-2">
                                <label class="form-label" for="ssn">SSN</label>
                                <input type="text" class="form-control" placeholder="Enter the patient SSN"
                                    aria-label="SSN" id="ssn" name="ssn" required>
                            </div>
                            <div class="col-lg-4 col-md-12 col-xs-12 mt-2">
                                <label class="form-label" for="mother_name">Nom de la mère</label>
                                <input type="text" class="form-control" placeholder="Enter the patient's mother name"
                                    aria-label="mother_name" id="mother_name" name="mother_name" required>
                            </div>
                        </div>


                        <div class="col-12 mt-auto">
                            <button id="fetchPatientsBtn" type="submit"
                                class="btn btn-primary mt-3 w-100">Recherche</button>
                        </div>
                    </form>
                    <div class="g-3 mt-0 bg-white mb-3 create_user_form p-3 rounded-1 col-2 d-flex flex-column">
                        <h5 style="font-size: .9rem;">Explication des couleurs</h5>
                        <span style="font-size: .7rem">
                            <span style="font-size:.9rem; font-weight:bold;">“</span> La couleur
                            de la bordure qui entoure chaque patient <span
                                style="font-size:.9rem; font-weight:bold;">”</span>
                        </span>
                        <div class="d-flex flex-column gap-1 justify-content-center mt-auto">
                            <p class="m-0 d-flex align-items-center gap-2">
                                <span class="dot dot-green"></span>
                                <span style="font-weight: bold; font-size:.8rem;">A un accès de soin.</span>
                            </p>
                            <p class="m-0 d-flex align-items-center gap-2">
                                <span class="dot dot-red"></span>
                                <span style="font-weight: bold; font-size:.8rem;">N'a pas d'accès de soin.</span>
                            </p>
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
                    const name = $('#name').val(); // Get SSN from some input field
                    const mother_name = $('#mother_name').val(); // Get SSN from some input field

                    $.ajax({
                        url: "{{ route('ajax.searchPatient') }}", // Adjust with your route
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // CSRF Token
                            ssn: ssn,
                            name: name,
                            mother_name: mother_name,
                        },
                        success: function(response) {

                            if (response.status) {
                                const patients = response.data;
                                let html = '';
                                patients.forEach(function(patient) {
                                    if (patient['Acces_soin'].toLowerCase() == 'oui') {
                                        html += `
                            <div class="box_item" style="border:2px solid #198754db; border-radius:.2rem;">
                                <img src="${patient.Photo}" alt="user avatar" />
                                <h5>${patient.Nom}</h5>
                                <div class="d-flex justify-content-center align-items-center w-100">
                                    <span>${patient.SSN}</span>
                                </div>
                                <span class="patient_age">Age ${patient.Age}</span>
                                
                            </div>
                        `;
                                    } else {
                                        html += `
                            <div class="box_item" style="border:2px solid #C4290AFF; border-radius:.2rem;">
                                <img src="${patient.Photo}" alt="user avatar" />
                                <h5>${patient.Nom}</h5>
                                <div class="d-flex justify-content-center align-items-center w-100">
                                    <span>${patient.SSN}</span>
                                </div>
                                <span class="patient_age">Age ${patient.Age}</span>
                                
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
