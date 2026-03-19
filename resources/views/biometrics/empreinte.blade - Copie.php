<x-app-layout>
    @section('title', 'Reconnaissance Main Droite')

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

            .biometric-card {
                background: #ffffff;
                border-radius: 16px;
                padding: 30px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                margin-bottom: 30px;
            }

            .biometric-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 30px;
                align-items: stretch;
            }

            @media (max-width: 992px) {
                .biometric-grid {
                    grid-template-columns: 1fr;
                }
            }

            .instructions-box {
                background: linear-gradient(135deg, #eef4ff, #f7faff);
                border-radius: 16px;
                padding: 25px;
            }

            .instructions-box h4 {
                font-weight: 700;
                color: #1f2937;
                margin-bottom: 20px;
            }

            .instruction-item {
                display: flex;
                align-items: flex-start;
                gap: 15px;
                margin-bottom: 15px;
            }

            .instruction-number {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: #4a7dff;
                color: white;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .scanner-box {
                background: #ffffff;
                border-radius: 16px;
                padding: 20px;
                border: 1px solid #e5e7eb;
                display: flex;
                flex-direction: column;
            }

            .scanner-box h4 {
                font-weight: 700;
                margin-bottom: 15px;
            }

            .scanner-preview {
                flex: 1;
                border: 2px dashed #d1d5db;
                border-radius: 16px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 300px;
                gap: 15px;
                transition: all 0.3s ease;
            }

            .scanner-preview.active {
                border-color: #4a7dff;
                background: #f8fafc;
            }

            .scanner-preview.scanning {
                border-color: #10b981;
                background: linear-gradient(135deg, #f0fdf4, #dcfce7);
                animation: pulse 2s infinite;
            }

            .scanner-preview i {
                font-size: 64px;
                transition: all 0.3s ease;
            }

            .scanner-preview.active i {
                color: #4a7dff;
            }

            .scanner-preview.scanning i {
                color: #10b981;
                animation: bounce 1s infinite;
            }

            .preview-status {
                font-weight: 600;
                font-size: 16px;
            }

            .finger-diagram {
                margin-top: 20px;
                text-align: center;
            }

            .finger-diagram img {
                max-width: 200px;
                height: auto;
            }

            .action-buttons {
                grid-column: 1 / -1;
                display: flex;
                justify-content: center;
                gap: 20px;
                margin-top: 20px;
            }

            @media (max-width: 576px) {
                .action-buttons {
                    flex-direction: column;
                }
            }

            .capture-btn {
                padding: 16px 32px;
                border-radius: 12px;
                border: none;
                background: linear-gradient(135deg, #4a7dff, #6ea8ff);
                color: #ffffff;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                transition: all 0.3s ease;
                min-width: 220px;
            }

            .capture-btn:hover:not(:disabled) {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(74, 125, 255, 0.2);
            }

            .capture-btn:disabled {
                background: #e5e7eb;
                color: #9ca3af;
                cursor: not-allowed;
                transform: none;
                box-shadow: none;
            }

            .identify-btn {
                padding: 16px 32px;
                border-radius: 12px;
                border: none;
                background: linear-gradient(135deg, #10b981, #34d399);
                color: #ffffff;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                transition: all 0.3s ease;
                min-width: 220px;
            }

            .identify-btn:hover:not(:disabled) {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
            }

            .identify-btn:disabled {
                background: #e5e7eb;
                color: #9ca3af;
                cursor: not-allowed;
                transform: none;
                box-shadow: none;
                opacity: 0.6;
            }

            .scan-progress {
                width: 80%;
                height: 6px;
                background: #e5e7eb;
                border-radius: 3px;
                overflow: hidden;
                margin-top: 10px;
            }

            .scan-progress-bar {
                height: 100%;
                background: linear-gradient(90deg, #4a7dff, #6ea8ff);
                width: 0%;
                transition: width 0.3s ease;
            }

            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
                70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
                100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
            }

            @keyframes bounce {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
        </style>
    @endsection

    @section('content')
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- HEADER -->
                <div class="biometric-header">
                    <div class="biometric-title">
                        <div class="biometric-title-icon">
                            <i class="ti ti-fingerprint"></i>
                        </div>
                        <div>
                            <h2>Empreinte Digitale - Main Droite</h2>
                            <p>Capture des 4 doigts (sans le pouce) pour l'identification</p>
                        </div>
                    </div>

                    <div id="statusIndicator" class="status-indicator status-disconnected">
                        <i class="ti ti-wifi-off"></i>
                        <span>Déconnecté</span>
                    </div>
                </div>

                <!-- CARD -->
                <div class="biometric-card">
                    <div class="biometric-grid">

                        <!-- INSTRUCTIONS -->
                        <div class="instructions-box">
                            <h4>Instructions de Capture</h4>

                            <div class="instruction-item">
                                <div class="instruction-number">1</div>
                                <div>Assurez-vous que le scanner est connecté et allumé</div>
                            </div>

                            <div class="instruction-item">
                                <div class="instruction-number">2</div>
                                <div>Placez les 4 doigts de votre main droite (sans le pouce) sur le scanner</div>
                            </div>

                            <div class="instruction-item">
                                <div class="instruction-number">3</div>
                                <div>Appuyez sur <strong>"Capturer"</strong> et maintenez vos doigts immobiles pendant 3 secondes</div>
                            </div>

                            <div class="instruction-item">
                                <div class="instruction-number">4</div>
                                <div>Une fois capturé, cliquez sur <strong>"Identifier"</strong> pour vérifier l'empreinte</div>
                            </div>

                            <div class="finger-diagram">
                                <!-- You would add an image here showing which fingers to place -->
                                <div style="font-size: 14px; color: #6b7280;">
                                    <strong>Doigts à scanner :</strong> Index, Majeur, Annulaire, Auriculaire
                                </div>
                            </div>
                        </div>

                        <!-- SCANNER PREVIEW -->
                        <div class="scanner-box">
                            <h4>Aperçu Scanner</h4>

                            <div id="scannerPreview" class="scanner-preview">
                                <i class="ti ti-fingerprint"></i>
                                <span class="preview-status">En attente de connexion...</span>
                                <div class="scan-progress">
                                    <div class="scan-progress-bar"></div>
                                </div>
                            </div>

                            <div style="text-align: center; margin-top: 15px; font-size: 14px; color: #6b7280;">
                                Statut: <span id="scanStatus">Prêt</span>
                            </div>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="action-buttons">
                            <button id="captureBtn" class="capture-btn" disabled>
                                <i class="ti ti-camera"></i>
                                Capturer Empreinte
                            </button>

                            <button id="identifyBtn" class="identify-btn" disabled>
                                <i class="ti ti-search"></i>
                                Identifier
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const statusIndicator = document.getElementById('statusIndicator');
                const scannerPreview = document.getElementById('scannerPreview');
                const captureBtn = document.getElementById('captureBtn');
                const identifyBtn = document.getElementById('identifyBtn');
                const scanStatus = document.getElementById('scanStatus');
                const progressBar = document.querySelector('.scan-progress-bar');

                // Simulate scanner connection
                setTimeout(() => {
                    statusIndicator.className = 'status-indicator status-connected';
                    statusIndicator.innerHTML = '<i class="ti ti-wifi"></i><span>Connecté</span>';

                    scannerPreview.classList.add('active');
                    scannerPreview.querySelector('.preview-status').textContent = 'Scanner prêt';
                    scanStatus.textContent = 'Connecté';

                    // Enable capture button
                    captureBtn.disabled = false;
                }, 2000);

                // Capture button click handler
                captureBtn.addEventListener('click', function() {
                    if (captureBtn.disabled) return;

                    // Start scanning animation
                    scannerPreview.classList.remove('active');
                    scannerPreview.classList.add('scanning');
                    scannerPreview.querySelector('.preview-status').textContent = 'Scan en cours...';
                    scanStatus.textContent = 'Scan en cours';
                    captureBtn.disabled = true;
                    captureBtn.innerHTML = '<i class="ti ti-loader-2 spin"></i> Capture...';

                    // Simulate scan progress
                    let progress = 0;
                    const interval = setInterval(() => {
                        progress += 10;
                        progressBar.style.width = progress + '%';

                        if (progress >= 100) {
                            clearInterval(interval);

                            // Scan complete
                            setTimeout(() => {
                                scannerPreview.classList.remove('scanning');
                                scannerPreview.querySelector('.preview-status').textContent = 'Capture réussie!';
                                scanStatus.textContent = 'Capture terminée';
                                captureBtn.disabled = false;
                                captureBtn.innerHTML = '<i class="ti ti-camera"></i> Capturer à nouveau';

                                // Enable identify button
                                identifyBtn.disabled = false;

                                // Show success message
                                showNotification('success', 'Empreinte capturée avec succès!');
                            }, 500);
                        }
                    }, 300);
                });

                // Identify button click handler
                identifyBtn.addEventListener('click', function() {
                    if (identifyBtn.disabled) return;

                    identifyBtn.disabled = true;
                    identifyBtn.innerHTML = '<i class="ti ti-loader-2 spin"></i> Identification...';
                    scanStatus.textContent = 'Identification en cours';

                    // Simulate identification process
                    setTimeout(() => {
                        identifyBtn.disabled = false;
                        identifyBtn.innerHTML = '<i class="ti ti-search"></i> Identifier';
                        scanStatus.textContent = 'Identification terminée';

                        // Show result (simulated)
                        const isMatch = Math.random() > 0.5;
                        if (isMatch) {
                            showNotification('success', 'Empreinte identifiée avec succès!');
                        } else {
                            showNotification('error', 'Aucune correspondance trouvée. Veuillez réessayer.');
                        }
                    }, 2000);
                });

                function showNotification(type, message) {
                    // You would integrate with your notification system here
                    alert(message); // Temporary for demo
                }
            });
        </script>
    @endsection
</x-app-layout>
