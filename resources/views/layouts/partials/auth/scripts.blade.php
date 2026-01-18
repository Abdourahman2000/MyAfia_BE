<!-- Helpers -->
<script src="{{ asset('assets') }}/auth/vendor/js/helpers.js"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('assets') }}/auth/js/config.js"></script>

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="{{ asset('assets') }}/auth/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset('assets') }}/auth/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('assets') }}/auth/vendor/js/bootstrap.js"></script>
<script src="{{ asset('assets') }}/auth/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{ asset('assets') }}/auth/vendor/js/menu.js"></script>
<script src="{{ URL::asset('assets/auth/js/lottie-player.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->
<script src="{{ asset('assets') }}/auth/js/main.js"></script>

@yield('js')
