<x-app-layout>
    @section('title', 'MyAfia List of users')

    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <x-breadcrumb.wrapper title="List of users">
                    <x-breadcrumb.item title="Dashboard" />
                    <x-breadcrumb.item title="List of users" type="active" />
                </x-breadcrumb.wrapper>

                <div>
                    <x-sessions.sessionAny />
                    <x-sessions.sessionAlert type="add" />
                    <x-sessions.sessionAlert type="delete" />
                    <x-sessions.sessionAlert type="edit" />
                    <x-sessions.sessionAlert type="error" />
                </div>

                <form action="{{ route('users.index') }}" method="get" class="col-xl-12 pagination_search mb-3">
                    <input type="text" class="form-control rounded-pill" id="input-rounded-pill" name="search"
                        placeholder="Search for a user">
                    <button type="submit"><i class="ti ti-search"></i></button>
                </form>

                <div class="box_of_item mb-4">
                    @foreach ($users as $user)
                        <div class="box_item">
                            <img src="{{ asset('assets/images/avatars/1.png') }}" alt="user avatar" />
                            <h5>{{ $user->name }}</h5>
                            <div style="display: flex; justify-content: space-between; width:100%;">
                                <span>{{ $user->type }}</span>
                                <span>{{ $user->place }}</span>
                            </div>
                            <a class="btn btn-primary-light btn-wave" href="#">Edit Profile</a>
                        </div>
                    @endforeach
                </div>
                {{-- {{ $users->links('vendor.pagination.bootstrap-5') }} --}}
                {{ $users->links('vendor.pagination.custom') }}






            </div>
        </div>
        <!-- End::app-content -->


    @endsection

</x-app-layout>
