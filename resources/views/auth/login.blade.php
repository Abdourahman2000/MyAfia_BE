<x-guest-layout>
    @section('title', 'MyAfia - Connexion')
    @section('content')
        <!-- Content -->

        <div class="container-xxl" style="position: relative">
            <img class="pattern_image" src="{{ URL::asset('assets/images/pattern9.png') }}" alt="">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner row" style="max-width: 80%;">
                    <!-- Register -->
                    <div class="card px-sm-6 px-0 col-md-4 radius_left"
                        style="display: flex; flex-direction:column; justify-content: center; align-items:center;">
                        <div class="bg_logo">
                            <lottie-player src="{{ URL::asset('assets/auth/js/files/') }}/05.json" background="transparent"
                                speed="1" style="width: 500px; height: 500px;" loop autoplay></lottie-player>
                        </div>
                    </div>
                    <div class="card px-sm-6 px-0 col-md-8 radius_right" style="background-color:#cce2ff75 !important">
                        <div class="card-body d-flex flex-column">
                            <!-- Logo -->
                            <div class="app-brand justify-content-center" style="margin-bottom:2.5rem">
                                <img src="{{ asset('assets/images/myafia.png') }}" alt="MyAfia" style="width: 40%">
                            </div>
                            <!-- /Logo -->
                            <h4 class="mb-1">Bienvenue à MyAfia!</h4>
                            <p class="mb-6">Veuillez vous connecter à votre compte pour commencer à utiliser la
                                plateforme.</p>

                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <!-- Login Attempts Info -->
                            @if (session('login_attempts_remaining') !== null && session('login_attempts_remaining') < 5)
                                <div class="alert alert-warning mb-4" id="attempts-warning">
                                    <i class="bx bx-error-circle me-2"></i>
                                    <span id="attempts-text">
                                        Attention: Il vous reste <strong>{{ session('login_attempts_remaining') }}</strong>
                                        tentative(s) avant le verrouillage.
                                    </span>
                                </div>
                            @endif

                            <!-- Lockout Timer -->
                            @if (session('lockout_until'))
                                <div class="alert alert-danger mb-4" id="lockout-timer">
                                    <i class="bx bx-time me-2"></i>
                                    <span>Compte verrouillé. Prochaine tentative dans: <strong
                                            id="countdown-display">--:--</strong></span>
                                </div>
                            @endif

                            <form id="formAuthentication" class="mb-6" action="{{ route('login') }}" method="POST"
                                @if (session('lockout_until')) disabled @endif>
                                @csrf
                                <div class="mb-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter your email address" autofocus />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="mb-6 form-password-toggle">
                                    <label class="form-label" for="password">Mot de passe</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div class="mb-8">
                                    <div class="d-flex justify-content-between mt-8">
                                        <div class="form-check mb-0 ms-2">
                                            <input class="form-check-input" type="checkbox" id="remember"
                                                name="remember" />
                                            <label class="form-check-label" for="remember"> Gardez-moi connecté </label>
                                        </div>
                                        {{-- <a href="auth-forgot-password-basic.html">
                                        <span>Forgot Password?</span>
                                    </a> --}}
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <button class="btn btn-primary d-grid w-100" type="submit" id="login-btn"
                                        @if (session('lockout_until')) disabled @endif>
                                        Connexion
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Register -->
                </div>
            </div>
        </div>

        <!-- / Content -->

        @if (session('lockout_until'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const lockoutUntil = {{ session('lockout_until') }};
                    const countdownDisplay = document.getElementById('countdown-display');
                    const loginBtn = document.getElementById('login-btn');
                    const form = document.getElementById('formAuthentication');
                    const emailInput = document.getElementById('email');
                    const passwordInput = document.getElementById('password');

                    function updateCountdown() {
                        const now = Math.floor(Date.now() / 1000);
                        const timeLeft = lockoutUntil - now;

                        if (timeLeft <= 0) {
                            // Lockout expired, enable form
                            countdownDisplay.textContent = 'Expiré';
                            loginBtn.disabled = false;
                            loginBtn.textContent = 'Connexion';
                            emailInput.disabled = false;
                            passwordInput.disabled = false;

                            // Hide lockout timer
                            const lockoutTimer = document.getElementById('lockout-timer');
                            if (lockoutTimer) {
                                lockoutTimer.style.display = 'none';
                            }

                            // Clear the interval
                            clearInterval(countdownInterval);
                            return;
                        }

                        const minutes = Math.floor(timeLeft / 60);
                        const seconds = timeLeft % 60;
                        countdownDisplay.textContent =
                            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                        // Keep form disabled
                        loginBtn.disabled = true;
                        emailInput.disabled = true;
                        passwordInput.disabled = true;
                    }

                    // Disable form inputs during lockout
                    emailInput.disabled = true;
                    passwordInput.disabled = true;

                    // Update countdown immediately and then every second
                    updateCountdown();
                    const countdownInterval = setInterval(updateCountdown, 1000);
                });
            </script>
        @endif

    @endsection
</x-guest-layout>
