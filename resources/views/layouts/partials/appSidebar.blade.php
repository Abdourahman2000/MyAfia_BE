        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar">

            <!-- Start::main-sidebar-header -->
            <div class="main-sidebar-header">
                <a href="index.html" class="header-logo">
                    <img src="{{ asset('assets') }}/images/brand-logos/desktop-logo.png" alt="logo"
                        class="desktop-logo">
                    <img src="{{ asset('assets') }}/images/brand-logos/toggle-logo.png" alt="logo"
                        class="toggle-logo">
                    <img src="{{ asset('assets') }}/images/brand-logos/desktop-white.png" alt="logo"
                        class="desktop-white">
                    <img src="{{ asset('assets') }}/images/brand-logos/toggle-white.png" alt="logo"
                        class="toggle-white">
                </a>
            </div>
            <!-- End::main-sidebar-header -->

            <!-- Start::main-sidebar -->
            <div class="main-sidebar" id="sidebar-scroll">

                <!-- Start::nav -->
                <nav class="main-menu-container nav nav-pills flex-column sub-open">
                    <div class="slide-left" id="slide-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                            viewBox="0 0 24 24">
                            <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                        </svg>
                    </div>
                    <ul class="main-menu">
                        <!-- Start::slide__category -->
                        <x-sidebar.category title="Main" />
                        <!-- End::slide__category -->

                        <x-sidebar.single title="Tableau de bord" icon="home-2" link="{{ route('dashboard') }}" />


                        @if (Auth::user()->type == 'admin' || Auth::user()->type == 'super_admin')
                            <!-- Start::slide Utilisateurs -->
                            <x-sidebar.sub.multiple1 title="Utilisateurs" icon="users">
                                <x-sidebar.sub.multiple1single title="Créer" link="{{ route('users.create') }}" />
                                <x-sidebar.sub.multiple1single title="Liste des utilisateurs"
                                    link="{{ route('users.index') }}" />
                            </x-sidebar.sub.multiple1>
                            <!-- End::slide Utilisateurs -->

                            <!-- Start::slide Exception -->
                            <x-sidebar.sub.multiple1 title="Exception" icon="alert-triangle">
                                <x-sidebar.sub.multiple1single title="Acces aux soins Patient"
                                    link="{{ route('exception.create') }}" />
                                <x-sidebar.sub.multiple1single title="Acces aux soins Employeur"
                                    link="{{ route('exception.employer.create') }}" />
                            </x-sidebar.sub.multiple1>
                            <!-- End::slide Exception -->

                            <!-- Start::slide Places -->
                            <x-sidebar.single title="Places" icon="map-pin" link="{{ route('places.index') }}" />
                            <!-- End::slide Places -->
                        @elseif (Auth::user()->canexcept)
                            <!-- Start::slide Exception uniquement pour les utilisateurs avec le rôle "canexcept" -->
                            <x-sidebar.sub.multiple1 title="Exception" icon="alert-triangle">
                                <x-sidebar.sub.multiple1single title="Acces aux soins Patient"
                                    link="{{ route('exception.create') }}" />
                                <x-sidebar.sub.multiple1single title="Acces aux soins Employeur"
                                    link="{{ route('exception.employer.create') }}" />
                            </x-sidebar.sub.multiple1>
                            <!-- End::slide Exception -->
                        @endif


                        <!-- Start::slide -->
                        <x-sidebar.sub.multiple1 title="Bureau d'entrée" icon="clipboard-list">

                            <x-sidebar.sub.multiple1single title="Imprimer" link="{{ route('entry.create') }}" />

                            <x-sidebar.sub.multiple1single title="Fiche d'autorisation"
                                link="{{ route('entry.index') }}" />
                        </x-sidebar.sub.multiple1>

                        <!-- End::slide -->

                        <x-sidebar.single title="Recherche avancée" icon="search"
                            link="{{ route('entry.search') }}" />

                            <!-- Start::BIOMÉTRIE -->
                        <x-sidebar.sub.multiple1 title="Biométrie" icon="scan">

                            <x-sidebar.sub.multiple1single title="Visage"
                                link="{{ route('biometrie.face') }}"  icon="face-id" />

                            <x-sidebar.sub.multiple1single title="Empreinte"
                                link="{{ route('biometrie.empreinte') }}" icon="fingerprint" />
                        </x-sidebar.sub.multiple1>
                        <!-- End::BIOMÉTRIE -->

                    </ul>
                    <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                            width="24" height="24" viewBox="0 0 24 24">
                            <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                        </svg>
                    </div>
                </nav>
                <!-- End::nav -->

            </div>
            <!-- End::main-sidebar -->

        </aside>
        <!-- End::app-sidebar -->
