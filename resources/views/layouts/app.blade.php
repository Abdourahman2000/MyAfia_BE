<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="light" data-toggled="close">

@include('layouts.partials.head')

<body>

    @include('layouts.partials.switcher')

    @include('layouts.partials.loader')

    <div class="page">

        @include('layouts.partials.appHeader')
        {{-- @include('layouts.partials.canvas_sidebar') --}}



        @include('layouts.partials.modals.messageModal')
        @include('layouts.partials.modals.videoModal')
        @include('layouts.partials.modals.audioModal')


        @include('layouts.partials.appSidebar')

        @yield('content')

        @include('layouts.partials.appFooter')

    </div>


    @include('layouts.partials.scrollTop')


    @include('layouts.partials.scripts')
</body>

</html>
