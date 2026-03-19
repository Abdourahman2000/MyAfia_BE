<x-app-layout>
    @section('title', 'Capture Visage')
    @section('css')
        <!-- Sweetalerts CSS -->
        <link rel="stylesheet" href="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.css">
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
                width: 58px;
                height: 58px;
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

            /* .face-detected {
                                                                    border-color: #2ed8b6 !important;
                                                                    box-shadow: 0 0 15px rgba(46, 216, 182, 0.3) !important;
                                                                }

                                                                .no-face-detected {
                                                                    border-color: #FF5370 !important;
                                                                    box-shadow: 0 0 15px rgba(255, 83, 112, 0.3) !important;
                                                                } */

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

            /* .metric-value.good {
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
                                                                } */

            /* ===== PROGRESS BARS ===== */
            /* .metric-progress {
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
                                                                } */

            /* ===== ALERTES ===== */
            /* .alert-container {
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
                                                                } */

            /* ===== DETECTION STATUS ===== */
            /* .detection-status {
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
                                                                } */

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
                        <div class="biometric-title-icon">
                            <i class="ti ti-scan"></i>
                        </div>
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
            </div>
        </div>
        <!-- End::app-content -->
    @endsection

    @section('js')
        <!-- Sweetalerts JS -->
        <script src="{{ asset('assets') }}/libs/sweetalert2/sweetalert2.min.js"></script>
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
            let ws = null;
            let wsRetries = 0;

            // navigator.mediaDevices.getUserMedia({ video: true })
            //     .then(function(stream) {
            //         // La caméra est accessible
            //         return navigator.mediaDevices.enumerateDevices();
            //     })
            //     .then(function(devices) {
            //         const videoDevices = devices.filter(device => device.kind === 'videoinput');
            //         if (videoDevices.length > 0) {
            //         console.log('Webcam branchée :', videoDevices);
            //         } else {
            //         console.log('Aucune webcam détectée.');
            //         }
            //     })
            //     .catch(function(err) {
            //         console.error('Erreur d\'accès à la caméra :', err);
            //     });

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

            function connectWebSocket() {
                if (ws && (ws.readyState === WebSocket.OPEN || ws.readyState === WebSocket.CONNECTING)) {
                    return;
                }

                // Use 'wss' protocol and port 8443 as requested
                ws = new WebSocket('wss://localhost:8443/ws/biometric-events');

                ws.onopen = () => {
                    console.log('WebSocket Connected');
                    wsRetries = 0;
                };

                ws.onmessage = (event) => {
                    try {
                        const payload = JSON.parse(event.data);
                        handleWebSocketMessage(payload);
                    } catch (e) {
                        console.error('Error parsing WS message', e);
                    }
                };

                ws.onerror = (error) => {
                    console.error('WebSocket Error', error);
                };

                ws.onclose = () => {
                    console.log('WebSocket Closed');
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

            function handleWebSocketMessage(payload) {
                if (payload.type === 'QUALITY_METRICS') {
                    const metrics = retrieveMetrics(payload.message);
                    updateUIWithMetrics(metrics);
                    // If we get metrics, it implies a face is detected and processed
                    updateMetric('face', '1', 'good');
                } else if (payload.type === 'QUALITY_CHECK') {
                    if (payload.message.includes('Aucun visage')) {
                        updateMetric('face', '0', 'bad');
                        resetMetrics();
                    } else if (payload.message.includes('Deux visages')) {
                        updateMetric('face', '2', 'warning');
                    } else if (payload.message.includes('Plusieurs visages')) { // Handle potential other messages
                        updateMetric('face', '2+', 'warning');
                    }
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
                        identifyBtn.disabled = false;
                        placeholder.style.display = 'none';

                        const captureMetrics = document.getElementById('capture-metrics');

                        if (data.metrics) {

                            captureMetrics.innerHTML = "";
                            captureMetrics.style.display = "block";

                            const m = data.metrics;

                            // Netteté
                            if (m.sharpness <= 5000) {
                                captureMetrics.innerHTML += `
                                <div class="metric-line">
                                    <span class="metric-label">Netteté insuffisante</span>
                                    <span class="metric-value bad">🟥</span>
                                </div>`;
                            }

                            // Luminosité (normalisation)
                            const brightness = ((m.brightness + 10000) / 20000) * 100;
                            if (brightness < 50 || brightness > 80) {
                                captureMetrics.innerHTML += `
                                <div class="metric-line">
                                    <span class="metric-label">Luminosité non idéale</span>
                                    <span class="metric-value bad">🟥</span>
                                </div>`;
                            }

                            // Contraste
                            const contrast = ((m.contrast + 10000) / 20000) * 100;
                            if (contrast <= 50) {
                                captureMetrics.innerHTML += `
                                <div class="metric-line">
                                    <span class="metric-label">Contraste insuffisant</span>
                                    <span class="metric-value bad">🟥</span>
                                </div>`;
                            }

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
                                captureMetrics.innerHTML = `
                                <div class="metric-line">
                                    <span class="metric-label" style="color:green;">Capture valide</span>
                                    <span class="metric-value good">🟢</span>
                                </div>`;
                            }
                        }


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

            const getToken = async () => {
                const response = await fetch('https://10.30.30.22/api/Login/machine-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        clientId: 'service1',
                        clientSecret: 'qX7!fL9$2vB#8kP1zN@5rT6mY*QwE4sH'
                    })
                });

                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(`Erreur login ${response.status}: ${text}`);
                }

                const data = await response.json();
                return data.token;
            };

            const sendBiometricData = async (capturedImage) => {
                try {
                    // 1. Récupérer le token
                    const token = await getToken();

                    // 2. Préparer le FormData avec l'image
                    const formData = new FormData();
                    const response = await fetch(capturedImage);
                    const blob = await response.blob();
                    formData.append("request", blob, "Face.png");
                    console.log([...formData.entries()]);

                    // 3. Envoyer l'image avec le token
                    const res = await fetch(`https://10.30.30.22/api/Enrollement/check`, {
                        method: "POST",
                        headers: {
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData,
                    });

                    if (!res.ok) {
                        const text = await res.text();
                        throw new Error(`Erreur serveur ${res.status}: ${text}`);
                    }

                    const data = await res.json();
                    // console.log("Réponse backend:", data);
                    // Données démographiques associées à la personne identifiée et envoyées par le moteur ABIS
                    // setPerson({
                    //     idPersonne: data.idPersonne,
                    //     nom: data.nom,

                    //     //Guide d'Implémentation - Service de Reconnaissance Faciale de reconnaissance faciale 8

                    //     prenom: data.prenom,
                    //     dateNaiss: data.dateNaiss,
                    //     numeroBeneficiaire: data.numeroBeneficiaire,
                    //     numeroAssure: data.numeroAssure,
                    //     sexe: data.sexe,
                    //     regime: data.regime,
                    //     ftpFace: data.ftpFace,
                    //     hasRight: data.hasRight,
                    //     beneficiaires: data.beneficiaire // tableau de personne
                    // });
                } catch (error) {
                    console.error("Erreur lors de l'envoi des données biométriques:", error);
                    throw error;
                }
            };

            identifyBtn.addEventListener('click', function() {
                sendBiometricData(capturedImage.src);
                // if(person.idPersonne){

                // }
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
                    connectWebSocket();
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
                    disconnectWebSocket();
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

            async function checkWebcam() {
                try {
                    // Demander la permission d'abord (indispensable)
                    // await navigator.mediaDevices.getUserMedia({ video: true });

                    const devices = await navigator.mediaDevices.enumerateDevices();
                    const videoDevices = devices.filter(device => device.kind === 'videoinput');

                    // Filtrer pour trouver une caméra qui n'est pas "intégrée"
                    const externalCamera = videoDevices.find(device => {
                        const label = device.label.toLowerCase();

                        // Liste noire des termes techniques de caméras intégrées
                        const internalTerms = [
                            'integrated',
                            'built-in',
                            'facetime',
                            'front',
                            'ov02c10', // Votre capteur spécifique
                            'camera vga'
                        ];

                        // On vérifie si le label contient l'un des termes de la liste noire
                        const isInternal = internalTerms.some(term => label.includes(term));

                        // On ne garde que ce qui n'est PAS interne ET qui a un nom
                        return !isInternal && label.trim() !== '';
                    });

                    if (externalCamera) {
                        console.log('Webcam externe détectée :', externalCamera.label);
                        setStatus('status-connected', 'Détecté', 'ti ti-wifi');
                        return true;
                    } else {
                        console.log('Seule la webcam intégrée ou aucune caméra externe détectée.');
                        setStatus('status-disconnected', 'Non detecté', 'ti ti-wifi-off');
                        return false;
                    }
                } catch (error) {
                    console.error('Erreur d\'accès à la caméra :', error);
                }
            }

            navigator.mediaDevices.ondevicechange = (event) => {
                console.log("Changement de périphérique détecté...");
                checkWebcam();
            };

            startBtn.addEventListener('click', async () => {
                if (isRunning) {
                    try {
                        await fetch('https://localhost:8443/stop-live');
                        updateButtonState(false);
                        // await checkStatus();
                    } catch (error) {
                        console.error('Stop failed:', error);
                    }
                    return;
                }

                try {

                    const webcamAvailable = await checkWebcam();

                    if (!webcamAvailable) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Webcam introuvable',
                            text: 'Aucune webcam détectée sur cet appareil'
                        });

                        return;
                    }

                    // setStatus('status-connecting', 'Connexion...', 'ti ti-loader');

                    const response = await fetch('https://localhost:8443/start-live');
                    const data = await response.json();

                    if (data.status === 'started') {
                        // await checkStatus();
                        console.log('started');
                        updateButtonState(true);
                    } else {
                        setStatus('status-disconnected', 'Échec', 'ti ti-wifi-off');
                    }

                } catch (error) {
                    setStatus('status-disconnected', 'Erreur', 'ti ti-alert-circle');
                }
            });


            // checkStatus();
            checkWebcam();
        </script>
    @endsection
</x-app-layout>
