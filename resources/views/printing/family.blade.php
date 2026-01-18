@php
    use Carbon\Carbon;
    $mytime = Carbon::now();
    $printed_time = $mytime->toDateTimeString();
    $time = Carbon::now()->format('d/m/Y');
@endphp
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Familiale - SSN: {{ $ssn }}</title>
    <link rel="icon" href="{{ URL::asset('assets/images/favicon/myafia_favicon.png') }}" type="image/x-icon" />
    <style>
        /* Base styles */
        body {
            margin: 0;
            padding: 0;
            font-family: "Roboto", -apple-system, "San Francisco", "Segoe UI", "Helvetica Neue", sans-serif;
            font-size: 12pt;
            background-color: #f8f9fa;
            background-image: linear-gradient(rgba(255, 255, 255, 0.5) 2px, transparent 2px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.5) 2px, transparent 2px);
            background-size: 50px 50px;
            background-position: center center;
        }

        /* Apply box-sizing: border-box to all elements */
        *,
        *:before,
        *:after {
            box-sizing: border-box;
        }

        /* Header styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 15px 40px;
            border-bottom: 1px solid #3498db;
            /* Blue border */
            background: linear-gradient(to right, #ffffff, #e8f7ff, #ffffff);
            /* Gradient background */
        }

        .header-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .header-title {
            flex-grow: 1;
            text-align: center;
        }

        .fiche-title {
            border: 2px solid #000;
            padding: 8px 40px;
            font-size: 1.5rem;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }

        /* Content area */
        .content-wrapper {
            margin: 20px 40px;
        }

        /* Date display */
        .date-display {
            text-align: right;
            margin-bottom: 20px;
        }

        /* Patient info section */
        .patient-info {
            display: flex;
            flex-wrap: wrap;
            margin: 20px 0;
            border: 1px solid #3498db;
            /* Blue border */
            padding: 15px;
            border-radius: 8px;
            background-color: #eaf7ff;
            /* Light blue background */
            column-gap: 1rem;
        }

        .patient-info-item {
            width: 48%;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px dotted #3498db;
            /* Blue dotted border */
            display: flex;
            justify-content: space-between;
        }

        /* Family members table */
        .family-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            /* Subtle shadow */
        }

        .family-table th {
            background-color: #2980b9;
            /* Darker blue header */
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #3498db;
            white-space: nowrap;
        }

        .family-table td {
            padding: 8px;
            border: 1px solid #bde0ff;
            /* Light blue border */
            vertical-align: middle;
        }

        /* Set column widths */
        .family-table th:nth-child(1),
        .family-table td:nth-child(1) {
            width: 90px;
            text-align: center;
        }

        .family-table th:nth-child(2),
        .family-table td:nth-child(2) {
            width: 25%;
        }

        .family-table th:nth-child(3),
        .family-table td:nth-child(3) {
            width: 15%;
        }

        .family-table th:nth-child(4),
        .family-table td:nth-child(4) {
            width: 15%;
        }

        .family-table th:nth-child(5),
        .family-table td:nth-child(5) {
            width: 10%;
        }

        .family-table th:nth-child(6),
        .family-table td:nth-child(6) {
            width: 15%;
            text-align: center;
        }

        /* Row styling */
        .family-table tr:nth-child(even) {
            background-color: #ecf9ff;
            /* Light blue rows */
        }

        .family-table tr:nth-child(odd) {
            background-color: #f8fdff;
            /* Very light blue rows */
        }

        .family-table tr.primary-member {
            background-color: #d6eaff;
            /* Highlighted blue for primary member */
        }

        /* Member photo styles */
        .member-photo {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #ddd;
            margin: 0 auto;
            display: block;
        }

        /* Access indicators */
        .exception_yes {
            background: #4caf50;
            color: #fff;
            padding: 4px 15px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: bold;
            display: inline-block;
            text-transform: uppercase;
        }

        .exception_no {
            background: #E91E63;
            color: #fff;
            padding: 4px 15px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: bold;
            display: inline-block;
            text-transform: uppercase;
        }

        /* Signature section */
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #3498db;
            /* Blue border */
            background: linear-gradient(to bottom, #ffffff, #f0f8ff);
            /* Subtle gradient */
            padding: 20px;
            border-radius: 8px;
        }

        .signature-left {
            width: 60%;
            font-weight: bold;
        }

        .signature-right {
            width: 40%;
            text-align: center;
        }

        /* Footer */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            padding: 15px 40px;
            border-top: 1px solid #3498db;
            /* Blue border */
            background: linear-gradient(to right, #ffffff, #e8f7ff, #ffffff);
            /* Gradient background */
        }

        .qr-section {
            width: 25%;
        }

        .doc-info {
            width: 50%;
            text-align: center;
        }

        .print-info {
            width: 25%;
            text-align: right;
            font-size: 0.8rem;
        }

        /* Print styles - ensure colors are preserved */
        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
                background-image: linear-gradient(rgba(220, 240, 255, 0.3) 2px, transparent 2px),
                    linear-gradient(90deg, rgba(220, 240, 255, 0.3) 2px, transparent 2px);
                background-size: 50px 50px;
            }

            /* Ensure colors print */
            .family-table th,
            .family-table tr.primary-member,
            .family-table tr:nth-child(even),
            .family-table tr:nth-child(odd),
            .patient-info,
            .header,
            .footer,
            .signature {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            /* Format for landscape A4 */
            @page {
                size: A4 landscape;
                margin: 0.5cm;
            }

            /* Ensure header and footer appear properly */
            .header,
            .footer {
                width: 100%;
            }

            /* Ensure table headers repeat on each page */
            .family-table thead {
                display: table-header-group;
            }

            /* Prevent table rows from breaking across pages */
            .family-table tr {
                page-break-inside: avoid;
            }

            /* Allow page breaks between sections */
            .patient-info,
            .signature,
            .footer {
                page-break-inside: avoid;
                page-break-before: auto;
            }

            /* Control where page breaks can occur */
            h3 {
                page-break-after: avoid;
            }
        }
    </style>
