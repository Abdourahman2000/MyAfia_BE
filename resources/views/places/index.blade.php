<x-app-layout>
    @section('title', 'MyAfia Liste des places')
    @section('css')
        <link rel="stylesheet" href="{{ asset('assets/libs/datatable/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/libs/datatable/responsive.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/libs/datatable/buttons.bootstrap5.min.css') }}">
    @endsection
    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <x-breadcrumb.wrapper title="Liste des places">
                    <x-breadcrumb.item title="Tableau de bord" />
                    <x-breadcrumb.item title="Places" />
                    <x-breadcrumb.item title="Liste des places" type="active" />
                </x-breadcrumb.wrapper>
                
                <div>
                    <x-sessions.sessionAny />
                    <x-sessions.sessionAlert type="add" />
                    <x-sessions.sessionAlert type="delete" />
                    <x-sessions.sessionAlert type="edit" />
                    <x-sessions.sessionAlert type="error" />
                </div>

                <!-- Start:: row-4 -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">Liste des places ({{ $places->total() }} places)</div>
                                <div>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createPlaceModal">
                                        <i class="ri-add-line"></i> Créer une nouvelle place
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file-export" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nom de la place</th>
                                                <th>Créé par</th>
                                                <th>Nombre d'utilisateurs</th>
                                                <th>Date de création</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = ($places->currentPage() - 1) * $places->perPage() + 1;
                                            @endphp
                                            @foreach ($places as $place)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $place->name }}</td>
                                                    <td>{{ $place->createdBy ? $place->createdBy->name : 'N/A' }}</td>
                                                    <td>{{ $place->users()->count() }}</td>
                                                    <td>{{ $place->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>
                                                        <div class="btn-list">
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-primary edit-place-btn"
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#editPlaceModal"
                                                                    data-place-id="{{ $place->id }}"
                                                                    data-place-name="{{ $place->name }}"
                                                                    data-creator-name="{{ $place->createdBy ? $place->createdBy->name : 'N/A' }}"
                                                                    data-users-count="{{ $place->users()->count() }}">
                                                                <i class="ri-edit-line"></i> Modifier
                                                            </button>
                                                            @if($place->users()->count() == 0)
                                                                <form action="{{ route('places.destroy', $place) }}" 
                                                                      method="POST" class="d-inline" 
                                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette place ?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                        <i class="ri-delete-bin-line"></i> Supprimer
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <button class="btn btn-sm btn-outline-secondary" disabled 
                                                                        title="Impossible de supprimer - des utilisateurs sont assignés à cette place">
                                                                    <i class="ri-delete-bin-line"></i> Supprimer
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End:: row-4 -->
                {{ $places->links('vendor.pagination.custom') }}

            </div>
        </div>
        <!-- End::app-content -->

        <!-- Create Place Modal -->
        <div class="modal fade" id="createPlaceModal" tabindex="-1" aria-labelledby="createPlaceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="createPlaceForm" action="{{ route('places.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPlaceModalLabel">Créer une nouvelle place</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="createPlaceName" class="form-label">Nom de la place</label>
                                <input type="text" class="form-control" id="createPlaceName" name="name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Créer la place</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Place Modal -->
        <div class="modal fade" id="editPlaceModal" tabindex="-1" aria-labelledby="editPlaceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editPlaceForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPlaceModalLabel">Modifier la place</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editPlaceName" class="form-label">Nom de la place</label>
                                <input type="text" class="form-control" id="editPlaceName" name="name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Créé par</label>
                                    <input type="text" class="form-control" id="editCreatorName" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Utilisateurs assignés</label>
                                    <input type="text" class="form-control" id="editUsersCount" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Modifier la place</button>
                            <button type="button" class="btn btn-danger" id="deleteFromModal" style="display: none;">Supprimer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endsection
    @section('js')
        <!-- Datatables Cdn -->
        <script src="{{ asset('assets/libs/datatable/') }}/jquery.dataTables.min.js"></script>
        <script src="{{ asset('assets/libs/datatable/') }}/dataTables.bootstrap5.min.js"></script>
        <script src="{{ asset('assets/libs/datatable/') }}/dataTables.responsive.min.js"></script>
        <script src="{{ asset('assets/libs/datatable/') }}/dataTables.buttons.min.js"></script>
        <script src="{{ asset('assets/libs/datatable/') }}/buttons.print.min.js"></script>
        <script src="{{ asset('assets/libs/datatable/') }}/pdfmake.min.js"></script>
        <script src="{{ asset('assets/libs/datatable/') }}/vfs_fonts.js"></script>
        <script src="{{ asset('assets/libs/datatable/') }}/buttons.html5.min.js"></script>
        <script src="{{ asset('assets/libs/datatable/') }}/jszip.min.js"></script>

        <!-- Internal Datatables JS -->
        <script>
            $('#file-export').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                language: {
                    searchPlaceholder: 'Rechercher...',
                    sSearch: '',
                },
                order: [[0, 'desc']] // Sort by ID descending by default
            });

            // Handle edit place button click
            $('.edit-place-btn').on('click', function() {
                const placeId = $(this).data('place-id');
                const placeName = $(this).data('place-name');
                const creatorName = $(this).data('creator-name');
                const usersCount = $(this).data('users-count');
                
                // Set form action
                $('#editPlaceForm').attr('action', "{{ route('places.update', '') }}/" + placeId);
                
                // Fill form fields
                $('#editPlaceName').val(placeName);
                $('#editCreatorName').val(creatorName);
                $('#editUsersCount').val(usersCount);
                
                // Show/hide delete button based on users count
                if (usersCount == 0) {
                    $('#deleteFromModal').show().data('place-id', placeId);
                } else {
                    $('#deleteFromModal').hide();
                }
            });

            // Handle delete button click in modal
            $('#deleteFromModal').on('click', function() {
                const placeId = $(this).data('place-id');
                const placeName = $('#editPlaceName').val();
                
                if (confirm(`Êtes-vous sûr de vouloir supprimer la place "${placeName}" ?`)) {
                    // Use AJAX for better error handling
                    $.ajax({
                        url: "{{ route('places.destroy', '') }}/" + placeId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#editPlaceModal').modal('hide');
                            location.reload(); // Refresh page to show updated data
                        },
                        error: function(xhr) {
                            const response = JSON.parse(xhr.responseText);
                            alert('Error: ' + response.message);
                        }
                    });
                }
            });

            // Handle form submission for create modal
            $('#createPlaceForm').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#createPlaceModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = JSON.parse(xhr.responseText).errors;
                            if (errors.name) {
                                $('#createPlaceName').addClass('is-invalid');
                                $('#createPlaceName').siblings('.invalid-feedback').text(errors.name[0]);
                            }
                        }
                    }
                });
            });

            // Handle form submission for edit modal
            $('#editPlaceForm').on('submit', function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editPlaceModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = JSON.parse(xhr.responseText).errors;
                            if (errors.name) {
                                $('#editPlaceName').addClass('is-invalid');
                                $('#editPlaceName').siblings('.invalid-feedback').text(errors.name[0]);
                            }
                        }
                    }
                });
            });

            // Clear form when create modal is closed
            $('#createPlaceModal').on('hidden.bs.modal', function () {
                $('#createPlaceForm')[0].reset();
                $('#createPlaceName').removeClass('is-invalid');
                $('#createPlaceName').siblings('.invalid-feedback').text('');
            });

            // Clear form when edit modal is closed
            $('#editPlaceModal').on('hidden.bs.modal', function () {
                $('#editPlaceForm')[0].reset();
                $('#editPlaceName').removeClass('is-invalid');
                $('#editPlaceName').siblings('.invalid-feedback').text('');
            });
        </script>
    @endsection

</x-app-layout>