<x-app-layout>
    @section('title', 'Capture Visage')
    @section('css')
        <style>
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
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
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

        /* ===== WEBCAM ===== */
        .video-container {
            position: relative;
            aspect-ratio: 4 / 3;
            border-radius: 12px;
            overflow: hidden;
            border: 3px solid #4099ff;
            margin-bottom: 15px;
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

        .btn-stop {
            background: #FF5370;
            box-shadow: 0 2px 6px rgba(255, 83, 112, 0.25);
        }

        .btn-capture {
            background: #2ed8b6;
            box-shadow: 0 2px 6px rgba(46, 216, 182, 0.25);
        }

        .btn-identify {
            background: #9b59b6;
            box-shadow: 0 2px 6px rgba(155, 89, 182, 0.25);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        /* ===== METRIQUES ===== */
        .metric-line {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed #e5e7eb;
            font-size: 15px;
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

        #canvas {
            display: none;
        }
        </style>
    @endsection

    @section('content')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                <x-breadcrumb.wrapper title="Capture et Identification du Visage">
                    <x-breadcrumb.item title="Biométrie" link="#" />
                    <x-breadcrumb.item title="Capture Visage" type="current" />
                </x-breadcrumb.wrapper>

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
                            <div class="detection-status status-loading" id="detection-status">
                                <i class="ti ti-loader"></i> Chargement...
                            </div>
                            <video id="video" autoplay playsinline></video>
                            <canvas id="overlay"></canvas>
                            <canvas id="canvas"></canvas>
                        </div>
                        <div class="btn-container">
                            <button id="startBtn" class="btn btn-start">
                                <i class="ti ti-video"></i> Démarrer
                            </button>
                            <button id="captureBtn" class="btn btn-capture" disabled>
                                <i class="ti ti-camera"></i> Capturer
                            </button>
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

                <!-- Progress bars supplémentaires (optionnel) -->
                <div class="metric-progress" style="margin-top: 20px; display: none;">
                    <div id="progress-clarity" class="progress-bar" style="width: 0%; background: #4099ff;"></div>
                </div>
                <div class="metric-progress" style="margin-top: 5px; display: none;">
                    <div id="progress-brightness" class="progress-bar" style="width: 0%; background: #FFB64D;"></div>
                </div>
            </div>

        </div>
            </div>
        </div>
        <!-- End::app-content -->
    @endsection

    @section('js')
        <script>
            const startvideo = document.getElementById('startBtn');
            
            const startCamera = async () => {
                // 1. Appeler du service pour démarrer la caméra
                const startResponse = await fetch(`https://localhost:8443/start-live`);
                const startData = await startResponse.json();
                
                if (startResponse.ok && startData.status === 'started') {
                    setFaceConnectionStatus('connected');
                    
                    // 2. Démarrer le flux vidéo MJPEG
                    startVideoStream();
                }
            };

            startvideo.onclick = startCamera;
        </script>
    @endsection
</x-app-layout>
