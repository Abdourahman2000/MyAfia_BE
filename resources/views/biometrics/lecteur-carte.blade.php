<x-app-layout>
    @section('title', 'Lecteur de Carte')

    @section('css')
        <style>
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

            /* Carte principale (panneau) */
            .card-reader {
                width: 100%;
                background: #ffffff;
                border-radius: 1rem;
                box-shadow: 0 10px 30px -8px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.05);
                overflow: hidden;
                transition: all 0.2s ease;
            }

            /* En-tête avec titre et statut */
            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 1.5rem 0.8rem 1.5rem;
                border-bottom: 1px solid #eef2f8;
            }

            .title {
                font-size: 1.3rem;
                font-weight: 600;
                letter-spacing: -0.3px;
                color: #1a2c3e;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .title-icon {
                font-size: 1.4rem;
            }

            .status-area {
                margin-top: 0.6rem;
                display: flex;
                align-items: baseline;
                flex-wrap: wrap;
                justify-content: space-between;
                row-gap: 0.5rem;
            }

            .status-badge {
                background: #ecfdf3;
                border-left: 4px solid #12b76a;
                padding: 0.4rem 1rem;
                border-radius: 2rem;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                font-weight: 500;
                font-size: 0.9rem;
                color: #067647;
            }

            .status-badge::before {
                content: "●";
                font-size: 0.7rem;
                color: #12b76a;
            }

            .progress-tag {
                font-size: 0.85rem;
                font-weight: 500;
                background: #f1f5f9;
                padding: 0.3rem 1rem;
                border-radius: 2rem;
                color: #2c3e66;
            }

            /* Section de progression */
            .progress-section {
                padding: 0.8rem 1.5rem;
            }

            .progress-label {
                display: flex;
                justify-content: space-between;
                font-size: 0.85rem;
                font-weight: 500;
                color: #4a5b6e;
                margin-bottom: 0.65rem;
                letter-spacing: 0.3px;
            }

            .progress-percent {
                font-weight: 700;
                color: #1f6392;
            }

            .progress-bar-bg {
                background-color: #e9eef3;
                border-radius: 100px;
                height: 12px;
                overflow: hidden;
                box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
            }

            .progress-fill {
                width: 0%;
                height: 100%;
                background: linear-gradient(90deg, #2b7bbb, #3c9ad8);
                border-radius: 100px;
                transition: width 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
                box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.2);
            }

            /* Zone de contrôle (boutons) */
            .actions {
                padding: 0.5rem 1.5rem 1rem 1.5rem;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                gap: 0.8rem;
                align-items: center;
                border-bottom: 1px solid #ecf1f7;
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.6rem;
                padding: 0.75rem 1.8rem;
                border-radius: 3rem;
                font-weight: 600;
                font-size: 0.95rem;
                border: none;
                cursor: pointer;
                transition: all 0.2s ease;
                background: #f4f7fc;
                color: #1f4970;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.02);
                font-family: inherit;
            }

            .btn-primary {
                background: #1a6d9f;
                color: white;
                box-shadow: 0 4px 8px rgba(26, 109, 159, 0.2);
            }

            .btn-primary:hover {
                background: #0e5a86;
                transform: translateY(-1px);
                box-shadow: 0 8px 18px rgba(26, 109, 159, 0.25);
            }

            .btn-primary:active {
                transform: translateY(1px);
            }

            .btn-secondary {
                background: #ffffff;
                border: 1px solid #cbdde9;
                color: #2c6288;
            }

            .btn-secondary:hover {
                background: #f8fafd;
                border-color: #9bb7cc;
                transform: translateY(-1px);
            }

            .btn-identify {
                background: #12b76a;
                color: white;
                box-shadow: 0 2px 6px rgba(155, 89, 182, 0.25);
            }

            .btn-identify:hover {
                background: #10a962;
                color: white;
                box-shadow: 0 2px 6px rgba(155, 89, 182, 0.25);
            }

            .btn-icon {
                font-size: 1.1rem;
                line-height: 1;
            }

            /* Journal des événements */
            .events-panel {
                padding: 0.8rem 1.5rem 1rem 1.5rem;
                background: #fbfdff;
            }

            .events-header {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 0.6rem;
                font-weight: 600;
                color: #1e2f41;
                font-size: 1rem;
                letter-spacing: -0.2px;
            }

            .events-header span:first-child {
                font-size: 1.25rem;
            }

            .events-list {
                background: #ffffff;
                border-radius: 0.8rem;
                border: 1px solid #eef2f8;
                min-height: 120px;
                max-height: 220px;
                overflow-y: auto;
                padding: 0.5rem 0;
                transition: all 0.1s;
                box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.01), 0 1px 2px rgba(0, 0, 0, 0.02);
            }

            .empty-events {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 1.5rem 1rem;
                color: #8ea0b0;
                font-size: 0.85rem;
                gap: 0.4rem;
                text-align: center;
            }

            .empty-icon {
                font-size: 2rem;
                opacity: 0.5;
            }

            .event-item {
                padding: 0.7rem 1.2rem;
                border-bottom: 1px solid #f0f4fa;
                font-size: 0.85rem;
                display: flex;
                align-items: flex-start;
                gap: 0.7rem;
                transition: background 0.1s;
                font-family: 'SF Mono', 'Segoe UI Mono', monospace;
            }

            .event-item:last-child {
                border-bottom: none;
            }

            .event-time {
                color: #6f8eaa;
                font-weight: 450;
                min-width: 70px;
                font-size: 0.7rem;
                letter-spacing: 0.2px;
                background: #f5f9fe;
                padding: 0.2rem 0.5rem;
                border-radius: 20px;
                text-align: center;
            }

            .event-text {
                color: #1a394f;
                word-break: break-word;
                flex: 1;
            }

            /* États dynamiques (animation discrète) */
            .simulate-reading {
                transition: all 0.1s;
            }

            /* Scroll personnalisé */
            .events-list::-webkit-scrollbar {
                width: 5px;
            }

            .events-list::-webkit-scrollbar-track {
                background: #eef2f8;
                border-radius: 10px;
            }

            .events-list::-webkit-scrollbar-thumb {
                background: #bcd0e0;
                border-radius: 10px;
            }

            /* Responsive */
            @media (max-width: 550px) {
                .card-reader {
                    border-radius: 1.5rem;
                }

                .header,
                .progress-section,
                .actions,
                .events-panel {
                    padding-left: 1.3rem;
                    padding-right: 1.3rem;
                }

                .btn {
                    padding: 0.6rem 1.2rem;
                    font-size: 0.85rem;
                }

                .title {
                    font-size: 1.4rem;
                }
            }

            /* Animation clignotement pour lecture active (optionnel) */
            @keyframes pulse {
                0% {
                    opacity: 0.6;
                }

                100% {
                    opacity: 1;
                }
            }

            .reading-active .progress-fill {
                background: linear-gradient(90deg, #2b9b6e, #3ccf8f);
            }
        </style>
    @endsection

    @section('content')
        <div class="main-content app-content">
            <div class="container-fluid">

                <!-- HEADER -->
                <div class="biometric-header">
                    <x-biometric-header title="Service de reconnaissance via la carte"
                        description="Lecture de la carte pour l'identification" icon="ti ti-fingerprint" />
                    <div id="statusIndicator" class="status-indicator status-disconnected">
                        <i class="ti ti-wifi-off"></i>
                        <span>Déconnecté</span>
                    </div>
                </div>
                <div class="card-reader" id="cardReaderApp">
                    <div class="header">
                        <div class="title">
                            <span class="title-icon">🪪</span>
                            <span>Veuillez insérer votre carte</span>
                        </div>
                        <div class="status-area">
                            <div class="status-badge" id="statusBadge">Prêt à démarrer</div>
                            {{-- <div class="progress-tag" id="progressPercentLabel">0%</div> --}}
                        </div>
                    </div>

                    <div class="progress-section">
                        <div class="progress-label">
                            <span>Avancement de la reconnaissance</span>
                            <span class="progress-percent" id="progressPercentValue">0%</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-fill" id="progressFill" style="width: 0%;"></div>
                        </div>
                    </div>

                    <div class="actions">
                        <div class="start-reset-btn">
                            <button class="btn btn-primary" id="startBtn">
                                Démarrer la lecture
                            </button>
                            <button class="btn btn-secondary" id="resetBtn">
                                Reset
                            </button>
                        </div>
                        <div class="identification-btn">
                            <button class="btn btn-identify" id="identifyBtn">
                                Identifier
                            </button>
                        </div>
                    </div>

                    <div class="events-panel">
                        <div class="events-header">
                            <span>📋</span> Journal des événements
                        </div>
                        <div class="events-list" id="eventsList">
                            <div class="empty-events" id="emptyEventsMsg">
                                <div class="empty-icon">📭</div>
                                <div>Aucun événement à afficher❌</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
            //Initialisation des variables
            let startBtn = document.getElementById('startBtn');
            let resetBtn = document.getElementById('resetBtn');
            let statusIndicator = document.getElementById('statusIndicator');
            let statusBadge = document.getElementById('statusBadge');
            let progressPercentValue = document.getElementById('progressPercentValue');
            let progressFill = document.getElementById('progressFill');
            let eventsList = document.getElementById('eventsList');
            let emptyEventsMsg = document.getElementById('emptyEventsMsg');

            let websocket = null;
            //Établir la connexion WebSocket
            function connectWebSocket() {
                if (websocket) {
                    websocket.close();
                }

                websocket = new WebSocket('wss://localhost:8443/ws/biometric-events');

                websocket.onopen = () => {
                    console.log('WebSocket connecté pour la lecture des cartes');
                    setStatus('status-connected', 'Connecté', 'ti ti-wifi');
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
                };
            }

            const processSteps = {
                'OWNER_INFO': {
                    weight: 10,
                    label: 'Extraction des données'
                },
                'SMARTCARD_READ': {
                    weight: 20,
                    label: 'Lecture de la carte'
                },
                'BIOMETRIC_LECTEUR_PRODUCT': {
                    weight: 25,
                    label: 'Initialisation du lecteur'
                },
                'BIOMETRIC_INIT': {
                    weight: 40,
                    label: 'Initialisation biométrique'
                },
                'FINGER_STATUS': {
                    weight: 50,
                    label: 'Détection du doigt'
                },
                'FINGER_QUALITY': {
                    weight: 60,
                    label: 'Vérification qualité'
                },
                'CAPTURE_COMPLETED': {
                    weight: 70,
                    label: 'Capture terminée'
                },
                'IMAGE_PROCESSING': {
                    weight: 80,
                    label: 'Traitement image'
                },
                'MATCHING_COMPLETED': {
                    weight: 90,
                    label: 'Comparaison terminée'
                },
                'PROCESS_COMPLETED': {
                    weight: 100,
                    label: 'Processus terminé'
                }
            };

            //Gestion des événements WebSocket
            function handleWebSocketMessage(data) {
                console.log('Message WebSocket reçu:', data);

                const {
                    type,
                    message
                } = data;

                switch (type) {
                    case 'SmartCardConnectionError':
                        // Gérer les erreurs
                        Swal.fire({
                            icon: 'error',
                            title: 'Lecteur de carte non détecté',
                            text: 'Veuillez connecter un lecteur de carte'
                        });
                        break;
                    case 'OWNER_INFO':
                        console.log(processSteps['OWNER_INFO'].label);
                        updateProgressUI(processSteps['OWNER_INFO'].weight);
                        break;

                    case 'SMARTCARD_READ':
                        console.log(processSteps['SMARTCARD_READ'].label);
                        updateProgressUI(processSteps['SMARTCARD_READ'].weight);
                        break;

                    case 'BIOMETRIC_LECTEUR_PRODUCT':
                        console.log(processSteps['BIOMETRIC_LECTEUR_PRODUCT'].label);
                        updateProgressUI(processSteps['BIOMETRIC_LECTEUR_PRODUCT'].weight);
                        break;

                    case 'BIOMETRIC_INIT':
                        console.log(processSteps['BIOMETRIC_INIT'].label);
                        updateProgressUI(processSteps['BIOMETRIC_INIT'].weight);
                        break;

                    case 'FINGER_STATUS':
                        console.log(processSteps['FINGER_STATUS'].label);
                        updateProgressUI(processSteps['FINGER_STATUS'].weight);
                        break;

                    case 'FINGER_QUALITY':
                        console.log(processSteps['FINGER_QUALITY'].label);
                        updateProgressUI(processSteps['FINGER_QUALITY'].weight);
                        break;

                    case 'CAPTURE_COMPLETED':
                        console.log(processSteps['CAPTURE_COMPLETED'].label);
                        updateProgressUI(100);
                        break;

                        // case 'IMAGE_PROCESSING':
                        //     console.log(processSteps['IMAGE_PROCESSING'].label);
                        //     updateProgressUI(processSteps['IMAGE_PROCESSING'].weight);
                        //     break;
                        // case 'MATCHING_COMPLETED':
                        //     console.log(processSteps['MATCHING_COMPLETED'].label);
                        //     updateProgressUI(processSteps['MATCHING_COMPLETED'].weight);
                        //     break;
                        // case 'PROCESS_COMPLETED':
                        //     console.log(processSteps['PROCESS_COMPLETED'].label);
                        //     updateProgressUI(processSteps['PROCESS_COMPLETED'].weight);
                        //     break;

                    default:
                        console.log('Message non géré:', type, message);
                }
            }


            //Gestion du statut
            function setStatus(type, text, icon) {
                statusIndicator.classList.remove(
                    'status-connected',
                    'status-disconnected',
                    'status-connecting'
                );

                statusIndicator.classList.add(type);
                statusIndicator.innerHTML = `<i class="${icon}"></i><span>${text}</span>`;
            }

            // Mise à jour de l'affichage de progression
            function updateProgressUI(percent) {
                const clamped = Math.min(100, Math.max(0, percent));
                progressFill.style.width = `${clamped}%`;
                progressPercentValue.innerText = `${Math.floor(clamped)}%`;
            }

            startBtn.addEventListener('click', async () => {
                try {
                    const response = await fetch('https://localhost:8443/read-and-match', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    console.log('Click sur le bouton de démarrage');

                    console.log(response);
                    // if (!response.ok) {
                    //     throw new Error(`HTTP error! status: ${response.status}`);
                    // }

                    // const result = await response.json();
                    // console.log('Résultat final:', result);
                    // return result;
                } catch (error) {
                    console.error('Erreur lors de la requête:', error);
                    throw error;
                }
            });

            connectWebSocket();
        </script>
    @endsection
</x-app-layout>
