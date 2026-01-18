<x-guest-layout>
    @section('title', 'Modifier le mot de passe')
    @section('content')

        {{-- disconnect button --}}
        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
            @csrf
            <button type="submit" class="logout-btn" id="logoutButton">
                <svg id="logoutIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span id="logoutText">Déconnexion</span>
                <div class="spinner" id="spinner"></div>
            </button>
        </form>


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
                            <h4 class="mb-1">Mot de passe temporaire !</h4>
                            <p class="mb-6">Modifier le mot de passe temporaire pour commencer à utiliser la plate-forme
                            </p>

                            <x-auth-session-status class="mb-4" :status="session('status')" />
                            <form id="formAuthentication" class="mb-6" action="{{ route('password.change.store') }}"
                                method="POST">
                                @csrf
                                <div class="mb-6">
                                    <label for="actual_pass" class="form-label">Mot de passe actuel</label>
                                    <input type="password" class="form-control" id="actual_pass" name="actual_pass"
                                        placeholder="Enter your actual password" autofocus />
                                    <x-input-error :messages="$errors->get('actual_pass')" class="mt-2" />
                                </div>
                                <div class="mb-6 form-password-toggle">
                                    <label class="form-label" for="password">Nouveau mot de passe</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div class="mb-6 form-password-toggle">
                                    <label class="form-label" for="password_confirmation">Confirmation du mot de
                                        passe</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password_confirmation" class="form-control"
                                            name="password_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                                <div class="password-requirements" id="passwordRequirements">
                                    <div class="requirement-item" data-requirement="length">
                                        <span class="requirement-icon">✕</span>
                                        <span class="requirement-text">Au moins 12 caractères</span>
                                    </div>
                                    <div class="requirement-item" data-requirement="number">
                                        <span class="requirement-icon">✕</span>
                                        <span class="requirement-text">Au moins un chiffre</span>
                                    </div>
                                    <div class="requirement-item" data-requirement="special">
                                        <span class="requirement-icon">✕</span>
                                        <span class="requirement-text">Au moins un caractère spécial (@$!%*#?&)</span>
                                    </div>
                                    <div class="requirement-item" data-requirement="different">
                                        <span class="requirement-icon">✕</span>
                                        <span class="requirement-text">Différent du mot de passe actuel</span>
                                    </div>
                                    <div class="requirement-item" data-requirement="match">
                                        <span class="requirement-icon">✕</span>
                                        <span class="requirement-text">Les mots de passe correspondent</span>
                                    </div>
                                    <div class="password-strength">
                                        <div class="strength-meter" id="strengthMeter"></div>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <button class="btn btn-primary d-grid w-100" type="submit">Modifier le mot de
                                        passe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /Register -->
                </div>
            </div>
        </div>

        <!-- / Content -->

    @endsection

    @section('css')
        <style>
            /* Logout button styles */
            .logout-btn {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 10px 20px;
                background-color: #ff4757;
                border: 1px solid #e03140;
                border-radius: 6px;
                cursor: pointer;
                font-family: system-ui, -apple-system, sans-serif;
                font-size: 14px;
                color: #fff;
                transition: all 0.2s ease;
                position: absolute;
                right: 1rem;
                top: 1rem;
                z-index: 9999;
            }

            /* Hover effect */
            .logout-btn:hover:not(:disabled) {
                background-color: #ff6b81;
                box-shadow: 0 2px 4px rgba(255, 71, 87, 0.2);
                transform: translateY(-1px);
            }

            /* Disabled button */
            .logout-btn:disabled {
                opacity: 0.7;
                cursor: not-allowed;
            }

            /* SVG icon */
            .logout-btn svg {
                width: 16px;
                height: 16px;
            }

            /* Spinner (Initially Hidden) */
            .spinner {
                display: none;
                /* Ensures it is hidden initially */
                width: 16px;
                height: 16px;
                border: 2px solid #dee2e6;
                border-top: 2px solid #ffffff;
                /* White spinner */
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            /* Spinner Animation */
            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }




            /* Password requirements */
            .password-requirements {
                margin-top: 0.5rem;
                font-size: 0.875rem;
                color: #6c757d;
                margin-bottom: 1rem;
            }

            .requirement-item {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 0.25rem;
            }

            .requirement-icon {
                width: 16px;
                height: 16px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .requirement-icon.valid {
                color: #28a745;
            }

            .requirement-icon.invalid {
                color: #dc3545;
            }

            .requirement-text {
                font-size: 0.8125rem;
            }

            .password-strength {
                height: 4px;
                background-color: #e9ecef;
                border-radius: 2px;
                margin-top: 0.5rem;
            }

            .strength-meter {
                height: 100%;
                width: 0;
                border-radius: 2px;
                transition: all 0.3s ease;
            }

            .strength-weak {
                background-color: #dc3545;
            }

            .strength-medium {
                background-color: #ffc107;
            }

            .strength-strong {
                background-color: #28a745;
            }
        </style>
    @endsection

    @section('js')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const logoutForm = document.getElementById('logoutForm');
                const logoutButton = document.getElementById('logoutButton');
                const spinner = document.getElementById('spinner');
                const svg = document.getElementById('logoutIcon'); // Select the icon correctly
                const text = document.getElementById('logoutText'); // Select the text correctly

                // Ensure the button is enabled on page load
                logoutButton.disabled = false;
                spinner.style.display = 'none';
                svg.style.display = 'inline-block';
                text.style.display = 'inline-block';

                // Add event listener to submit form
                logoutForm.addEventListener('submit', function(e) {
                    // Disable the button to prevent multiple clicks
                    logoutButton.disabled = true;

                    // Hide the icon and text
                    svg.style.display = 'none';
                    text.style.display = 'none';

                    // Show the spinner
                    spinner.style.display = 'block';
                });
            });
        </script>
        <script>
            // for the password validation check
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const actualPasswordInput = document.getElementById('actual_pass');
            const requirementItems = document.querySelectorAll('.requirement-item');
            const strengthMeter = document.getElementById('strengthMeter');
            const submitButton = document.querySelector('button[type="submit"]');

            function updateRequirement(requirement, isValid) {
                const item = document.querySelector(`[data-requirement="${requirement}"]`);
                const icon = item.querySelector('.requirement-icon');

                icon.textContent = isValid ? '✓' : '✕';
                icon.className = `requirement-icon ${isValid ? 'valid' : 'invalid'}`;
            }

            function validatePassword() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                const actualPassword = actualPasswordInput.value;

                // Validate minimum length
                updateRequirement('length', password.length >= 12);

                // Validate number
                updateRequirement('number', /[0-9]/.test(password));

                // Validate special character
                updateRequirement('special', /[@$!%*#?&]/.test(password));

                // Validate different from current password
                updateRequirement('different', password !== actualPassword && actualPassword !== '');

                // Validate passwords match
                updateRequirement('match', password === confirmPassword && password !== '');

                // Update strength meter
                let strength = 0;
                if (password.length >= 12) strength += 25;
                if (/[0-9]/.test(password)) strength += 25;
                if (/[@$!%*#?&]/.test(password)) strength += 25;
                if (/[A-Z]/.test(password)) strength += 25;

                strengthMeter.style.width = `${strength}%`;
                if (strength <= 25) {
                    strengthMeter.className = 'strength-meter strength-weak';
                } else if (strength <= 75) {
                    strengthMeter.className = 'strength-meter strength-medium';
                } else {
                    strengthMeter.className = 'strength-meter strength-strong';
                }

                // Enable/disable submit button based on all requirements being met
                const allRequirementsMet = Array.from(requirementItems).every(
                    item => item.querySelector('.requirement-icon').textContent === '✓'
                );
                submitButton.disabled = !allRequirementsMet;
            }

            // Add event listeners
            passwordInput.addEventListener('input', validatePassword);
            confirmPasswordInput.addEventListener('input', validatePassword);
            actualPasswordInput.addEventListener('input', validatePassword);

            // Initial validation
            validatePassword();
        </script>
    @endsection
</x-guest-layout>
