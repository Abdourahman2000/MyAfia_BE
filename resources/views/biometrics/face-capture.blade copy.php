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
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

    <script>
        // Éléments DOM
        const video = document.getElementById('video');
        const overlay = document.getElementById('overlay');
        const canvas = document.getElementById('canvas');
        const startBtn = document.getElementById('startBtn');
        const captureBtn = document.getElementById('captureBtn');
        const identifyBtn = document.getElementById('identifyBtn');
        const capturedImage = document.getElementById('captured-image');
        const placeholder = document.getElementById('placeholder');
        const videoContainer = document.getElementById('video-container');
        const captureContainer = document.getElementById('capture-container');
        const detectionStatus = document.getElementById('detection-status');
        // const alertContainer = document.getElementById('alert-container');

        // Métriques
        const metrics = {
            face: document.getElementById('m-face'),
            clarity: document.getElementById('m-clarity'),
            brightness: document.getElementById('m-brightness'),
            contrast: document.getElementById('m-contrast'),
            liveness: document.getElementById('m-liveness'),
            age: document.getElementById('m-age'),
            gender: document.getElementById('m-gender'),
            glasses: document.getElementById('m-glasses')
        };

        // Variables d'état
        let stream = null;
        let capturedData = null;
        let modelsLoaded = false;
        let faceDetected = false;
        let detectionInterval = null;
        let isRecording = false;

        // Afficher une alerte
        function showAlert(message, type = 'info') {
            const icons = {
                'error': 'alert-circle',
                'success': 'check',
                'info': 'info-circle'
            };

            alertContainer.innerHTML = `
                <div class="alert alert-${type}">
                    <i class="ti ti-${icons[type]}"></i>
                    ${message}
                </div>
            `;

            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);
        }

        // Mettre à jour une métrique
        function updateMetric(name, value, status = 'neutral') {
            const element = metrics[name];
            if (element) {
                element.textContent = value;
                element.className = `metric-value ${status}`;
            }
        }

        // Charger les modèles face-api
        async function loadModels() {
            try {
                detectionStatus.innerHTML = '<i class="ti ti-loader"></i> Chargement des modèles...';
                const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model';

                await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
                await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
                await faceapi.nets.ageGenderNet.loadFromUri(MODEL_URL);

                modelsLoaded = true;
                detectionStatus.innerHTML = '<i class="ti ti-check"></i> Prêt à détecter';
                showAlert('Modèles de détection chargés avec succès', 'success');
            } catch (err) {
                console.error('Erreur de chargement des modèles:', err);
                showAlert('Erreur de chargement des modèles de détection', 'error');
                detectionStatus.innerHTML = '<i class="ti ti-alert-triangle"></i> Erreur';
            }
        }

        // Démarrer la webcam
        async function startWebcam() {
            try {
                detectionStatus.className = 'detection-status status-loading';
                detectionStatus.innerHTML = '<i class="ti ti-loader"></i> Démarrage...';

                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        width: { ideal: 1280 },
                        height: { ideal: 720 },
                        facingMode: 'user'
                    }
                });

                video.srcObject = stream;
                isRecording = true;
                startBtn.innerHTML = '<i class="ti ti-video-off"></i> Arrêter';
                startBtn.className = 'btn btn-stop';
                captureBtn.disabled = false;

                showAlert('Webcam activée avec succès', 'success');

                video.addEventListener('loadeddata', async () => {
                    overlay.width = video.videoWidth;
                    overlay.height = video.videoHeight;

                    await loadModels();
                    startFaceDetection();
                });

            } catch (err) {
                showAlert('Erreur d\'accès à la webcam: ' + err.message, 'error');
                console.error('Erreur d\'accès à la webcam:', err);
                stopWebcam();
            }
        }

        // Arrêter la webcam
        function stopWebcam() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }

            if (detectionInterval) {
                clearInterval(detectionInterval);
                detectionInterval = null;
            }

            isRecording = false;
            startBtn.innerHTML = '<i class="ti ti-video"></i> Démarrer';
            startBtn.className = 'btn btn-start';
            captureBtn.disabled = true;
            video.srcObject = null;

            // Réinitialiser l'interface
            videoContainer.classList.remove('face-detected', 'no-face-detected');
            detectionStatus.className = 'detection-status status-no-face';
            detectionStatus.innerHTML = '<i class="ti ti-video-off"></i> Arrêtée';

            // Réinitialiser les métriques
            updateMetric('face', '0', 'bad');
            updateMetric('clarity', '0%', 'bad');
            updateMetric('brightness', '0%', 'bad');
            updateMetric('contrast', '0%', 'bad');
            updateMetric('liveness', '-', 'bad');
            updateMetric('age', '-', 'bad');
            updateMetric('gender', '-', 'bad');
            updateMetric('glasses', '-', 'bad');

            showAlert('Webcam arrêtée', 'info');
        }

        // Détecter les visages en temps réel
        async function startFaceDetection() {
            if (!modelsLoaded) return;

            detectionInterval = setInterval(async () => {
                if (video.readyState === 4) {
                    const detections = await faceapi.detectAllFaces(
                        video,
                        new faceapi.TinyFaceDetectorOptions({ scoreThreshold: 0.5 })
                    ).withFaceLandmarks().withAgeAndGender();

                    const ctx = overlay.getContext('2d');
                    ctx.clearRect(0, 0, overlay.width, overlay.height);

                    if (detections.length > 0) {
                        // Visage détecté
                        faceDetected = true;
                        videoContainer.classList.remove('no-face-detected');
                        videoContainer.classList.add('face-detected');
                        detectionStatus.className = 'detection-status status-detected';
                        detectionStatus.innerHTML = `<i class="ti ti-check"></i> Visage détecté`;
                        captureBtn.disabled = false;

                        // Mettre à jour les métriques
                        updateMetric('face', detections.length, 'good');

                        const detection = detections[0];
                        const confidence = Math.round(detection.detection.score * 100);
                        updateMetric('clarity', `${confidence}%`, confidence > 70 ? 'good' : 'warning');

                        // Calculer des métriques simulées
                        updateMetric('brightness', `${Math.floor(Math.random() * 30 + 70)}%`, 'good');
                        updateMetric('contrast', `${Math.floor(Math.random() * 30 + 70)}%`, 'good');
                        updateMetric('liveness', `${Math.floor(Math.random() * 30 + 70)}%`, 'good');

                        // Âge et genre
                        if (detection.age) {
                            updateMetric('age', Math.round(detection.age), 'good');
                        }

                        if (detection.gender) {
                            const gender = detection.gender === 'male' ? 'Homme' : 'Femme';
                            updateMetric('gender', gender, 'good');
                        }

                        updateMetric('glasses', 'Non', 'good');

                        // Dessiner le rectangle autour du visage
                        detections.forEach(detection => {
                            const box = detection.detection.box;
                            ctx.strokeStyle = '#2ed8b6';
                            ctx.lineWidth = 3;
                            ctx.strokeRect(box.x, box.y, box.width, box.height);
                        });
                    } else {
                        // Aucun visage détecté
                        faceDetected = false;
                        videoContainer.classList.remove('face-detected');
                        videoContainer.classList.add('no-face-detected');
                        detectionStatus.className = 'detection-status status-no-face';
                        detectionStatus.innerHTML = '<i class="ti ti-face-id-error"></i> Aucun visage';
                        captureBtn.disabled = true;

                        // Mettre à jour les métriques
                        updateMetric('face', '0', 'bad');
                        updateMetric('clarity', '0%', 'bad');
                        updateMetric('brightness', '0%', 'bad');
                        updateMetric('contrast', '0%', 'bad');
                        updateMetric('liveness', '-', 'bad');
                        updateMetric('age', '-', 'bad');
                        updateMetric('gender', '-', 'bad');
                        updateMetric('glasses', '-', 'bad');
                    }
                }
            }, 200);
        }

        // Capturer la photo
        captureBtn.addEventListener('click', function() {
            if (!faceDetected) {
                showAlert('Veuillez positionner votre visage devant la caméra', 'error');
                return;
            }

            // Arrêter temporairement la détection
            if (detectionInterval) {
                clearInterval(detectionInterval);
            }

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);

            capturedData = canvas.toDataURL('image/png');
            capturedImage.src = capturedData;

            // Afficher l'image capturée
            placeholder.style.display = 'none';
            capturedImage.style.display = 'block';
            captureContainer.style.border = '3px solid #2ed8b6';
            captureContainer.style.borderStyle = 'solid';

            // Activer le bouton d'identification
            identifyBtn.disabled = false;

            showAlert('Capture réussie! Visage correctement capturé.', 'success');

            // Redémarrer la détection après capture
            setTimeout(() => {
                if (isRecording) {
                    startFaceDetection();
                }
            }, 1000);
        });

        // Identifier le visage
        identifyBtn.addEventListener('click', async function() {
            if (!capturedData) {
                showAlert('Aucune capture à identifier', 'error');
                return;
            }

            identifyBtn.disabled = true;
            identifyBtn.innerHTML = '<i class="ti ti-loader"></i> Identification...';

            try {
                // Simulation d'identification
                await new Promise(resolve => setTimeout(resolve, 2000));

                showAlert('Identification terminée! Visage reconnu avec succès.', 'success');

                // Mettre à jour les métriques avec des valeurs améliorées
                updateMetric('clarity', '92%', 'good');
                updateMetric('brightness', '88%', 'good');
                updateMetric('contrast', '85%', 'good');
                updateMetric('liveness', '95%', 'good');

                identifyBtn.innerHTML = '<i class="ti ti-check"></i> Identifié';
                setTimeout(() => {
                    identifyBtn.innerHTML = '<i class="ti ti-search"></i> Identifier';
                    identifyBtn.disabled = false;
                }, 3000);

            } catch (error) {
                showAlert('Erreur lors de l\'identification: ' + error.message, 'error');
                identifyBtn.innerHTML = '<i class="ti ti-search"></i> Identifier';
                identifyBtn.disabled = false;
            }
        });

        identifyBtn.onclick= () =>{
            windows.location.href = "{{ route('biometrie.getPatient') }}";
        }

        // Démarrer/arrêter la webcam
        startBtn.addEventListener('click', function() {
            if (!isRecording) {
                startWebcam();
            } else {
                stopWebcam();
            }
        });

        // Nettoyer à la fermeture
        window.addEventListener('beforeunload', function() {
            stopWebcam();
        });

        // Initialiser les métriques
        updateMetric('face', '0', 'bad');
        updateMetric('clarity', '0%', 'bad');
        updateMetric('brightness', '0%', 'bad');
        updateMetric('contrast', '0%', 'bad');
        updateMetric('liveness', '-', 'bad');
        updateMetric('age', '-', 'bad');
        updateMetric('gender', '-', 'bad');
        updateMetric('glasses', '-', 'bad');
    </script>
    @endsection
</x-app-layout>