</head>

<body>
    <!-- Header section -->
    <div class="header">
        <img class="header-logo" src="{{ asset('assets/images/myafia_only_logo.png') }}" alt="MyAfia Logo">
        <div class="header-title">
            <span class="fiche-title">FICHE FAMILIALE</span>
        </div>
        <img class="header-logo" src="{{ asset('assets/images/cnss_logo.png') }}" alt="CNSS Logo">
    </div>

    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Date display -->
        <div class="date-display">
            DJIBOUTI, le {{ $time }}
        </div>

        <!-- Patient info -->
        <div class="patient-info">
            <div class="patient-info-item">
                <strong>Numéro de sécurité sociale (SSN):</strong>
                <span>{{ $ssn }}</span>
            </div>
            <div class="patient-info-item">
                <strong>Imprimé par:</strong>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <div class="patient-info-item">
                <strong>Site Agent:</strong>
                <span>{{ auth()->user()->place }}</span>
            </div>
        </div>

        <!-- Family members table -->
        <h3>Membres de la famille</h3>
        <table class="family-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Nom</th>
                    <th>Lien parenté</th>
                    <th>Date de naissance</th>
                    <th>Âge</th>
                    <th>Accès aux soins</th>
                </tr>
            </thead>
            <tbody>
                @forelse($familyMembers as $member)
                    <tr class="{{ $member->RelationCode == 1 ? 'primary-member' : '' }}">
                        <td style="text-align: center;">
                            <img src="{{ $member->Photo }}" alt="Photo" class="member-photo">
                        </td>
                        <td><strong>{{ $member->Nom }}</strong></td>
                        <td>{{ $member->{'Lien parenté'} }}</td>
                        <td>{{ $member->formatted_birth_date }}</td>
                        <td>{{ $member->Age }} ans</td>
                        <td style="text-align: center;">
                            <span class="{{ $member->Acces_soin == 'OUI' ? 'exception_yes' : 'exception_no' }}">
                                {{ $member->Acces_soin }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Aucun membre de famille trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Signature section -->
        <div class="signature">
            <div class="signature-left">
                Ce document, émis officiellement par la CNSS, ne doit faire l’objet d’aucune falsification ou usage
                frauduleux, sous peine de sanctions pénales.
            </div>
            {{-- <div class="signature-right">
                <p style="margin-bottom: 30px;">Cachet bureau d'entrée</p>
            </div> --}}
        </div>
    </div>

    <!-- Footer section -->
    <div class="footer">
        <div class="qr-section">
            <div id="qrcodeTarget" style="width: 60px; height: 60px;"></div>
        </div>
        <div class="doc-info">
            <strong>Fiche Familiale - SSN: {{ $ssn }}</strong>
            <div>CNSS - Caisse Nationale de Sécurité Sociale</div>
        </div>
        <div class="print-info">
            <div>Date d'impression: {{ $printed_time }}</div>
            <div>Imprimé par: {{ auth()->user()->name }}</div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ URL::asset('assets/libs/jquery/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/barcode/qrcode.min.js') }}"></script>
    <script>
        // Generate QR code
        var qrcode = new QRCode(document.getElementById("qrcodeTarget"), {
            text: "FAMILY-{{ $ssn }}",
            width: 60,
            height: 60,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    </script>
</body>

</html>
