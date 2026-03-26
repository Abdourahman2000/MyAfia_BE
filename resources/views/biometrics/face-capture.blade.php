<x-app-layout>
    @section('title', 'Capture Visage')
    @section('css')
        <style>
            :root {
                --primary-color: #0D6EFD;
                --secondary-color: #003B73;
                --accent-color: #0A58CA;
                --light-bg: #f8f9fa;
                --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                --hover-shadow: 0 15px 40px rgba(67, 97, 238, 0.15);
                --transition-smooth: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            }

            .biometric-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }

            .status-indicator {
                display: flex;
                align-items: center;
                gap: 8px;
                font-weight: 600;
                padding: 8px 16px;
                border-radius: 20px;
                background: #fef2f2;
            }

            .status-connected {
                color: #10b981;
                background: #f0fdf4;
            }

            .status-disconnected {
                color: #ef4444;
                background: #fef2f2;
            }

            .status-connecting {
                color: #f59e0b;
                background: #fffbeb;
            }

            /* ... existing colors ... */

            .biometric-card {
                background: #ffffff;
                border-radius: 16px;
                padding: 30px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                margin-bottom: 30px;
            }

            /* ===== LAYOUT GLOBAL ===== */
            .capture-layout {
                display: grid;
                grid-template-columns: 2.2fr 1fr;
                gap: 30px;
                margin-top: 30px;
                align-items: start;
            }

            @media (max-width: 1200px) {
                .capture-layout {
                    grid-template-columns: 1fr;
                }
            }

            /* ===== CARTES ===== */
            .card {
                background: white;
                border-radius: 16px;
                padding: 25px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
            }

            .card h3 {
                font-size: 1.3rem;
                margin-bottom: 20px;
                border-bottom: 2px solid #4099ff;
                padding-bottom: 10px;
                color: #2c3e50;
            }

            .card h4 {
                font-size: 1.1rem;
                margin-bottom: 15px;
                color: #4099ff;
            }

            /* ===== SECTION CAPTURE ===== */
            .capture-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 25px;
            }

            @media (max-width: 768px) {
                .capture-row {
                    grid-template-columns: 1fr;
                }
            }

            /* ===== WEBCAM & CAPTURE CONTAINERS ===== */
            .video-container,
            .capture-container {
                position: relative;
                aspect-ratio: 4 / 3;
                width: 100%;
                border-radius: 12px;
                overflow: hidden;
                border: 3px solid #4099ff;
                margin-bottom: 15px;
            }

            .capture-container {
                border: 2px dashed #d1d5db;
                border-color: #d1d5db;
                /* Explicitly set border color */
            }

            video {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* ===== CAPTURE ===== */
            .capture-container {
                aspect-ratio: 4 / 3;
                border-radius: 12px;
                background: #f9fafb;
                border: 3px dashed #d1d5db;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                margin-bottom: 15px;
            }

            #captured-image {
                display: none;
                width: 100%;
                height: 100%;
                object-fit: contain;
                border-radius: 8px;
            }

            .placeholder-text {
                color: #6b7280;
                text-align: center;
                padding: 20px;
            }

            .placeholder-text i {
                font-size: 48px;
                margin-bottom: 10px;
                display: block;
                color: #cbd5e1;
            }

            /* ===== BOUTONS ===== */
            .btn-container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .btn {
                padding: 14px;
                border-radius: 10px;
                border: none;
                color: white;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                font-size: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
                transform: none !important;
                box-shadow: none !important;
            }

            .btn:hover:not(:disabled) {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .btn:active:not(:disabled) {
                transform: translateY(0);
            }

            .btn-start {
                background: #4099ff;
                box-shadow: 0 2px 6px rgba(64, 153, 255, 0.25);
            }

            .btn-start:hover {
                background: #1f7de9ff;
                color: white;
                box-shadow: 0 2px 6px rgba(64, 153, 255, 0.25);
            }

            .btn-stop {
                background: #FF5370;
                box-shadow: 0 2px 6px rgba(255, 83, 112, 0.25);
            }

            .btn-stop:hover {
                background: #ec1b3eff;
                color: white;
                box-shadow: 0 2px 6px rgba(255, 83, 112, 0.25);
            }

            .btn-capture {
                background: #2ed8b6;
                box-shadow: 0 2px 6px rgba(46, 216, 182, 0.25);
            }

            .btn-capture:hover {
                background: #0fb191ff;
                color: white;
                box-shadow: 0 2px 6px rgba(46, 216, 182, 0.25);
            }

            .btn-identify {
                background: #9b59b6;
                box-shadow: 0 2px 6px rgba(155, 89, 182, 0.25);
            }

            .btn-identify:hover {
                background: #8122a6ff;
                color: white;
                box-shadow: 0 2px 6px rgba(155, 89, 182, 0.25);
            }

            .btn-capture:disabled,
            .btn-identify:disabled {
                background: #ffffff !important;
                color: #cbd5e1 !important;
                border: none;
                opacity: 1 !important;
            }

            /* ===== METRIQUES ===== */
            .metric-line {
                display: flex;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px dashed #e5e7eb;
                font-size: 12px;
                transition: all 0.3s ease;
            }

            .metric-line:last-child {
                border-bottom: none;
            }

            .metric-label {
                color: #4b5563;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .metric-label i {
                font-size: 18px;
                width: 24px;
            }

            .metric-value {
                font-weight: 700;
                min-width: 60px;
                text-align: right;
                color: #4099ff;
            }

            /* ===== CANVAS OVERLAY ===== */
            #overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
            }

            .video-placeholder {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: #f3f4f6;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                color: #6b7280;
                font-weight: 500;
                z-index: 5;
            }

            #canvas {
                display: none;
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
                animation: 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
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
                /* transform: translateY(-10px) scale(1.03); */
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

            .box_item img.loading {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: shimmer 1.5s infinite linear;
            }

            .box_of_item {
                position: relative;
                padding: 20px;
                margin: 30px 0 20px;
                background: rgba(255, 255, 255, 0.5);
                border-radius: 20px;
            }

            .box_of_item h3 {
                background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                font-weight: 700;
                font-size: 1.5rem;
                border-bottom: 2px solid var(--primary-color);
                padding-bottom: 10px;
            }

            /* ===== PATIENT INFORMATION CARD ===== */
            .patient_info_card {
                max-width: 78%;
                width: 100%;
                background: linear-gradient(145deg, #ffffff, #f8f9ff);
                border-radius: 20px;
                box-shadow: var(--card-shadow);
                border: 1px solid rgba(255, 255, 255, 0.8);
                padding: 20px;
                margin-bottom: 20px;
                position: relative;
                overflow: hidden;
                transition: var(--transition-smooth);
            }

            .patient_info_card h5 {
                background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                font-weight: 700;
                font-size: 1.1rem;
                margin-bottom: 20px;
            }

            .patient_information_wrapper {
                display: flex;
                gap: 10px;
            }

            .pi_left {
                display: flex;
                flex-direction: column;
                align-items: center;
                min-width: 40px;
            }

            .pi_left_img {
                width: 120px;
                height: 120px;
                border-radius: 20px;
                object-fit: cover;
                border: 5px solid white;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .pi_left_img:hover {
                box-shadow: 0 15px 40px rgba(67, 97, 238, 0.2);
            }

            .patient_name {
                font-size: 15px;
                font-weight: 700;
                color: var(--secondary-color);
                text-align: center;
                margin-top: 15px;
                background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .pi_right {
                flex: 1;
            }

            .pi_right_block strong {
                color: var(--secondary-color);
                font-size: 15px;
                display: block;
                /* margin-bottom: 5px; */
                font-weight: 300;
            }

            .pi_right_block span {
                color: #333;
                font-size: 15px;
                font-weight: 500;
            }

            .care_access_badge {
                display: inline-block;
                padding: 5px 15px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 0.9rem;
            }

            .care_access_badge.access-yes {
                background: #10b981;
                color: white;
            }

            .care_access_badge.access-no {
                background: #ef4444;
                color: white;
            }
        </style>
    @endsection

    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- HEADER -->
                <div class="biometric-header">
                    <x-biometric-header title="Reconnaissance Faciale" description="Capture du visage pour l'identification"
                        icon="ti ti-scan" />

                    <div id="statusIndicator" class="status-indicator status-connecting">
                        <i class="ti ti-wifi"></i>
                        <span>En cours...</span>
                    </div>
                </div>

                {{-- <div class="alert-container" id="alert-container"></div> --}}

                <div class="capture-layout">

                    <!-- ================= GAUCHE : CAPTURE ================= -->
                    <div class="card">
                        <h3><i class="ti ti-camera"></i> Capture Visage</h3>

                        <div class="capture-row">

                            <!-- Webcam -->
                            <div>
                                <h4><i class="ti ti-video"></i> Webcam</h4>
                                <div class="video-container" id="video-container">
                                    {{-- <div class="detection-status status-loading" id="detection-status">
                                        <i class="ti ti-loader"></i> Chargement...
                                    </div> --}}
                                    <div id="videoPlaceholder" class="video-placeholder">
                                        Démarrer la caméra
                                    </div>
                                    <img id="video"
                                        style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                    <canvas id="overlay"></canvas>
                                    <canvas id="canvas"></canvas>
                                </div>
                                <div class="btn-container" id="btnContainer">
                                </div>
                            </div>

                            <!-- Capture -->
                            <div>
                                <h4><i class="ti ti-photo"></i> Photo capturée</h4>
                                <div class="capture-container" id="capture-container">
                                    <div id="placeholder" class="placeholder-text">
                                        <i class="ti ti-photo-off"></i>
                                        La photo apparaîtra ici
                                    </div>
                                    <img id="captured-image" alt="Photo capturée">
                                </div>
                                <button id="identifyBtn" class="btn btn-identify" disabled>
                                    <i class="ti ti-search"></i> Identifier
                                </button>
                                <div id="capture-metrics" style="margin-top: 15px; display: none;">
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ================= DROITE : METRIQUES ================= -->
                    <div class="card">
                        <h3><i class="ti ti-chart-line"></i> Métriques Innovatrics</h3>

                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-face-id"></i> Visage détecté</span>
                            <span class="metric-value bad" id="m-face">0</span>
                        </div>
                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-brightness"></i> Clarté</span>
                            <span class="metric-value neutral" id="m-clarity">0%</span>
                        </div>
                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-sun"></i> Luminosité</span>
                            <span class="metric-value warning" id="m-brightness">0%</span>
                        </div>
                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-contrast"></i> Contraste</span>
                            <span class="metric-value neutral" id="m-contrast">0%</span>
                        </div>
                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-heartbeat"></i> Liveness</span>
                            <span class="metric-value bad" id="m-liveness">-</span>
                        </div>
                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-calendar-time"></i> Âge</span>
                            <span class="metric-value bad" id="m-age">-</span>
                        </div>
                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-gender-bigender"></i> Genre</span>
                            <span class="metric-value bad" id="m-gender">-</span>
                        </div>
                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-eyeglass"></i> Lunettes</span>
                            <span class="metric-value bad" id="m-glasses">-</span>
                        </div>
                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-eyeglass"></i> Bouches</span>
                            <span class="metric-value bad" id="m-mouth">-</span>
                        </div>
                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-eyeglass"></i> Oeil Droite</span>
                            <span class="metric-value bad" id="m-right-eye">-</span>
                        </div>
                        <div class="metric-line">
                            <span class="metric-label"><i class="ti ti-eyeglass"></i> Oeil Gauche</span>
                            <span class="metric-value bad" id="m-left-eye">-</span>
                        </div>

                        <!-- Progress bars supplémentaires (optionnel) -->
                        {{-- <div class="metric-progress" style="margin-top: 20px; display: none;">
                            <div id="progress-clarity" class="progress-bar" style="width: 0%; background: #4099ff;"></div>
                        </div>
                        <div class="metric-progress" style="margin-top: 5px; display: none;">
                            <div id="progress-brightness" class="progress-bar" style="width: 0%; background: #FFB64D;">
                            </div>
                        </div> --}}
                    </div>

                </div>

                <div id="identification-result" class="box_of_item" style="display: none;">
                    <h3>
                        <i class="ti ti-user"></i> Résultat de l'identification
                    </h3>

                    <!-- Patient Information Card (Assuré principal) -->
                    <div id="patient-info-card" class="patient_info_card" style="display: none;">
                        <h5>Informations sur le patient (Assuré principal)</h5>
                        <div class="patient_information_wrapper">
                            <!-- Photo et nom -->
                            <div class="pi_left">
                                <img class="pi_left_img" id="pi-avatar" src="" alt="user avatar" />
                                <h6 class="patient_name" id="pi-name"></h6>
                            </div>

                            <!-- Informations détaillées -->
                            <div class="pi_right">
                                <div class="pi_right_block">
                                    <strong>Nom de l'employeur</strong>
                                    <span id="pi-company"></span>
                                </div>

                                <div class="d-flex flex-wrap gap-3">
                                    <div class="pi_right_block flex-grow-1">
                                        <strong>Numéro de l'employeur</strong>
                                        <span id="pi-matricule"></span>
                                    </div>
                                    <div class="pi_right_block flex-grow-1">
                                        <strong>Numéro de compte assuré</strong>
                                        <span id="pi-matricule-assure"></span>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-3">
                                    <div class="pi_right_block flex-grow-1">
                                        <strong>Régime assurance maladie</strong>
                                        <span id="pi-regime-amo"></span>
                                    </div>
                                    <div class="pi_right_block flex-grow-1">
                                        <strong>Régime travailleur</strong>
                                        <span id="pi-regime"></span>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-3 mb-3">
                                    <div class="pi_right_block flex-grow-1">
                                        <strong>Date de naissance</strong>
                                        <span id="pi-birth-date"></span>
                                    </div>
                                    <div class="pi_right_block flex-grow-1">
                                        <strong>SSN</strong>
                                        <span id="pi-ssn"></span>
                                    </div>
                                </div>

                                <div class="pi_right_block">
                                    <strong>Accès au soins</strong>
                                    <span id="pi-care-access" class="care_access_badge"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Beneficiary Information Card (Assuré principal) -->
                    <div id="result-content" style="padding: 20px;">

                    </div>
                </div>
            </div>
        </div>
        <!-- End::app-content -->
    @endsection

    @section('js')
        <script>
            const statusIndicator = document.getElementById('statusIndicator');
            const btnContainer = document.getElementById('btnContainer');

            // Inject buttons
            btnContainer.innerHTML = `
                <button id="startBtn" class="btn btn-start">
                    <i class="ti ti-video"></i> Démarrer
                </button>
                <button id="captureBtn" class="btn btn-capture" disabled>
                    <i class="ti ti-camera"></i> Capturer
                </button>
            `;

            const startBtn = document.getElementById('startBtn');
            const captureBtn = document.getElementById('captureBtn');
            const video = document.getElementById('video');
            const videoPlaceholder = document.getElementById('videoPlaceholder');
            const capturedImage = document.getElementById('captured-image');
            const placeholder = document.getElementById('placeholder');
            const identifyBtn = document.getElementById('identifyBtn');
            const overlay = document.getElementById('scanOverlay');
            const scanImage = document.querySelector('.scan-image');
            const scanLine = document.querySelector('.scan-line');
            const identificationResult = document.getElementById('identification-result');
            let isRunning = false;
            let scanning = false;
            let ws = null;
            let wsRetries = 0;

            function connectWebSocket() {
                if (ws && (ws.readyState === WebSocket.OPEN || ws.readyState === WebSocket.CONNECTING)) {
                    return;
                }

                // Use 'wss' protocol and port 8443 as requested
                ws = new WebSocket('wss://localhost:8443/ws/biometric-events');

                ws.onopen = () => {
                    console.log('WebSocket Connected');
                    setStatus('status-connected', 'Connecté', 'ti ti-wifi');
                    wsRetries = 0;
                };

                ws.onmessage = (event) => {
                    try {
                        const data = JSON.parse(event.data);
                        handleWebSocketMessage(data);
                    } catch (e) {
                        console.error('Error parsing WS message', e);
                    }
                };

                ws.onerror = (error) => {
                    console.error('WebSocket Error', error);
                    setStatus('status-disconnected', 'Erreur', 'ti ti-alert-circle');
                };

                ws.onclose = () => {
                    console.log('WebSocket Closed');
                    setStatus('status-disconnected', 'Déconnecté', 'ti ti-wifi-off');
                    ws = null;
                    // Auto-reconnect if supposed to be running
                    if (isRunning && wsRetries < 5) {
                        setTimeout(() => {
                            wsRetries++;
                            connectWebSocket();
                        }, 2000);
                    }
                };
            }

            function disconnectWebSocket() {
                if (ws) {
                    ws.close();
                    ws = null;
                }
            }

            // Déconnecter le WebSocket quand on quitte la page
            window.addEventListener('beforeunload', () => {
                stopLive();
            });

            function setStatus(type, text, icon) {
                statusIndicator.classList.remove(
                    'status-connected',
                    'status-disconnected',
                    'status-connecting'
                );

                statusIndicator.classList.add(type);
                statusIndicator.innerHTML = `<i class="${icon}"></i><span>${text}</span>`;
            }

            async function checkStatus() {
                try {
                    const response = await fetch('https://localhost:8443/status-live');
                    const data = await response.json();

                    if (data.running === true) {
                        setStatus('status-connected', 'Connecté', 'ti ti-wifi');
                        updateButtonState(true);
                    } else {
                        setStatus('status-disconnected', 'Déconnecté', 'ti ti-wifi-off');
                        updateButtonState(false);
                    }
                } catch (error) {
                    setStatus('status-disconnected', 'Erreur', 'ti ti-alert-circle');
                    updateButtonState(false);
                }
            }

            function updateButtonState(running) {
                isRunning = running;
                if (running) {
                    startBtn.innerHTML = '<i class="ti ti-player-stop"></i> Arrêter';
                    startBtn.classList.remove('btn-start');
                    startBtn.classList.add('btn-stop');
                    captureBtn.disabled = false;
                    Object.assign(video.style, {
                        display: 'block'
                    });
                    Object.assign(videoPlaceholder.style, {
                        display: 'none'
                    });
                    video.src = 'https://localhost:8443/video-live';
                } else {
                    startBtn.innerHTML = '<i class="ti ti-video"></i> Démarrer';
                    startBtn.classList.remove('btn-stop');
                    startBtn.classList.add('btn-start');
                    captureBtn.disabled = true;
                    Object.assign(video.style, {
                        display: 'none'
                    });
                    Object.assign(videoPlaceholder.style, {
                        display: 'flex'
                    });
                    video.src = '';
                }
            }

            const retrieveMetrics = (message) => {
                let regex = /([^|:]+):\s*([-+]?\d+(?:\.\d+)?)/g;
                const result = {};
                for (const match of message.matchAll(regex)) {
                    const key = match[1].trim();
                    const value = parseFloat(match[2]);
                    result[key] = value;
                }
                return result;
            };

            // Gérer les messages WebSocket
            function handleWebSocketMessage(data) {
                const {
                    type,
                    message
                } = data;

                switch (type) {
                    case 'CAMERA_ERROR':
                        Swal.fire({
                            icon: 'error',
                            title: 'Webcam non détectée',
                            text: 'Veuillez connecter une webcam'
                        });
                        break;
                    case 'QUALITY_METRICS':
                        // Afficher l'aperçu en temps réel
                        const metrics = retrieveMetrics(message);
                        updateUIWithMetrics(metrics);
                        // If we get metrics, it implies a face is detected and processed
                        updateMetric('face', '1', 'good');
                        break;
                    case 'QUALITY_CHECK':
                        if (message.includes('Aucun visage')) {
                            updateMetric('face', '0', 'bad');
                            resetMetrics();
                        } else if (message.includes('Deux visages')) {
                            updateMetric('face', '2', 'warning');
                        } else if (message.includes('Plusieurs visages')) { // Handle potential other messages
                            updateMetric('face', '2+', 'warning');
                        }
                        break;
                    default:
                        console.log('Message non géré:', type, message);
                }
            }

            function updateUIWithMetrics(metrics) {
                if (metrics['Netteté'] !== undefined) updateMetric('clarity', Math.round(metrics['Netteté']), 'neutral');
                if (metrics['Luminosité'] !== undefined) updateMetric('brightness', Math.round(metrics['Luminosité']),
                    'neutral');
                if (metrics['Contraste'] !== undefined) updateMetric('contrast', Math.round(metrics['Contraste']), 'neutral');
                if (metrics['Bouche'] !== undefined) updateMetric('mouth', metrics['Bouche'] > 0 ? "🟩" : "🟥", 'neutral');
                if (metrics['Œil D'] !== undefined) updateMetric('right-eye', metrics['Œil D'] > 0 ? "🟩" : "🟥", 'neutral');
                if (metrics['Œil G'] !== undefined) updateMetric('left-eye', metrics['Œil G'] > 0 ? "🟩" : "🟥", 'neutral');
                if (metrics['Lunettes'] !== undefined) updateMetric('glasses', metrics['Lunettes'] < 0 ? "🟩" : "🟥",
                    'neutral');
                if (metrics['Liveness'] !== undefined) updateMetric('liveness', metrics['Liveness'] > 80 ? "🟩" : "🟥",
                    'neutral');
                if (metrics['Age'] !== undefined) updateMetric('age', Math.round(metrics['Age']), 'neutral');
                if (metrics['Gender'] !== undefined) updateMetric('gender', metrics['Gender'] < 0 ? "Homme" :
                    "<span style='color: pink'>Femme</span>", 'neutral');
            }

            function resetMetrics() {
                updateMetric('clarity', '0%', 'neutral');
                updateMetric('brightness', '0%', 'neutral');
                updateMetric('contrast', '0%', 'neutral');
                updateMetric('mouth', '-', 'neutral');
                updateMetric('right-eye', '-', 'neutral');
                updateMetric('left-eye', '-', 'neutral');
                updateMetric('glasses', '-', 'neutral');
                updateMetric('liveness', '-', 'neutral');
                updateMetric('age', '-', 'neutral');
                updateMetric('gender', '-', 'neutral');
            }

            function updateMetric(id, value, status) {
                const el = document.getElementById('m-' + id);
                if (el) {
                    el.textContent = value;
                    // Reset classes and add new status
                    el.className = 'metric-value ' + status;
                }
            }

            async function stopLive() {
                try {
                    await fetch('https://localhost:8443/stop-live');
                } catch (error) {
                    console.error('Stop failed:', error);
                }
            }

            startBtn.addEventListener('click', async () => {
                if (isRunning) {
                    try {
                        await stopLive();
                        updateButtonState(false);
                    } catch (error) {
                        console.error('Stop failed:', error);
                    }
                    return;
                }

                try {

                    const response = await fetch('https://localhost:8443/start-live');
                    const data = await response.json();

                    if (data.status === 'started') {
                        console.log('started');
                        updateButtonState(true);
                    } else {
                        console.log('data status:', data.status);
                    }

                } catch (error) {
                    console.log('error:', error);
                }
            });

            captureBtn.addEventListener('click', async () => {
                if (!isRunning) return;

                identificationResult.style.display = 'none';

                try {
                    const response = await fetch('https://localhost:8443/capture-live');
                    const data = await response.json();

                    if (data.image) {
                        // Display image
                        // Check if base64 prefix is present, if not add it
                        const base64Image = data.image.startsWith('data:image') ? data.image :
                            `data:image/jpeg;base64,${data.image}`;

                        capturedImage.src = base64Image;
                        capturedImage.style.display = 'block';
                        identifyBtn.disabled = false;
                        placeholder.style.display = 'none';

                        const captureMetrics = document.getElementById('capture-metrics');

                        if (data.metrics) {

                            captureMetrics.innerHTML = "";
                            captureMetrics.style.display = "block";

                            const m = data.metrics;

                            // Netteté
                            // if (m.sharpness <= 5000) {
                            //     captureMetrics.innerHTML += `
                    //     <div class="metric-line">
                    //         <span class="metric-label">Netteté insuffisante</span>
                    //         <span class="metric-value bad">🟥</span>
                    //     </div>`;
                            // }

                            // // Luminosité (normalisation)
                            // const brightness = ((m.brightness + 10000) / 20000) * 100;
                            // if (brightness < 50 || brightness > 80) {
                            //     captureMetrics.innerHTML += `
                    //     <div class="metric-line">
                    //         <span class="metric-label">Luminosité non idéale</span>
                    //         <span class="metric-value bad">🟥</span>
                    //     </div>`;
                            // }

                            // // Contraste
                            // const contrast = ((m.contrast + 10000) / 20000) * 100;
                            // if (contrast <= 50) {
                            //     captureMetrics.innerHTML += `
                    //     <div class="metric-line">
                    //         <span class="metric-label">Contraste insuffisant</span>
                    //         <span class="metric-value bad">🟥</span>
                    //     </div>`;
                            // }

                            // Liveness
                            if (m.fastPassiveLiveness <= 85) {
                                captureMetrics.innerHTML += `
                                <div class="metric-line">
                                    <span class="metric-label">Liveness insuffisant</span>
                                    <span class="metric-value bad">🟥</span>
                                </div>`;
                            }

                            // Lunettes
                            if (m.glassStatus > 0) {
                                captureMetrics.innerHTML += `
                                <div class="metric-line">
                                    <span class="metric-label">Retirez les lunettes</span>
                                    <span class="metric-value bad">🟥</span>
                                </div>`;
                            }

                            // Œil droit
                            if (m.rightEyeStatus <= 0) {
                                captureMetrics.innerHTML += `
                                <div class="metric-line">
                                    <span class="metric-label">Œil droit fermé</span>
                                    <span class="metric-value bad">🟥</span>
                                </div>`;
                            }

                            // Œil gauche
                            if (m.leftEyeStatus <= 0) {
                                captureMetrics.innerHTML += `
                                <div class="metric-line">
                                    <span class="metric-label">Œil gauche fermé</span>
                                    <span class="metric-value bad">🟥</span>
                                </div>`;
                            }

                            // Bouche (si tu veux bouche fermée)
                            if (m.mouthStatus < 0) {
                                captureMetrics.innerHTML += `
                                <div class="metric-line">
                                    <span class="metric-label">Bouche ouverte</span>
                                    <span class="metric-value bad">🟥</span>
                                </div>`;
                            }

                            // Si aucune erreur
                            if (captureMetrics.innerHTML === "") {
                                captureMetrics.innerHTML = ``;
                            }
                        }


                    } else {
                        console.error('No image data in response');
                        console.log("No image data in response");
                    }

                } catch (error) {
                    console.error('Capture error:', error);
                    console.log("Capture error");
                }
            });

            identifyBtn.addEventListener('click', function() {
                try {
                    sendBiometricData(capturedImage.src);
                } catch (e) {
                    console.error(e);
                }
            });

            const getToken = async () => {
                const response = await fetch("https://10.30.30.22/api/Login/machine-login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        clientId: "service1",
                        clientSecret: "qX7!fL9$2vB#8kP1zN@5rT6mY*QwE4sH"
                    }),
                });
                console.log("response:", response);
                const data = await response.json();
                // console.log("data:", data.token);
                return data.token;
            }
            // Envoi de la capture au backend pour la vérification
            const sendBiometricData = async (capturedImage) => {

                try {
                    const formData = new FormData();
                    const response = await fetch(capturedImage);
                    const blob = await response.blob();
                    formData.append("request", blob, "Face.png");
                    console.log([...formData.entries()]);

                    const token = await getToken();
                    const url = "https://10.30.30.22/api/Enrollement/check";
                    const res = await fetch(url, {
                        method: "POST",
                        headers: {
                            "Authorization": `Bearer ${token}`,
                        },
                        body: formData,
                    });

                    // 404 = personne non trouvée dans la base ABIS (pas une erreur technique)
                    if (res.status === 404) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Personne non identifiée',
                        })
                    }

                    if (!res.ok) {
                        const text = await res.text();
                        throw new Error(`Erreur serveur ${res.status}: ${text}`);
                    }

                    const data = await res.json();
                    console.log("Réponse backend:", data);
                    // Données démographiques associées à la personne identifiée et envoyées par le moteur ABIS
                    console.log("Personne identifiée:", {
                        idPersonne: data.idPersonne,
                        nom: data.nom,
                        prenom: data.prenom,
                        dateNaiss: data.dateNaiss,
                        numeroBeneficiaire: data.numeroBeneficiaire,
                        numeroAssure: data.numeroAssure,
                        sexe: data.sexe,
                        regime: data.regime,
                        ftpFace: data.ftpFace,
                        hasRight: data.hasRight,
                        beneficiaires: data.beneficiaire
                    });

                    identificationResult.style.display = 'block';
                    displayIdentificationResult(data);

                    // 4. Défilement automatique vers le bas
                    window.scrollTo({
                        top: document.body.scrollHeight,
                        behavior: 'smooth' // Défilement fluide
                    });
                } catch (error) {
                    console.error("Erreur lors de l'envoi des données biométriques:", error);
                    throw error;
                }
            }

            // Fonction pour afficher le résultat de l'identification
            function displayIdentificationResult(patientData) {
                // --- Remplir la carte d'information patient (Assuré principal) ---
                const patientInfoCard = document.getElementById('patient-info-card');
                const piAvatar = document.getElementById('pi-avatar');
                const photoUrl = patientData.ftpFace ?
                    `https://10.30.30.21/${patientData.ftpFace}` :
                    '/assets/images/default-avatar.png';
                piAvatar.src = photoUrl;

                document.getElementById('pi-name').textContent = patientData.nom || 'Non spécifié';
                document.getElementById('pi-company').textContent = patientData.nomEmployeur || 'Non spécifié';
                document.getElementById('pi-matricule').textContent = patientData.compteCotisant || 'N/A';
                document.getElementById('pi-matricule-assure').textContent = patientData.numeroAssure || 'N/A';
                document.getElementById('pi-regime-amo').textContent = patientData.regimeAmo || 'Non spécifié';
                document.getElementById('pi-regime').textContent = patientData.regime || 'Non spécifié';
                document.getElementById('pi-birth-date').textContent = patientData.dateNaiss ?
                    new Date(patientData.dateNaiss).toLocaleDateString('fr-FR') :
                    'Non spécifiée';
                document.getElementById('pi-ssn').textContent = patientData.numeroBeneficiaire || 'N/A';

                const careAccessEl = document.getElementById('pi-care-access');
                const hasAccess = patientData.hasRight;
                careAccessEl.textContent = hasAccess ? 'OUI' : 'NON';
                careAccessEl.className = 'care_access_badge ' + (hasAccess ? 'access-yes' : 'access-no');

                patientInfoCard.style.display = 'block';

                // --- Remplir les cartes membres (box_item) ---
                const resultDiv = document.getElementById('result-content');
                resultDiv.innerHTML = "";
                resultDiv.style.display = "flex";
                resultDiv.style.flexWrap = "wrap";
                resultDiv.style.gap = "20px";

                // Carte de l'assuré principal
                const membre = document.createElement('div');
                membre.className = 'box_item';

                membre.innerHTML = `
                    <img src="${photoUrl}"
                         class="loading"
                         onload="this.classList.remove('loading')"
                         alt="${patientData.nom}">
                    <p style="font-size:.9rem; text-align:center; font-weight:bold; margin-bottom:8px;">
                        ${patientData.nom}
                    </p>
                    <p class="birth_p">
                        <i class="ti ti-calendar"></i>
                        ${patientData.dateNaiss ? new Date(patientData.dateNaiss).toLocaleDateString('fr-FR') : "Non spécifiée"}
                    </p>
                    <p style="font-size:.8rem; text-align:center; color:#4361ee;">
                        🆔 SSN: ${patientData.numeroBeneficiaire || "N/A"}
                    </p>
                    <a class="btn btn-primary-light btn-wave print_fiche" style="margin-top: 10px;">
                        Imprimer
                    </a>
                `;
                resultDiv.appendChild(membre);

                // Cartes des bénéficiaires
                if (patientData.beneficiaire && Array.isArray(patientData.beneficiaire)) {
                    patientData.beneficiaire.forEach((ben, index) => {
                        const card = document.createElement('div');
                        card.className = 'box_item';
                        card.style.animationDelay = `${0.3 + (index * 0.1)}s`;

                        const benPhoto = ben.ftpFace ?
                            `https://10.30.30.21/${ben.ftpFace}` :
                            (ben.Photo || '/assets/images/default-avatar.png');

                        card.innerHTML = `
                            <img src="${benPhoto}"
                                 class="loading"
                                 onload="this.classList.remove('loading')"
                                 alt="${ben.nom || ''}">
                            <p style="font-size:.9rem; text-align:center; font-weight:bold; margin-bottom:8px;">
                                ${ben.nom || 'Non spécifié'}
                            </p>
                            <p class="birth_p">
                                <i class="ti ti-calendar"></i>
                                ${ben.dateNaiss || new Date(ben.dateNaiss).toLocaleDateString('fr-FR') || "N/A"}
                            </p>
                            <p style="font-size:.8rem; text-align:center; color:#4361ee;">
                                N°Beneficiaire: ${ben.numeroBeneficiaire || "N/A"}
                            </p>
                            <a class="btn btn-primary-light btn-wave print_fiche" style="margin-top: 10px;">
                                Imprimer
                            </a>
                        `;
                        resultDiv.appendChild(card);
                    });
                }
            }
            // checkStatus();
            // checkWebcam();
            connectWebSocket();
        </script>
    @endsection
</x-app-layout>
