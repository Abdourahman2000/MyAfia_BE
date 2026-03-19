<x-app-layout>
    @section('title', 'Capture Empreintes Digitales')

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

            .capture-layout {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }

            @media (max-width: 1200px) {
                .capture-layout {
                    grid-template-columns: 1fr;
                }
            }

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

            .scanner-preview {
                position: relative;
                aspect-ratio: 4 / 3;
                border: 3px dashed #d1d5db;
                border-radius: 12px;
                background: #f9fafb;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                margin-bottom: 15px;
            }

            .scanner-preview.active {
                border-color: #10b981;
                border-style: solid;
                box-shadow: 0 0 15px rgba(16, 185, 129, 0.3);
            }

            .scanner-preview img {
                width: 100%;
                height: 100%;
                object-fit: contain;
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

            .btn-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
                margin-bottom: 15px;
            }

            .btn {
                padding: 14px;
                border-radius: 10px;
                border: none;
                color: white;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                font-size: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            .btn:hover:not(:disabled) {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .btn-primary {
                background: #4099ff;
            }

            .btn-success {
                background: #2ed8b6;
            }

            .btn-info {
                background: #9b59b6;
            }

            .instruction-message {
                background: #fffbeb;
                border-left: 4px solid #f59e0b;
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 15px;
                font-size: 14px;
                color: #92400e;
            }

            .images-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 10px;
                margin-top: 15px;
            }

            .image-item {
                position: relative;
                aspect-ratio: 1;
                border: 2px solid #e5e7eb;
                border-radius: 8px;
                overflow: hidden;
            }

            .image-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .image-item .label {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0, 0, 0, 0.7);
                color: white;
                padding: 4px;
                font-size: 10px;
                text-align: center;
            }

            .progress-indicator {
                text-align: center;
                padding: 10px;
                background: #f0f9ff;
                border-radius: 8px;
                margin-bottom: 15px;
            }

            .progress-text {
                font-weight: 600;
                color: #0369a1;
                margin-bottom: 8px;
            }

            .progress-bar-container {
                width: 100%;
                height: 8px;
                background: #e0f2fe;
                border-radius: 4px;
                overflow: hidden;
            }

            .progress-bar {
                height: 100%;
                background: linear-gradient(90deg, #4099ff, #2ed8b6);
                transition: width 0.3s ease;
                width: 0%;
            }

            .info-banner {
                background: linear-gradient(135deg, #dbeafe, #eff6ff);
                border-left: 4px solid #3b82f6;
                padding: 16px 20px;
                border-radius: 8px;
                margin-bottom: 30px;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .info-banner i {
                font-size: 24px;
                color: #3b82f6;
            }

            .info-banner-text {
                flex: 1;
            }

            .info-banner-text strong {
                color: #1e40af;
                display: block;
                margin-bottom: 4px;
                font-size: 15px;
            }

            .info-banner-text p {
                margin: 0;
                color: #1e3a8a;
                font-size: 14px;
                line-height: 1.5;
            }
        </style>
    @endsection

    @section('content')
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- HEADER -->
                <div class="biometric-header">
                    <div class="biometric-title">
                        <div>
                            <h2>Capture Empreintes Digitales</h2>
                            <p>Scanner d'empreintes - Main droite, Main gauche, Pouces</p>
                        </div>
                    </div>

                    <div id="statusIndicator" class="status-indicator status-disconnected">
                        <i class="ti ti-wifi-off"></i>
                        <span>Déconnecté</span>
                    </div>
                </div>

                <!-- INFO BANNER -->
                <div class="info-banner">
                    <i class="ti ti-info-circle"></i>
                    <div class="info-banner-text">
                        <strong>Information importante</strong>
                        <p>Vous devez choisir <strong>UNE SEULE option</strong> de capture pour identifier la personne (Main
                            Droite OU Main Gauche OU Pouces). Il n'est pas nécessaire de scanner tous les doigts.</p>
                    </div>
                </div>

                <div class="capture-layout">

                    <!-- GAUCHE : SCANNER -->
                    <div class="card">
                        <h3><i class="ti ti-fingerprint"></i> Scanner Empreintes</h3>

                        <!-- Instructions -->
                        <div id="instructionMessage" class="instruction-message" style="display: none;">
                            <i class="ti ti-info-circle"></i>
                            <span id="instructionText">En attente...</span>
                        </div>

                        <!-- Progress -->
                        <div id="progressIndicator" class="progress-indicator" style="display: none;">
                            <div class="progress-text"><span id="progressText">0/5</span> images capturées</div>
                            <div class="progress-bar-container">
                                <div class="progress-bar" id="progressBar"></div>
                            </div>
                        </div>

                        <!-- Scanner Preview -->
                        <div class="scanner-preview" id="scannerPreview">
                            <div class="placeholder-text">
                                <i class="ti ti-fingerprint"></i>
                                Aperçu du scanner
                            </div>
                            <img id="previewImage" style="display: none;" alt="Aperçu">
                        </div>

                        <!-- Buttons -->
                        <div class="btn-container">
                            <button id="captureRightBtn" class="btn btn-primary" disabled>
                                <i class="ti ti-hand-finger"></i> Main Droite
                            </button>
                            <button id="captureLeftBtn" class="btn btn-success" disabled>
                                <i class="ti ti-hand-finger"></i> Main Gauche
                            </button>
                            <button id="captureThumbsBtn" class="btn btn-info" disabled>
                                <i class="ti ti-hand-two-fingers"></i> Pouces
                            </button>
                        </div>

                        <div style="text-align: center; font-size: 12px; color: #6b7280;">
                            <i class="ti ti-arrow-up"></i> Choisissez <strong>UNE</strong> option pour identifier
                        </div>
                    </div>

                    <!-- DROITE : IMAGES CAPTURÉES -->
                    <div class="card">
                        <h3><i class="ti ti-photo"></i> Images Capturées</h3>

                        <div id="capturedImagesContainer">
                            <div class="placeholder-text">
                                <i class="ti ti-photo-off"></i>
                                Aucune image capturée
                            </div>
                        </div>

                        <div id="imagesGrid" class="images-grid" style="display: none;"></div>

                        <div style="margin-top: 20px;">
                            <button id="sendBtn" class="btn btn-primary" style="width: 100%;" disabled>
                                <i class="ti ti-send"></i> Envoyer au Moteur ABIS (Désactivé)
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endsection

    @section('js')
        <script>
            const statusIndicator = document.getElementById('statusIndicator');
            const scannerPreview = document.getElementById('scannerPreview');
            const previewImage = document.getElementById('previewImage');
            const captureRightBtn = document.getElementById('captureRightBtn');
            const captureLeftBtn = document.getElementById('captureLeftBtn');
            const captureThumbsBtn = document.getElementById('captureThumbsBtn');
            const sendBtn = document.getElementById('sendBtn');
            const instructionMessage = document.getElementById('instructionMessage');
            const instructionText = document.getElementById('instructionText');
            const progressIndicator = document.getElementById('progressIndicator');
            const progressText = document.getElementById('progressText');
            const progressBar = document.getElementById('progressBar');
            const imagesGrid = document.getElementById('imagesGrid');
            const capturedImagesContainer = document.getElementById('capturedImagesContainer');

            let websocket = null;
            let capturedImages = [];
            let currentCaptureType = null;

            // Établir la connexion WebSocket
            function connectWebSocket() {
                if (websocket) {
                    websocket.close();
                }

                websocket = new WebSocket('wss://localhost:8443/ws/biometric-events');

                websocket.onopen = () => {
                    console.log('WebSocket connecté pour les empreintes');
                    setStatus('status-connected', 'Connecté', 'ti ti-wifi');

                    // Activer les boutons de capture
                    captureRightBtn.disabled = false;
                    captureLeftBtn.disabled = false;
                    captureThumbsBtn.disabled = false;
                };

                websocket.onmessage = (event) => {
                    try {
                        const data = JSON.parse(event.data);
                        handleWebSocketMessage(data);
                    } catch (error) {
                        console.error('Erreur parsing WebSocket:', error);
                    }
                };

                websocket.onerror = (error) => {
                    console.error('Erreur WebSocket:', error);
                    setStatus('status-disconnected', 'Erreur', 'ti ti-alert-circle');
                };

                websocket.onclose = () => {
                    console.log('WebSocket déconnecté');
                    websocket = null;
                    setStatus('status-disconnected', 'Déconnecté', 'ti ti-wifi-off');

                    // Désactiver les boutons
                    captureRightBtn.disabled = true;
                    captureLeftBtn.disabled = true;
                    captureThumbsBtn.disabled = true;
                };
            }

            // Gérer les messages WebSocket
            function handleWebSocketMessage(data) {
                const {
                    type,
                    message
                } = data;

                switch (type) {
                    case 'IMAGE_PREVIEW':
                        // Afficher l'aperçu en temps réel
                        try {
                            const preview = JSON.parse(message);
                            displayPreview(preview.imageData);
                        } catch (e) {
                            console.error('Erreur preview:', e);
                        }
                        break;

                    case 'INSTRUCTION':
                        // Afficher les instructions
                        showInstruction(message);
                        break;

                    case 'FINGERS_BASE64_IMG':
                        // Stocker l'image reçue
                        capturedImages.push(message);
                        console.log(`Image ${capturedImages.length}/5 reçue`);

                        // Mettre à jour le progrès
                        updateProgress(capturedImages.length);

                        // Afficher la première image (main complète) comme aperçu
                        if (capturedImages.length === 1) {
                            displayCapturedImage(message);
                        }
                        break;

                    case 'CAPTURE_DONE':
                        // Toutes les images ont été reçues
                        console.log('Capture terminée, 5 images reçues');
                        onCaptureComplete();
                        break;

                    case 'CAPTURE_ERROR':
                        // Gérer les erreurs
                        console.error('Erreur:', message);
                        showError(message);
                        resetCapture();
                        break;

                    default:
                        console.log('Message non géré:', type, message);
                }
            }

            // Déclencher la capture
            async function startCapture(type, endpoint) {
                try {
                    currentCaptureType = type;
                    capturedImages = [];

                    // Désactiver les boutons pendant la capture
                    captureRightBtn.disabled = true;
                    captureLeftBtn.disabled = true;
                    captureThumbsBtn.disabled = true;

                    // Afficher le progrès
                    progressIndicator.style.display = 'block';
                    updateProgress(0);

                    // Afficher le scanner en mode actif
                    scannerPreview.classList.add('active');

                    console.log(`Démarrage capture: ${endpoint}`);

                    const response = await fetch(`https://localhost:8443${endpoint}`, {
                        method: 'GET'
                    });

                    if (!response.ok) {
                        throw new Error(`Erreur HTTP: ${response.status}`);
                    }

                    console.log('Capture démarrée');
                    showInstruction('Placez vos doigts sur le scanner...');

                } catch (error) {
                    console.error('Erreur démarrage capture:', error);
                    alert('Impossible de démarrer la capture. Vérifiez que le service est actif.');
                    resetCapture();
                }
            }

            // Afficher l'aperçu en temps réel
            function displayPreview(imageData) {
                previewImage.src = imageData;
                previewImage.style.display = 'block';
                scannerPreview.querySelector('.placeholder-text').style.display = 'none';
            }

            // Afficher l'image capturée
            function displayCapturedImage(imageData) {
                displayPreview(imageData);
            }

            // Afficher les instructions
            function showInstruction(text) {
                instructionMessage.style.display = 'block';
                instructionText.textContent = text;
            }

            // Mettre à jour le progrès
            function updateProgress(count) {
                const percentage = (count / 5) * 100;
                progressText.textContent = `${count}/5`;
                progressBar.style.width = `${percentage}%`;
            }

            // Capture terminée
            function onCaptureComplete() {
                showInstruction('Capture terminée avec succès!');
                progressIndicator.style.display = 'none';
                scannerPreview.classList.remove('active');

                // Afficher les images dans la grille
                displayImagesGrid();

                // Réactiver les boutons
                captureRightBtn.disabled = false;
                captureLeftBtn.disabled = false;
                captureThumbsBtn.disabled = false;

                // Note: Le bouton d'envoi au moteur ABIS reste désactivé comme demandé
            }

            // Afficher les images dans la grille
            function displayImagesGrid() {
                const labels = {
                    'right-four': ['Main Droite', 'Index D', 'Majeur D', 'Annulaire D', 'Auriculaire D'],
                    'left-four': ['Main Gauche', 'Index G', 'Majeur G', 'Annulaire G', 'Auriculaire G'],
                    'thumbs': ['Pouces', 'Pouce D', 'Pouce G', '', '']
                };

                const currentLabels = labels[currentCaptureType] || ['Image 1', 'Image 2', 'Image 3', 'Image 4', 'Image 5'];

                capturedImagesContainer.style.display = 'none';
                imagesGrid.style.display = 'grid';
                imagesGrid.innerHTML = '';

                capturedImages.forEach((imageData, index) => {
                    const div = document.createElement('div');
                    div.className = 'image-item';

                    const img = document.createElement('img');
                    img.src = imageData;
                    img.alt = `Image ${index + 1}`;

                    const label = document.createElement('div');
                    label.className = 'label';
                    label.textContent = currentLabels[index];

                    div.appendChild(img);
                    div.appendChild(label);
                    imagesGrid.appendChild(div);
                });
            }

            // Afficher une erreur
            function showError(message) {
                alert(`Erreur: ${message}`);
            }

            // Réinitialiser la capture
            function resetCapture() {
                capturedImages = [];
                currentCaptureType = null;
                progressIndicator.style.display = 'none';
                scannerPreview.classList.remove('active');
                instructionMessage.style.display = 'none';

                // Réactiver les boutons
                captureRightBtn.disabled = false;
                captureLeftBtn.disabled = false;
                captureThumbsBtn.disabled = false;
            }

            // Changer le statut
            function setStatus(type, text, icon) {
                statusIndicator.classList.remove('status-connected', 'status-disconnected', 'status-connecting');
                statusIndicator.classList.add(type);
                statusIndicator.innerHTML = `<i class="${icon}"></i><span>${text}</span>`;
            }

            // Event Listeners
            captureRightBtn.addEventListener('click', () => {
                startCapture('right-four', '/capture-right-four');
            });

            captureLeftBtn.addEventListener('click', () => {
                startCapture('left-four', '/capture-left-four');
            });

            captureThumbsBtn.addEventListener('click', () => {
                startCapture('thumbs', '/capture-thumbs');
            });

            /**
             * Prépare les images pour l'envoi au backend
             */
            function prepareFormData(capturedImages) {
                // IMPORTANT : Noms exacts attendus par le backend
                const fingerNames = [
                    "RightHand", // Image 1 : Main complète
                    "RightIndex", // Image 2 : Index
                    "RightMiddle", // Image 3 : Majeur
                    "RightRing", // Image 4 : Annulaire
                    'RightLittle' // Image 5 : Auriculaire
                ];

                const formData = new FormData();
                // Convertir chaque image et l'ajouter au FormData
                capturedImages.forEach((imageBase64, index) => {
                    const blob = base64ToBlob(imageBase64);
                    const filename = `${fingerNames[index]}.png`;
                    // CRITIQUE: Le paramètre DOIT s'appeler "request"
                    formData.append("request", blob, filename);
                });
                return formData;
            }

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

            /**
             * Envoie les empreintes au backend pour identification
             */
            async function sendFingerprints(capturedImages) {
                try {
                    // Vérifier qu'on a bien les 5 images
                    if (capturedImages.length !== 5) {
                        throw new Error(`Images incomplètes: ${capturedImages.length}/5`);
                    }

                    // Préparer le FormData
                    const formData = prepareFormData(capturedImages);
                    console.log("Envoi des empreintes au backend...");
                    // Envoyer la requête
                    const response = await fetch("https://10.30.30.22/api/Enrollement/check", {
                        method: "POST",
                        headers: {
                            "Authorization": `Bearer ${token}`
                        },
                        body: formData
                    });

                    // Traiter la réponse
                    if (response.status === 200) {
                        // Personne identifiée
                        const person = await response.json();
                        console.log("Personne trouvée:", person);
                        // displayPersonInfo(person);
                    } else if (response.status === 404) {
                        const text = await res.text()
                        console.log(text)
                    } else {
                        //  Autre erreur
                        throw new Error(`Erreur HTTP ${response.status}`);
                    }
                } catch (error) {
                    console.error("❌ Erreur lors de l'envoi:", error);
                    showError("Impossible de vérifier les empreintes. Veuillez réessayer.");
                }
            }

            sendBtn.addEventListener('click', function() {
                // Swal.fire({
                //     icon: 'error',
                //     title: 'Oops...',
                //     text: 'Erreur d\'identification',
                // })

                sendFingerprints(capturedImages);
                // console.log(capturedImage.src);
            });

            // Connexion au démarrage
            connectWebSocket();

            // Déconnecter le WebSocket quand on quitte la page
            window.addEventListener('beforeunload', () => {
                if (websocket) {
                    websocket.close();
                }
            });
        </script>
    @endsection
</x-app-layout>
