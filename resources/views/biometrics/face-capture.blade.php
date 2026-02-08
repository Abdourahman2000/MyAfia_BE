<x-app-layout>
    @section('title', 'Capture Visage')
    @section('css')
        <style>
            .biometric-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }

            .biometric-title {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .biometric-title-icon {
                width: 48px;
                height: 48px;
                background: #eaf1ff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                color: #4a7dff;
            }

            .biometric-title h2 {
                margin: 0;
                font-weight: 700;
            }

            .biometric-title p {
                margin: 0;
                color: #6b7280;
                font-size: 14px;
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

            .face-detected {
                border-color: #2ed8b6 !important;
                box-shadow: 0 0 15px rgba(46, 216, 182, 0.3) !important;
            }

            .no-face-detected {
                border-color: #FF5370 !important;
                box-shadow: 0 0 15px rgba(255, 83, 112, 0.3) !important;
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
            }

            .metric-value.good {
                color: #2ed8b6;
            }

            .metric-value.bad {
                color: #FF5370;
            }

            .metric-value.neutral {
                color: #4099ff;
            }

            .metric-value.warning {
                color: #FFB64D;
            }

            /* ===== PROGRESS BARS ===== */
            .metric-progress {
                width: 100%;
                height: 6px;
                background: #e5e7eb;
                border-radius: 3px;
                margin-top: 6px;
                overflow: hidden;
            }

            .progress-bar {
                height: 100%;
                border-radius: 3px;
                transition: width 0.5s ease;
            }

            /* ===== ALERTES ===== */
            .alert-container {
                margin-bottom: 20px;
            }

            .alert {
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 15px;
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 14px;
                border-left: 4px solid;
            }

            .alert-success {
                background-color: rgba(46, 216, 182, 0.1);
                border-color: #2ed8b6;
                color: #0f766e;
            }

            .alert-error {
                background-color: rgba(255, 83, 112, 0.1);
                border-color: #FF5370;
                color: #be123c;
            }

            .alert-info {
                background-color: rgba(64, 153, 255, 0.1);
                border-color: #4099ff;
                color: #1e40af;
            }

            .alert i {
                font-size: 18px;
            }

            /* ===== DETECTION STATUS ===== */
            .detection-status {
                position: absolute;
                top: 10px;
                left: 50%;
                transform: translateX(-50%);
                padding: 8px 16px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                z-index: 10;
                background: rgba(255, 255, 255, 0.9);
                border: 1px solid;
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .status-detected {
                background: rgba(46, 216, 182, 0.1);
                border-color: #2ed8b6;
                color: #2ed8b6;
            }

            .status-no-face {
                background: rgba(255, 83, 112, 0.1);
                border-color: #FF5370;
                color: #FF5370;
            }

            .status-loading {
                background: rgba(64, 153, 255, 0.1);
                border-color: #4099ff;
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
        </style>
    @endsection

    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                <!-- HEADER -->
                <div class="biometric-header">
                    <div class="biometric-title">
                        {{-- <div class="biometric-title-icon">
                            <i class="ti ti-fingerprint"></i>
                        </div> --}}
                        <div>
                            <h2>Reconnaissance Faciale</h2>
                            <p>Capture du visage pour l'identification</p>
                        </div>
                    </div>

                    <div id="statusIndicator" class="status-indicator status-disconnected">
                        <i class="ti ti-wifi-off"></i>
                        <span>Déconnecté</span>
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
            let isRunning = false;

            captureBtn.addEventListener('click', async () => {
                if (!isRunning) return;

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
                        placeholder.style.display = 'none';
                        identifyBtn.disabled = false;
                    } else {
                        console.error('No image data in response');
                        console.log("No image data in response");
                        setStatus('status-disconnected', 'Erreur Capture', 'ti ti-alert-circle');
                    }

                } catch (error) {
                    console.error('Capture error:', error);
                    console.log("Capture error");
                    setStatus('status-disconnected', 'Erreur Capture', 'ti ti-alert-circle');
                }
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

            startBtn.addEventListener('click', async () => {
                if (isRunning) {
                    try {
                        await fetch('https://localhost:8443/stop-live');
                        await checkStatus();
                    } catch (error) {
                        console.error('Stop failed:', error);
                    }
                    return;
                }

                try {
                    setStatus('status-connecting', 'Connexion...', 'ti ti-loader');

                    const response = await fetch('https://localhost:8443/start-live');
                    const data = await response.json();

                    if (data.status === 'started') {
                        await checkStatus();
                        console.log('started');
                    } else {
                        setStatus('status-disconnected', 'Échec', 'ti ti-wifi-off');
                    }

                } catch (error) {
                    setStatus('status-disconnected', 'Erreur', 'ti ti-alert-circle');
                }
            });


            checkStatus();
        </script>
    @endsection
</x-app-layout>
