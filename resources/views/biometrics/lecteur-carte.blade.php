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

            .card-reader {
                width: 100%;
                background: #ffffff;
                border-radius: 1rem;
                box-shadow: 0 10px 30px -8px rgba(0, 0, 0, 0.15), 0 4px 12px rgba(0, 0, 0, 0.05);
                overflow: hidden;
            }

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

            .status-badge.waiting {
                background: #fffbeb;
                border-left-color: #f59e0b;
                color: #92400e;
            }

            .status-badge.waiting::before {
                color: #f59e0b;
            }

            .status-badge.error {
                background: #fef2f2;
                border-left-color: #ef4444;
                color: #991b1b;
            }

            .status-badge.error::before {
                color: #ef4444;
            }

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
            }

            .progress-fill {
                width: 0%;
                height: 100%;
                background: linear-gradient(90deg, #2b7bbb, #3c9ad8);
                border-radius: 100px;
                transition: width 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            }

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
            }

            .btn-secondary {
                background: #ffffff;
                border: 1px solid #cbdde9;
                color: #2c6288;
            }

            .btn-secondary:hover {
                background: #f8fafd;
                border-color: #9bb7cc;
            }

            .btn-identify {
                background: #12b76a;
                color: white;
                box-shadow: 0 2px 6px rgba(18, 183, 106, 0.25);
            }

            .btn-identify:hover:not(:disabled) {
                background: #10a962;
            }

            .btn-identify:disabled {
                background: #94a3b8;
                cursor: not-allowed;
                box-shadow: none;
            }

            /* Members section */
            #membersSection {
                padding: 1rem 1.5rem;
                border-bottom: 1px solid #ecf1f7;
                display: none;
            }

            .members-title {
                font-size: 1rem;
                font-weight: 600;
                color: #1e2f41;
                margin-bottom: 0.8rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .members-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
                gap: 0.8rem;
            }

            .member-card {
                background: #f8fafd;
                border: 2px solid #e2e8f0;
                border-radius: 0.75rem;
                padding: 1rem;
                cursor: pointer;
                transition: all 0.2s ease;
                position: relative;
            }

            .member-card:hover {
                border-color: #3c9ad8;
                background: #f0f8ff;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(60, 154, 216, 0.15);
            }

            .member-card.selected {
                border-color: #1a6d9f;
                background: #e8f4fd;
                box-shadow: 0 0 0 3px rgba(26, 109, 159, 0.15);
            }

            .member-card.selected::after {
                content: "✓";
                position: absolute;
                top: 0.5rem;
                right: 0.7rem;
                color: #1a6d9f;
                font-weight: 700;
                font-size: 1rem;
            }

            .member-photo {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid #e2e8f0;
                margin-bottom: 0.6rem;
                display: block;
            }

            .member-photo-placeholder {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                background: #e2e8f0;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.6rem;
                margin-bottom: 0.6rem;
            }

            .member-name {
                font-weight: 700;
                font-size: 0.95rem;
                color: #1a2c3e;
                margin-bottom: 0.3rem;
            }

            .member-detail {
                font-size: 0.8rem;
                color: #64748b;
                margin-bottom: 0.15rem;
                display: flex;
                align-items: center;
                gap: 0.3rem;
            }

            .member-relation {
                display: inline-block;
                margin-top: 0.5rem;
                padding: 0.2rem 0.6rem;
                background: #dbeafe;
                color: #1e40af;
                border-radius: 1rem;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .member-finger {
                display: inline-block;
                margin-top: 0.4rem;
                padding: 0.2rem 0.6rem;
                background: #f0fdf4;
                color: #166534;
                border-radius: 1rem;
                font-size: 0.75rem;
                font-weight: 600;
            }

            /* Selected member summary */
            #selectedMemberInfo {
                padding: 0.6rem 1.5rem;
                background: #f0f8ff;
                border-bottom: 1px solid #bfdbfe;
                display: none;
                align-items: center;
                gap: 0.6rem;
                font-size: 0.9rem;
                color: #1e40af;
            }

            #selectedMemberInfo .sel-icon {
                font-size: 1.2rem;
            }

            /* Events panel */
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
            }

            .events-list {
                background: #ffffff;
                border-radius: 0.8rem;
                border: 1px solid #eef2f8;
                min-height: 100px;
                max-height: 200px;
                overflow-y: auto;
                padding: 0.5rem 0;
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

            .event-item {
                padding: 0.7rem 1.2rem;
                border-bottom: 1px solid #f0f4fa;
                font-size: 0.85rem;
                display: flex;
                align-items: flex-start;
                gap: 0.7rem;
                font-family: 'SF Mono', 'Segoe UI Mono', monospace;
            }

            .event-item:last-child {
                border-bottom: none;
            }

            .event-time {
                color: #6f8eaa;
                min-width: 70px;
                font-size: 0.7rem;
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

            .result-field {
                display: flex;
                gap: 0.5rem;
                padding: 0.35rem 0;
                border-bottom: 1px dashed #e2e8f0;
                font-size: 0.88rem;
            }
            .result-field:last-child { border-bottom: none; }
            .rf-label {
                color: #64748b;
                min-width: 140px;
                font-weight: 500;
            }
            .rf-value {
                color: #1a2c3e;
                font-weight: 600;
            }

            .events-list::-webkit-scrollbar { width: 5px; }
            .events-list::-webkit-scrollbar-track { background: #eef2f8; border-radius: 10px; }
            .events-list::-webkit-scrollbar-thumb { background: #bcd0e0; border-radius: 10px; }

            /* Fingerprint preview */
            #fingerprintPreview {
                display: none;
                padding: 1rem 1.5rem;
                border-bottom: 1px solid #ecf1f7;
                align-items: center;
                gap: 1.2rem;
            }

            .fp-preview-label {
                font-size: 0.92rem;
                font-weight: 600;
                color: #1e2f41;
                margin-bottom: 0.5rem;
                display: flex;
                align-items: center;
                gap: 0.4rem;
            }

            .fp-scanner-wrap {
                width: 160px;
                height: 200px;
                border-radius: 0.75rem;
                border: 3px solid #e2e8f0;
                background: #f0f4f9;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                position: relative;
                flex-shrink: 0;
                transition: border-color 0.3s ease;
            }

            .fp-scanner-wrap.active {
                border-color: #12b76a;
                box-shadow: 0 0 0 4px rgba(18, 183, 106, 0.15);
            }

            .fp-scanner-wrap.active::after {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 3px;
                background: linear-gradient(90deg, transparent, #12b76a, transparent);
                animation: fp-scan 1.5s linear infinite;
            }

            @keyframes fp-scan {
                0%   { top: 0; }
                100% { top: 100%; }
            }

            #fpPreviewImage {
                width: 100%;
                height: 100%;
                object-fit: contain;
                display: none;
            }

            .fp-placeholder-icon {
                font-size: 3rem;
                opacity: 0.3;
            }

            .fp-info-text {
                font-size: 0.82rem;
                color: #64748b;
                margin-top: 0.4rem;
                text-align: center;
            }

            @keyframes fp-pulse-ring {
                0%   { box-shadow: 0 0 0 0 rgba(18, 183, 106, 0.5); }
                70%  { box-shadow: 0 0 0 12px rgba(18, 183, 106, 0); }
                100% { box-shadow: 0 0 0 0 rgba(18, 183, 106, 0); }
            }

            .fp-scanner-wrap.detected {
                border-color: #12b76a;
                animation: fp-pulse-ring 0.8s ease-out;
            }

            .fp-quality-bar {
                height: 6px;
                background: #e2e8f0;
                border-radius: 3px;
                margin-top: 0.5rem;
                overflow: hidden;
                width: 160px;
            }

            .fp-quality-fill {
                height: 100%;
                background: linear-gradient(90deg, #f59e0b, #12b76a);
                border-radius: 3px;
                transition: width 0.3s ease;
                width: 0%;
            }

            @keyframes pulse { 0% { opacity: 0.6; } 100% { opacity: 1; } }

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

                    <!-- Title + status badge -->
                    <div class="header">
                        <div class="title">
                            <span>🪪</span>
                            <span>Authentification par carte à puce</span>
                        </div>
                        <div class="status-badge" id="statusBadge">Prêt à démarrer</div>
                    </div>

                    <!-- Progress bar -->
                    <div class="progress-section">
                        <div class="progress-label">
                            <span id="progressLabel">Avancement de la reconnaissance</span>
                            <span class="progress-percent" id="progressPercentValue">0%</span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-fill" id="progressFill" style="width: 0%;"></div>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="actions">
                        <div style="display:flex;gap:0.6rem;">
                            <button class="btn btn-primary" id="startBtn">
                                <i class="ti ti-credit-card"></i> Lire la carte
                            </button>
                            <button class="btn btn-secondary" id="resetBtn">
                                <i class="ti ti-refresh"></i> Reset
                            </button>
                        </div>
                        <button class="btn btn-identify" id="identifyBtn" disabled>
                            <i class="ti ti-fingerprint"></i> Identifier
                        </button>
                    </div>

                    <!-- Selected member summary bar -->
                    <div id="selectedMemberInfo">
                        <span class="sel-icon">👤</span>
                        <span id="selectedMemberText">Aucun membre sélectionné</span>
                    </div>

                    <!-- Members grid (shown after card read) -->
                    <div id="membersSection">
                        <div class="members-title">
                            <i class="ti ti-users"></i>
                            Bénéficiaires éligibles
                        </div>
                        <div class="members-grid" id="membersGrid"></div>
                    </div>

                    <!-- Result section -->
                    <div id="resultSection" style="display:none; padding:1.2rem 1.5rem; border-bottom:1px solid #ecf1f7;">
                        <div style="display:flex; align-items:center; gap:0.6rem; margin-bottom:1rem;">
                            <span id="resultIcon" style="font-size:1.6rem;"></span>
                            <span id="resultTitle" style="font-size:1.1rem; font-weight:700;"></span>
                        </div>
                        <div style="display:flex; gap:1.2rem; align-items:flex-start; flex-wrap:wrap;">
                            <img id="resultPhoto" style="width:90px;height:90px;border-radius:0.75rem;object-fit:cover;border:2px solid #e2e8f0;display:none;" alt="Photo" />
                            <div style="flex:1; min-width:180px;">
                                <div class="result-field"><span class="rf-label">Nom</span><span id="resultNom" class="rf-value"></span></div>
                                <div class="result-field"><span class="rf-label">Date de naissance</span><span id="resultDob" class="rf-value"></span></div>
                                <div class="result-field"><span class="rf-label">Sexe</span><span id="resultSexe" class="rf-value"></span></div>
                                <div class="result-field"><span class="rf-label">Relation</span><span id="resultRelation" class="rf-value"></span></div>
                                <div class="result-field"><span class="rf-label">Matricule</span><span id="resultMatricule" class="rf-value"></span></div>
                                <div class="result-field"><span class="rf-label">Score similarité</span><span id="resultScore" class="rf-value" style="font-weight:700;color:#1a6d9f;"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Events log -->
                    <div class="events-panel">
                        <div class="events-header">
                            <span>📋</span> Journal des événements
                        </div>
                        <div class="events-list" id="eventsList">
                            <div class="empty-events" id="emptyEventsMsg">
                                <div style="font-size:2rem;opacity:0.5;">📭</div>
                                <div>Aucun événement à afficher</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <script>
            const startBtn       = document.getElementById('startBtn');
            const resetBtn       = document.getElementById('resetBtn');
            const identifyBtn    = document.getElementById('identifyBtn');
            const statusIndicator = document.getElementById('statusIndicator');
            const statusBadge    = document.getElementById('statusBadge');
            const progressPercentValue = document.getElementById('progressPercentValue');
            const progressFill   = document.getElementById('progressFill');
            const progressLabel  = document.getElementById('progressLabel');
            const eventsList     = document.getElementById('eventsList');
            const emptyEventsMsg = document.getElementById('emptyEventsMsg');
            const membersSection = document.getElementById('membersSection');
            const membersGrid    = document.getElementById('membersGrid');
            const selectedMemberInfo = document.getElementById('selectedMemberInfo');
            const selectedMemberText = document.getElementById('selectedMemberText');

            let websocket = null;
            let selectedMember = null;
            let cardPhoto = null;
            let cardMatricule = null;
            let matchingDone = false;

            // ─── Relation code labels ───────────────────────────────────────
            const relationLabels = {
                1: 'Assuré Principal',
                2: 'Conjoint(e)',  3: 'Conjoint(e)',  4: 'Conjoint(e)',
                5: 'Conjoint(e)', 6: 'Conjoint(e)',  7: 'Conjoint(e)',
                8: 'Conjoint(e)', 9: 'Conjoint(e)',  10: 'Conjoint(e)',
            };
            const allowedCodesForMatching = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

            // ─── WebSocket ─────────────────────────────────────────────────
            function connectWebSocket() {
                if (websocket) websocket.close();

                websocket = new WebSocket('wss://localhost:8443/ws/biometric-events');

                websocket.onopen = () => {
                    setStatus('status-connected', 'Connecté', 'ti ti-wifi');
                };

                websocket.onmessage = (event) => {
                    try {
                        const data = JSON.parse(event.data);
                        // Logger TOUT dans le journal pour débogage
                        addEvent(`[WS RAW] type=${data.type || '?'} | msg=${data.message || ''} | data=${JSON.stringify(data.data ?? '')}`, true);
                        handleWebSocketMessage(data);
                    } catch (e) {
                        addEvent(`[WS PARSE ERROR] ${event.data}`, true);
                        console.error('WS parse error:', e);
                    }
                };

                websocket.onerror = () => {
                    setStatus('status-disconnected', 'Erreur', 'ti ti-alert-circle');
                };

                websocket.onclose = () => {
                    websocket = null;
                    setStatus('status-disconnected', 'Déconnecté', 'ti ti-wifi-off');
                };
            }

            function handleWebSocketMessage(data) {
                console.log('WS message COMPLET:', JSON.stringify(data));
                const type    = data.type;
                const message = data.message || '';

                switch (type) {
                    case 'SmartCardConnectionError':
                        Swal.fire({
                            icon: 'error',
                            title: 'Lecteur de carte non détecté',
                            text: 'Veuillez connecter un lecteur de carte et réessayer.'
                        });
                        addEvent('Erreur : Lecteur de carte non détecté');
                        break;

                    case 'BIOMETRIC_LECTEUR':
                        updateProgressUI(10, 'Lecture biométrique…');
                        addEvent('Lecture biométrique démarrée');
                        break;

                    case 'BIOMETRIC_LECTEUR_PRODUCT':
                        updateProgressUI(20, 'Initialisation du lecteur…');
                        addEvent('Lecteur initialisé');
                        break;

                    case 'BIOMETRIC_INIT':
                        updateProgressUI(40, 'Initialisation biométrique…');
                        addEvent('Biométrie initialisée');
                        break;

                    case 'CAPTURE_STARTING':
                        updateProgressUI(50, 'Démarrage de la capture…');
                        addEvent('Capture en cours — posez votre pouce');
                        showFingerprintPreview(true);
                        break;

                    case 'FINGER_STATUS':
                        updateProgressUI(60, 'Détection du doigt…');
                        addEvent('Doigt détecté');
                        animateFingerprintDetected();
                        break;

                    case 'FINGER_QUALITY':
                        updateProgressUI(70, 'Vérification de la qualité…');
                        addEvent('Qualité vérifiée');
                        animateFingerprintQuality();
                        break;

                    case 'IMAGE_PROCESSING':
                        updateProgressUI(80, 'Traitement de l\'image…');
                        addEvent('Traitement de l\'image');
                        break;

                    case 'IMAGE_PREVIEW': {
                        try {
                            const preview = typeof data.imageData !== 'undefined' ? data : JSON.parse(message);
                            const imgData = preview.imageData || preview.image || preview.data || null;
                            if (imgData) displayFingerprintPreview(imgData);
                        } catch(e) { /* pas d'image */ }
                        break;
                    }

                    case 'MATCHING_COMPLETED': {
                        const matchMsg = data.message || '';
                        const score    = data.data;
                        console.log('MATCHING_COMPLETED reçu — message:', matchMsg, '| score:', score, '| data complet:', JSON.stringify(data));
                        updateProgressUI(100, 'Identification terminée');
                        addEvent(`Comparaison terminée — ${matchMsg}${score !== undefined ? ' (score: ' + score + ')' : ''}`);
                        showFingerprintPreview(false);
                        Swal.fire({
                            icon: matchMsg.includes('SUCCESS') ? 'success' : 'error',
                            title: matchMsg.includes('SUCCESS') ? 'Identification réussie ✅' : 'Identification échouée ❌',
                            html: `<b>Message :</b> ${matchMsg}<br><b>Score :</b> ${score !== undefined ? score : '—'}`,
                            timer: 4000,
                            timerProgressBar: true
                        });
                        showMatchingResult(matchMsg, score);
                        break;
                    }

                    case 'CAPTURE_COMPLETED':
                        updateProgressUI(85, 'Capture terminée…');
                        addEvent(`Capture terminée — ${message}`);
                        break;

                    case 'LED_OFF':
                        addEvent('LED éteinte');
                        break;

                    case 'DEVICE_OFF': {
                        addEvent('Appareil fermé');
                        if (!matchingDone) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Matching terminé — aucun résultat WS',
                                html: `L'événement <b>MATCHING_COMPLETED</b> n'est pas arrivé.<br>Vérifiez la console pour la réponse HTTP.`,
                                confirmButtonColor: '#1a6d9f'
                            });
                        }
                        break;
                    }

                    case 'FILES_READING': {
                        updateProgressUI(90, 'Lecture des fichiers…');
                        addEvent(`Lecture fichiers — ${message}`);
                        console.log('FILES_READING data complet:', JSON.stringify(data));
                        break;
                    }

                    default: {
                        if (type) {
                            addEvent(`Événement : ${type}${message ? ' — ' + message : ''}`);
                            console.log(`[WS DEFAULT] type=${type} | data=`, JSON.stringify(data));
                            const allStr = JSON.stringify(data);
                            if (allStr.includes('SUCCESS') || allStr.includes('FAILED')) {
                                const s = data.score ?? data.data ?? data.similarity ?? null;
                                showFingerprintPreview(false);
                                updateProgressUI(100, 'Identification terminée');
                                showMatchingResult(allStr.includes('SUCCESS') ? 'SUCCESS' : 'FAILED', s);
                            }
                        }
                        break;
                    }
                }
            }

            // ─── Card reading ───────────────────────────────────────────────
            startBtn.addEventListener('click', async () => {
                resetUI(false);
                setStatusBadge('waiting', 'Lecture en cours…');
                addEvent('Démarrage de la lecture de la carte…');
                updateProgressUI(5, 'Lecture de la carte…');
                startBtn.disabled = true;

                try {
                    // Récupérer les membres de la carte
                    addEvent('Récupération des bénéficiaires…');
                    const response = await fetch('https://localhost:8443/get-members-myafia');

                    if (!response.ok) {
                        const errData = await response.json().catch(() => ({}));
                        const errMsg  = errData.error || `Erreur HTTP ${response.status}`;
                        if (response.status === 500 || errMsg.toLowerCase().includes('connect')) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Carte non détectée',
                                text: 'Veuillez insérer votre carte à puce dans le lecteur et réessayer.',
                                confirmButtonColor: '#1a6d9f'
                            });
                            addEvent('Aucune carte détectée — insérez la carte et réessayez');
                            setStatusBadge('error', 'Carte non détectée');
                        } else {
                            addEvent(`Erreur : ${errMsg}`);
                            setStatusBadge('error', 'Erreur de lecture');
                        }
                        updateProgressUI(0, 'Avancement de la reconnaissance');
                        startBtn.disabled = false;
                        return;
                    }

                    const cardData = await response.json();
                    console.log('Données carte:', cardData);

                    if (!response.ok || cardData.error) {
                        const errMsg = cardData.error || `Erreur HTTP ${response.status}`;
                        if (errMsg.includes('connect') || errMsg.includes('failed')) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Carte non détectée',
                                text: 'Veuillez insérer votre carte à puce dans le lecteur et réessayer.',
                                confirmButtonColor: '#1a6d9f'
                            });
                            addEvent('Aucune carte détectée — insérez la carte et réessayez');
                            setStatusBadge('error', 'Carte non détectée');
                        } else {
                            addEvent(`Erreur : ${errMsg}`);
                            setStatusBadge('error', 'Erreur de lecture');
                        }
                        updateProgressUI(0, 'Avancement de la reconnaissance');
                        startBtn.disabled = false;
                        return;
                    }

                    handleCardData(cardData);
                } catch (e) {
                    console.error('Erreur lecture carte:', e);
                    addEvent('Erreur lors de la lecture de la carte');
                    setStatusBadge('error', 'Erreur de lecture');
                    updateProgressUI(0, 'Avancement de la reconnaissance');
                    startBtn.disabled = false;
                }
            });

            function handleCardData(data) {
                console.log('Clés reçues:', Object.keys(data));

                // Réponse vide
                if (!data || Object.keys(data).length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Carte non lisible',
                        text: 'Le service n\'a retourné aucune donnée. Vérifiez que la carte est bien insérée.',
                        confirmButtonColor: '#1a6d9f'
                    });
                    addEvent('Réponse vide — carte non lisible');
                    setStatusBadge('error', 'Carte non lisible');
                    updateProgressUI(0, 'Avancement de la reconnaissance');
                    startBtn.disabled = false;
                    return;
                }

                // Stocker photo et matricule globalement
                cardPhoto     = data.photo || null;
                cardMatricule = data.matricule || null;

                // Filter eligible members (beneficiaire ou beneficiaires)
                const beneficiaires = data.beneficiaire || data.beneficiaires || data.members || data.membres || [];
                const eligible = beneficiaires.filter(b => allowedCodesForMatching.includes(Number(b.relationCode)) && b.IsoTemplate && b.IsoTemplate.length > 0);

                if (eligible.length === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Aucun bénéficiaire éligible',
                        text: 'Aucun bénéficiaire avec un code relation valide (1–10) n\'a été trouvé sur cette carte.',
                        confirmButtonColor: '#1a6d9f'
                    });
                    addEvent('Aucun bénéficiaire éligible trouvé');
                    setStatusBadge('error', 'Aucun bénéficiaire');
                    startBtn.disabled = false;
                    return;
                }

                updateProgressUI(25, 'Carte lue — sélectionnez un bénéficiaire');
                setStatusBadge('', `${eligible.length} bénéficiaire(s) trouvé(s)`);
                addEvent(`Carte lue — ${eligible.length} bénéficiaire(s) éligible(s)`);

                displayMembers(eligible);
                startBtn.disabled = false;
            }

            function isMatriculeInvalid(matricule) {
                if (!matricule || matricule.trim() === '') return true;
                return /^0+$/.test(matricule) || /^9+$/.test(matricule);
            }

            function displayMembers(members) {
                membersGrid.innerHTML = '';
                members.forEach(member => {
                    const card = document.createElement('div');
                    card.className = 'member-card';
                    card.dataset.memberId = member.id || member.Nom;

                    const relation = relationLabels[Number(member.relationCode)] || `Code ${member.relationCode}`;
                    const sexe = member.Sexe || '—';
                    const dob  = member.Date_Naissance || '—';
                    const nom  = member.Nom || '—';
                    const rawPhoto = member.Photo || member.photo || member.image || cardPhoto || null;
                    const photoSrc = rawPhoto
                        ? (rawPhoto.startsWith('data:') ? rawPhoto : `data:image/jpeg;base64,${rawPhoto}`)
                        : null;
                    const photoHtml = photoSrc
                        ? `<img class="member-photo" src="${photoSrc}" alt="${nom}" />`
                        : `<div class="member-photo-placeholder">👤</div>`;

                    card.innerHTML = `
                        ${photoHtml}
                        <div class="member-name">${nom}</div>
                        <div class="member-detail"><i class="ti ti-gender-bigender" style="font-size:0.9rem;"></i> ${sexe}</div>
                        <div class="member-detail"><i class="ti ti-calendar" style="font-size:0.9rem;"></i> ${dob}</div>
                        <span class="member-relation">${relation}</span>
                        <span class="member-finger">👆 Pouce Droit</span>
                    `;

                    card.addEventListener('click', () => selectMember(card, member));
                    membersGrid.appendChild(card);
                });

                membersSection.style.display = 'block';
            }

            function selectMember(cardEl, member) {
                // Remove previous selection
                document.querySelectorAll('.member-card.selected').forEach(c => c.classList.remove('selected'));
                cardEl.classList.add('selected');

                selectedMember = member;
                identifyBtn.disabled = false;

                selectedMemberText.textContent = `Sélectionné : ${member.Nom || '—'} (${relationLabels[Number(member.relationCode)] || 'Code ' + member.relationCode})`;
                selectedMemberInfo.style.display = 'flex';

                addEvent(`Membre sélectionné : ${member.Nom || '—'}`);
            }

            // ─── Identification ─────────────────────────────────────────────
            identifyBtn.addEventListener('click', async () => {
                if (!selectedMember) return;

                identifyBtn.disabled = true;
                startBtn.disabled = true;
                updateProgressUI(5, 'Envoi au moteur biométrique…');
                addEvent('Identification démarrée…');
                setStatusBadge('waiting', 'Identification en cours…');

                // Lancer la requête SANS await — la réponse HTTP contiendra le résultat
                fetch('https://localhost:8443/matching-one-to-one', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(selectedMember)
                })
                .then(async (response) => {
                    const responseText = await response.text();
                    console.log('Matching HTTP status:', response.status);
                    console.log('Matching response body RAW:', responseText);

                    if (!response.ok) {
                        Swal.fire({
                            icon: 'error',
                            title: `Erreur HTTP ${response.status}`,
                            html: `<pre style="text-align:left;font-size:0.8rem;max-height:200px;overflow:auto">${responseText || '(body vide)'}</pre>`,
                            confirmButtonColor: '#1a6d9f'
                        });
                        identifyBtn.disabled = false;
                        startBtn.disabled = false;
                        return;
                    }

                    if (!responseText || responseText.trim().length === 0) {
                        if (!matchingDone) {
                            console.log('Réponse HTTP vide — le résultat viendra via MATCHING_COMPLETED');
                        }
                        return;
                    }

                    let bodyStr = responseText;
                    let score = null;
                    try {
                        const responseData = JSON.parse(responseText);
                        console.log('Matching response JSON:', responseData);
                        bodyStr = JSON.stringify(responseData);
                        score = responseData.score ?? responseData.data ?? responseData.similarity ?? responseData.result ?? null;
                    } catch(e) { /* pas du JSON */ }

                    if (!matchingDone && (bodyStr.includes('SUCCESS') || bodyStr.includes('FAILED'))) {
                        showFingerprintPreview(false);
                        updateProgressUI(100, 'Identification terminée');
                        showMatchingResult(bodyStr.includes('SUCCESS') ? 'SUCCESS' : 'FAILED', score);
                    } else if (!matchingDone) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Réponse HTTP reçue',
                            html: `<pre style="text-align:left;font-size:0.8rem;max-height:200px;overflow:auto">${responseText}</pre>`,
                            confirmButtonColor: '#1a6d9f'
                        });
                    }
                })
                .catch(e => {
                    console.error('Erreur matching:', e);
                    Swal.fire({ icon: 'error', title: 'Erreur réseau', text: e.message, confirmButtonColor: '#1a6d9f' });
                    addEvent('Erreur lors de l\'envoi au moteur biométrique');
                    setStatusBadge('error', 'Erreur d\'identification');
                    identifyBtn.disabled = false;
                    startBtn.disabled = false;
                });

                addEvent('Requête envoyée — en attente des événements biométriques…');
            });

            function showMatchingResult(message, score) {
                matchingDone = true;
                const success = message.includes('SUCCESS');

                setStatusBadge(success ? '' : 'error', success ? 'Identifié ✓' : 'Non identifié');
                identifyBtn.disabled = false;
                startBtn.disabled = false;

                // Afficher la fiche résultat
                const resultSection = document.getElementById('resultSection');
                const resultIcon    = document.getElementById('resultIcon');
                const resultTitle   = document.getElementById('resultTitle');
                const resultPhoto   = document.getElementById('resultPhoto');
                const resultNom     = document.getElementById('resultNom');
                const resultDob     = document.getElementById('resultDob');
                const resultSexe    = document.getElementById('resultSexe');
                const resultRelation = document.getElementById('resultRelation');
                const resultScore   = document.getElementById('resultScore');
                const resultMatricule = document.getElementById('resultMatricule');

                resultIcon.textContent  = success ? '✅' : '❌';
                resultTitle.textContent = success ? 'Identification réussie' : 'Identification échouée';
                resultTitle.style.color = success ? '#166534' : '#991b1b';
                resultSection.style.borderTop = success ? '3px solid #12b76a' : '3px solid #ef4444';

                if (selectedMember) {
                    const rawPhoto = selectedMember.Photo || selectedMember.photo || cardPhoto || null;
                    const photoSrc = rawPhoto
                        ? (rawPhoto.startsWith('data:') ? rawPhoto : `data:image/jpeg;base64,${rawPhoto}`)
                        : null;

                    if (photoSrc) {
                        resultPhoto.src = photoSrc;
                        resultPhoto.style.display = 'block';
                    } else {
                        resultPhoto.style.display = 'none';
                    }

                    resultNom.textContent      = selectedMember.Nom || '—';
                    resultDob.textContent      = selectedMember.Date_Naissance || '—';
                    resultSexe.textContent     = selectedMember.Sexe || '—';
                    resultRelation.textContent = relationLabels[Number(selectedMember.relationCode)] || `Code ${selectedMember.relationCode}`;
                }

                resultScore.textContent     = score !== undefined && score !== null ? Number(score).toFixed(1) : '—';
                resultMatricule.textContent = cardMatricule || '—';

                resultSection.style.display = 'block';
                resultSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            // ─── Fingerprint preview ─────────────────────────────────────────
            function showFingerprintPreview(visible) {
                // Section supprimée — fonction conservée pour éviter les erreurs
            }

            function displayFingerprintPreview(imageData) {
                const img         = document.getElementById('fpPreviewImage');
                const placeholder = document.getElementById('fpPlaceholder');
                const infoText    = document.getElementById('fpInfoText');
                const scannerWrap = document.getElementById('fpScannerWrap');

                const src = imageData.startsWith('data:') ? imageData : `data:image/png;base64,${imageData}`;
                img.src = src;
                img.style.display = 'block';
                placeholder.style.display = 'none';
                scannerWrap.classList.add('active');
                infoText.textContent = 'Empreinte détectée';
            }

            let qualityCount = 0;
            function animateFingerprintDetected() {
                const scannerWrap = document.getElementById('fpScannerWrap');
                const infoText    = document.getElementById('fpInfoText');
                const placeholder = document.getElementById('fpPlaceholder');
                if (!scannerWrap) return;

                scannerWrap.classList.remove('detected');
                void scannerWrap.offsetWidth; // force reflow pour relancer l'animation
                scannerWrap.classList.add('active', 'detected');
                placeholder.textContent = '👆';
                placeholder.style.opacity = '1';
                infoText.textContent = 'Doigt détecté — gardez le pouce posé';
                qualityCount = 0;
                document.getElementById('fpQualityFill').style.width = '30%';
            }

            function animateFingerprintQuality() {
                const infoText = document.getElementById('fpInfoText');
                const fill     = document.getElementById('fpQualityFill');
                if (!fill) return;
                qualityCount++;
                const pct = Math.min(95, 30 + qualityCount * 20);
                fill.style.width = pct + '%';
                infoText.textContent = `Qualité : ${pct}%`;
            }

            // ─── Reset ──────────────────────────────────────────────────────
            resetBtn.addEventListener('click', () => resetUI(true));

            function resetUI(clearEvents) {
                selectedMember = null;
                identifyBtn.disabled = true;
                startBtn.disabled = false;
                membersSection.style.display = 'none';
                membersGrid.innerHTML = '';
                selectedMemberInfo.style.display = 'none';
                selectedMemberText.textContent = 'Aucun membre sélectionné';
                updateProgressUI(0, 'Avancement de la reconnaissance');
                setStatusBadge('', 'Prêt à démarrer');

                document.getElementById('resultSection').style.display = 'none';
                showFingerprintPreview(false);
                cardPhoto = null;
                cardMatricule = null;
                matchingDone = false;

                if (clearEvents) {
                    eventsList.innerHTML = '';
                    const empty = document.createElement('div');
                    empty.className = 'empty-events';
                    empty.id = 'emptyEventsMsg';
                    empty.innerHTML = '<div style="font-size:2rem;opacity:0.5;">📭</div><div>Aucun événement à afficher</div>';
                    eventsList.appendChild(empty);
                }
            }

            // ─── UI helpers ─────────────────────────────────────────────────
            function setStatus(cls, text, icon) {
                statusIndicator.classList.remove('status-connected', 'status-disconnected', 'status-connecting');
                statusIndicator.classList.add(cls);
                statusIndicator.innerHTML = `<i class="${icon}"></i><span>${text}</span>`;
            }

            function setStatusBadge(state, text) {
                statusBadge.className = 'status-badge' + (state ? ' ' + state : '');
                statusBadge.textContent = text;
            }

            function updateProgressUI(percent, label) {
                const clamped = Math.min(100, Math.max(0, percent));
                progressFill.style.width = `${clamped}%`;
                progressPercentValue.textContent = `${Math.floor(clamped)}%`;
                if (label) progressLabel.textContent = label;
            }

            function addEvent(text, isDebug = false) {
                const empty = document.getElementById('emptyEventsMsg');
                if (empty) empty.remove();

                const now  = new Date();
                const time = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

                const item = document.createElement('div');
                item.className = 'event-item';
                if (isDebug) item.style.cssText = 'background:#fffbeb;font-size:0.75rem;color:#92400e;';
                item.innerHTML = `<span class="event-time">${time}</span><span class="event-text">${text}</span>`;
                eventsList.appendChild(item);
                eventsList.scrollTop = eventsList.scrollHeight;
            }

            // ─── Init ────────────────────────────────────────────────────────
            connectWebSocket();
        </script>
    @endsection
</x-app-layout>
