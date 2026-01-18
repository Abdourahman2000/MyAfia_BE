@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    @section('title', "MyAfia Fiche d'autorisation")
    @section('css')
        <link rel="stylesheet" href="{{ asset('assets/libs/datatable/dataTables.bootstrap5.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/libs/datatable/responsive.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/libs/datatable/buttons.bootstrap5.min.css') }}">
    @endsection
    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <x-breadcrumb.wrapper title="Fiche d'autorisation">
                    <x-breadcrumb.item title="Tableau de bord" />
                    <x-breadcrumb.item title="Fiche d'autorisation" />
                    <x-breadcrumb.item title="List of authorization forms" type="active" />
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
                            <div class="card-header">
                                <div class="card-title">Liste des fiches d'autorisation du</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file-export" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nom</th>
                                                <th>Créé par</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($list as $single)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $single->name }}</td>
                                                    <td>{{ $single->createdBy->place }}</td>
                                                    <td>{{ $single->created_at->format('d/m/Y') }}</td>
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
                {{ $list->links('vendor.pagination.custom') }}

            </div>
        </div>
        <!-- End::app-content -->


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
        {{-- <script src="{{ asset('assets') }}/js/datatables.js"></script> --}}
        <script>
            $('#file-export').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    paging: false, // Disable pagination

                },
            });
        </script>

    @endsection

</x-app-layout>
