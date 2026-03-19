<x-app-layout>
    @section('title', "MyAfia Imprimer une fiche d'autorisation")
    @section('css')
        <link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
        <!-- Sweetalerts CSS -->
        <link rel="stylesheet" href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css">
        <style>
            /* Variables CSS */
            :root {
                --primary-color: #0D6EFD;
                --secondary-color: #003B73;
                --accent-color: #0A58CA;
                --light-bg: #f8f9fa;
                --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                --hover-shadow: 0 15px 40px rgba(67, 97, 238, 0.15);
                --transition-smooth: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            /* Animations principales */
            @keyframes slideInRight {
                0% {
                    opacity: 0;
                    transform: translateX(80px) scale(0.95);
                    filter: blur(5px);
                }
                100% {
                    opacity: 1;
                    transform: translateX(0) scale(1);
                    filter: blur(0);
                }
            }

            @keyframes slideInUp {
                0% {
                    opacity: 0;
                    transform: translateY(50px) rotateX(-10deg);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) rotateX(0);
                }
            }

            @keyframes floatIn {
                0% {
                    opacity: 0;
                    transform: translateY(40px) scale(0.9);
                }
                70% {
                    transform: translateY(-5px) scale(1.02);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            @keyframes fadeIn {
                0% {
                    opacity: 0;
                    transform: translateY(20px);
                }
                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes glow {
                0%, 100% {
                    box-shadow: 0 5px 20px rgba(67, 97, 238, 0.2);
                }
                50% {
                    box-shadow: 0 8px 30px rgba(67, 97, 238, 0.4);
                }
            }

            @keyframes shimmer {
                0% {
                    background-position: -200% center;
                }
                100% {
                    background-position: 200% center;
                }
            }

            /* Styles principaux */
            .main-content {
                background: linear-gradient(135deg, #f5f7ff 0%, #f0f2ff 100%);
                min-height: 100vh;
            }

            .right_side {
                background: linear-gradient(145deg, #ffffff, #f8f9ff);
                border-radius: 20px;
                box-shadow: var(--card-shadow);
                border: 1px solid rgba(255, 255, 255, 0.8);
                overflow: hidden;
                position: relative;
                transition: var(--transition-smooth);
            }

            .right_side::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
                animation: shimmer 3s infinite linear;
                background-size: 200% auto;
            }

            .right_side:hover {
                transform: translateY(-5px);
                box-shadow: var(--hover-shadow);
            }

            /* Animation d'entrée principale */
            .slide-in-right {
                animation: slideInRight 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
                opacity: 0;
            }

            /* Style des cartes de membres */
            .box_item {
                width: 13.42%;
                background: white;
                border-radius: 16px;
                padding: 15px;
                box-shadow: var(--card-shadow);
                transition: var(--transition-smooth);
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.9);
                opacity: 1;
                animation:  0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            }

            .box_item::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .box_item:hover {
                transform: translateY(-10px) scale(1.03);
                box-shadow: var(--hover-shadow);
                animation: glow 2s infinite;
            }

            .box_item:hover::before {
                transform: scaleX(1);
            }

            .box_item img {
                width: 100%;
                height: 120px;
                object-fit: cover;
                border-radius: 12px;
                margin-bottom: 15px;
                transition: var(--transition-smooth);
                filter: grayscale(20%);
            }

            .box_item:hover img {
                transform: scale(1.05);
                filter: grayscale(0%);
            }

            /* Animation des éléments textuels */
            .fade-in {
                opacity: 0;
                animation: fadeIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
            }

            /* Style du bouton */
            .print_family_file {
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                border: none;
                border-radius: 50px;
                padding: 12px 30px;
                color: white;
                font-weight: 600;
                transition: var(--transition-smooth);
                position: relative;
                overflow: hidden;
            }

            .print_family_file::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.7s;
            }

            .print_family_file:hover::before {
                left: 100%;
            }

            .print_family_file:hover {
                transform: translateY(-3px) scale(1.05);
                box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
            }

            /* Style des blocs d'information */
            .pi_right_block {
                background: linear-gradient(135deg, rgba(248, 249, 255, 0.8), rgba(255, 255, 255, 0.9));
                border-radius: 12px;
                padding: 15px;
                margin-bottom: 15px;
                border-left: 4px solid var(--primary-color);
                transition: var(--transition-smooth);
            }

            .pi_right_block:hover {
                transform: translateX(5px);
                border-left-color: var(--accent-color);
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            }

            .pi_right_block strong {
                color: var(--secondary-color);
                font-size: 0.85rem;
                display: block;
                margin-bottom: 5px;
                font-weight: 600;
            }

            .pi_right_block span {
                color: #333;
                font-size: 1rem;
                font-weight: 500;
            }

            /* Avatar du patient */
            .pi_left_img {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                object-fit: cover;
                border: 5px solid white;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                transition: var(--transition-smooth);
            }

            .pi_left_img:hover {
                transform: rotate(5deg) scale(1.05);
                box-shadow: 0 15px 40px rgba(67, 97, 238, 0.2);
            }

            /* Date de naissance */
            .birth_p {
                background: linear-gradient(135deg, #e0e7ff, #dbe4ff);
                color: var(--secondary-color);
                padding: 8px;
                border-radius: 10px;
                font-weight: 600;
                margin: 10px 0;
                position: relative;
                overflow: hidden;
                transition: var(--transition-smooth);
            }

            /* .birth_p::before {
                content: '🎂';
                margin-right: 8px;
                font-size: 0.9em;
            } */

            /* Titres */
            h5 {
                background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                font-weight: 700;
                font-size: 1.2rem;
                margin-bottom: 20px;
            }

            .patient_name {
                font-size: 1.2rem;
                font-weight: 700;
                color: var(--secondary-color);
                text-align: center;
                margin-top: 15px;
                background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            /* Délais d'animation */
            /* .box_item:nth-child(1) { animation-delay: 0.1s; }
            .box_item:nth-child(2) { animation-delay: 0.2s; }
            .box_item:nth-child(3) { animation-delay: 0.3s; }
            .box_item:nth-child(4) { animation-delay: 0.4s; }
            .box_item:nth-child(5) { animation-delay: 0.5s; }
            .box_item:nth-child(6) { animation-delay: 0.6s; }
            .box_item:nth-child(7) { animation-delay: 0.7s; }
            .box_item:nth-child(8) { animation-delay: 0.8s; }
            .box_item:nth-child(9) { animation-delay: 0.9s; }
            .box_item:nth-child(10) { animation-delay: 1s; }

            .fade-in:nth-child(1) { animation-delay: 0.1s; }
            .fade-in:nth-child(2) { animation-delay: 0.2s; }
            .fade-in:nth-child(3) { animation-delay: 0.3s; }
            .fade-in:nth-child(4) { animation-delay: 0.4s; }
            .fade-in:nth-child(5) { animation-delay: 0.5s; }
            .fade-in:nth-child(6) { animation-delay: 0.6s; }
            .fade-in:nth-child(7) { animation-delay: 0.7s; }
            .fade-in:nth-child(8) { animation-delay: 0.8s; } */

            /* Responsive */
            @media screen and (max-width: 1250px) {
                .box_item { width: 15.8%; }
            }

            @media screen and (max-width: 1072px) {
                .box_item { width: 19.1%; }
                .pi_left { width: 50%; }
                .pi_right { width: 49%; }
            }

            @media screen and (max-width: 900px) {
                .box_item { width: 24.2%; }
                .left_side { width: 25%; }
                .right_side { width: 70%; }
            }

            @media screen and (max-width: 800px) {
                .box_item { width: 24.2%; }
                .left_side, .right_side { width: 100%; }
            }

            @media screen and (max-width: 550px) {
                .box_item {
                    width: 100%;
                    margin-bottom: 20px;
                }
                .pi_left, .pi_right { width: 100%; }
            }

            /* Effet de particules subtil */
            .box_of_item {
                position: relative;
                padding: 20px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 20px;
                margin-top: 30px;
            }

            /* Loader subtil pour les images */
            .pi_left_img.loading,
            .box_item img.loading {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: shimmer 1.5s infinite linear;
            }
        </style>
    @endsection

    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- Breadcrumb avec animation -->
                    <div>
                        <x-breadcrumb.wrapper title="Imprimer une fiche d'autorisation">
                            <x-breadcrumb.item title="Tableau de bord" />
                            <x-breadcrumb.item title="Bureau d'entrée" />
                            <x-breadcrumb.item title="Imprimer" type="active" />
                        </x-breadcrumb.wrapper>
                    </div>

                <!-- Messages de session -->
                <div class="fade-in" style="animation-delay: 0.2s;">
                    <x-sessions.sessionAny />
                    <x-sessions.sessionAlert type="add" />
                    <x-sessions.sessionAlert type="delete" />
                    <x-sessions.sessionAlert type="edit" />
                    <x-sessions.sessionAlert type="error" />
                </div>

                <!-- Section principale -->
                <div>
                    <div class="g-3 mt-0 bg-white mb-3 create_user_form p-4 rounded-1 right_side slide-in-right">
                        <h5 style="font-size: 1.1rem;" class="fade-in">📋 Informations sur le patient (Assuré principal)</h5>
                        <div class="patient_information">
                            <div class="patient_information_wrapper justify-content-between" style="display: none">
                                <!-- Photo et nom -->
                                <div class="pi_left fade-in" style="animation-delay: 0.3s;">
                                    <img class="pi_left_img loading" src="" alt="user avatar" />
                                    <h6 style="font-size: 1rem; margin-top:1rem;" class="patient_name"></h6>
                                </div>

                                <!-- Informations détaillées -->
                                <div class="pi_right">
                                    <!-- Ligne 1 -->
                                    <div class="pi_right_block fade-in" style="animation-delay: 0.4s;">
                                        <strong>🏢 Nom de l'employeur</strong>
                                        <span class="company_name"></span>
                                    </div>

                                    <!-- Ligne 2 - Numéros -->
                                    <div class="d-flex flex-wrap gap-3 mb-3">
                                        <div class="pi_right_block fade-in flex-grow-1" style="animation-delay: 0.5s;">
                                            <strong>🔢 Numéro de l'employeur</strong>
                                            <span class="matricule"></span>
                                        </div>
                                        <div class="pi_right_block fade-in flex-grow-1" style="animation-delay: 0.6s;">
                                            <strong>💳 Numéro de compte assuré</strong>
                                            <span class="matricule_assure"></span>
                                        </div>
                                    </div>

                                    <!-- Ligne 3 - Régimes -->
                                    <div class="d-flex flex-wrap gap-3 mb-3">
                                        <div class="pi_right_block fade-in flex-grow-1" style="animation-delay: 0.7s;">
                                            <strong>🏥 Régime assurance maladie</strong>
                                            <span class="regime_amo_pass"></span>
                                        </div>
                                        <div class="pi_right_block fade-in flex-grow-1" style="animation-delay: 0.8s;">
                                            <strong>👷 Régime travailleur</strong>
                                            <span class="regime"></span>
                                        </div>
                                    </div>

                                    <!-- Ligne 4 - Personnelles -->
                                    <div class="d-flex flex-wrap gap-3 mb-3">
                                        <div class="pi_right_block fade-in flex-grow-1" style="animation-delay: 0.9s;">
                                            <strong>🎂 Date de naissance</strong>
                                            <span class="birth_date"></span>
                                        </div>
                                        <div class="pi_right_block fade-in flex-grow-1" style="animation-delay: 1s;">
                                            <strong>🆔 SSN</strong>
                                            <span class="ssn"></span>
                                        </div>
                                    </div>

                                    <!-- Ligne 5 - Accès -->
                                    <div class="pi_right_block fade-in" style="animation-delay: 1.1s;">
                                        <strong>🩺 Accès au soins</strong>
                                        <span class="care_access" style="background: green; color:white; padding: 5px 8px;"></span>
                                    </div>

                                    <!-- Bouton -->
                                    {{-- <div class="pi_right_block fade-in text-center" style="animation-delay: 1.2s; background: transparent; border: none;">
                                        <button class="btn print_family_file" style="display: none;">
                                            🖨️ Imprimer la fiche familiale
                                        </button>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section des membres -->
                <div class="box_of_item mb-4 fade-in" style="animation-delay: 1.3s;">
                    <h5 class="text-center mb-4" style="color: var(--secondary-color); font-weight: 600;">
                        👨‍👩‍👧‍👦 Membres de la famille
                    </h5>
                    <div class="d-flex flex-wrap justify-content-center gap-4">
                        <!-- Les cartes seront insérées ici dynamiquement -->
                    </div>
                </div>

            </div>
        </div>
        <!-- End::app-content -->

        @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Simulation du contenu retourné par ton contrôleur
                let data = @json($data ?? []);

                if (data.length > 0) {
                    // Animation de la section principale
                    const mainSection = document.querySelector('.right_side');
                    mainSection.classList.add('slide-in-right');

                    // Trouver le patient principal
                    let patientPrincipal = data.find(p => p.RelationCode == "00") ?? data[0];

                    // Mettre à jour les informations du patient
                    const patientImg = document.querySelector('.pi_left_img');
                    patientImg.src = patientPrincipal.Photo || "/assets/images/default-avatar.png";
                    patientImg.classList.remove('loading');

                    document.querySelector('.patient_name').textContent = patientPrincipal["Nom AX"] || patientPrincipal.Nom || "";
                    document.querySelector('.company_name').textContent = patientPrincipal["Nom de l'employeur"] || "Non spécifié";
                    document.querySelector('.matricule').textContent = patientPrincipal["Compte Cotisant"] || "N/A";
                    document.querySelector('.matricule_assure').textContent = patientPrincipal["Compte Assuré"] || "N/A";
                    document.querySelector('.regime_amo_pass').textContent = patientPrincipal["Regime Travailleur"] || "Non spécifié";
                    document.querySelector('.regime').textContent = patientPrincipal.Regime || "Non spécifié";
                    document.querySelector('.birth_date').textContent = patientPrincipal["Date de naissance"] || "Non spécifiée";
                    document.querySelector('.ssn').textContent = patientPrincipal.SSN || "N/A";
                    document.querySelector('.care_access').textContent = patientPrincipal.Acces_soin || "Non spécifié";

                    // Afficher le bloc principal avec effet
                    const patientWrapper = document.querySelector('.patient_information_wrapper');
                    patientWrapper.style.display = "flex";
                    setTimeout(() => {
                        patientWrapper.style.opacity = "1";
                        patientWrapper.style.transform = "translateY(0)";
                    }, 100);

                    // Bouton d'impression famille
                    let canPrintFamily = @json($canprintfamily);
                    const printBtn = document.querySelector('.print_family_file');
                    if (canPrintFamily == 1 && printBtn) {
                        printBtn.style.display = "inline-block";
                        setTimeout(() => {
                            printBtn.style.opacity = "1";
                            printBtn.style.transform = "translateY(0)";
                        }, 1300);
                    }

                    // --------------- AFFICHAGE DES MEMBRES ---------------
                    const container = document.querySelector('.box_of_item .d-flex');

                    // Attendre l'animation de la section principale
                    setTimeout(() => {
                        data.forEach((member, index) => {
                            // Créer la carte
                            const card = document.createElement('div');
                            card.className = 'box_item';
                            card.style.animationDelay = `${0.3 + (index * 0.1)}s`;

                            // Relation avec une icône
                            let relationIcon = "👤";
                            switch(member.RelationCode) {
                                case "00": relationIcon = "👨‍💼"; break; // Principal
                                case "01": relationIcon = "👰"; break;  // Conjoint
                                case "02": relationIcon = "👶"; break;  // Enfant
                                case "03": relationIcon = "👵"; break;  // Parent
                                default: relationIcon = "👤";
                            }

                            card.innerHTML = `
                                <img src="${member.Photo || '/assets/images/default-avatar.png'}"
                                     class="loading"
                                     onload="this.classList.remove('loading')"
                                     alt="${member.Nom}">
                                <p style="font-size:.9rem; text-align:center; font-weight:bold; margin-bottom:8px;">
                                    ${member.Nom}
                                </p>
                                <p class="birth_p">${member["Date de naissance"] || "Non spécifiée"}</p>

                                <p style="font-size:.8rem; text-align:center; color:#4361ee;">
                                    🆔 SSN: ${member.SSN || "N/A"}
                                </p>
                                <a class="btn btn-primary-light btn-wave print_fiche"  ">Imprimer</a>
                            `;

                            // <p style="font-size:.8rem; text-align:center; color:#666;">
                            //         ${relationIcon} Relation: ${member.RelationCode}
                            //     </p>
                            container.appendChild(card);
                        });
                    }, 500);

                    // Effet de hover sur les blocs d'information
                    document.querySelectorAll('.pi_right_block').forEach(block => {
                        block.addEventListener('mouseenter', function() {
                            this.style.transform = 'translateX(5px)';
                        });

                        block.addEventListener('mouseleave', function() {
                            this.style.transform = 'translateX(0)';
                        });
                    });
                }
            });
        </script>
        @endsection
    @endsection
</x-app-layout>
