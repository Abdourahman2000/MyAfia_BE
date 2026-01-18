@php

    $path = public_path() . '/pdf/logo.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
    $ssn = null;
    $mytime = Carbon\Carbon::now()->format('d/m/Y H:m:s');
    // $printed_time = $mytime->toDateTimeString();
    $printed_time = $mytime;

    $appointment = $diagnose->appointment;
    $patient = $appointment->patientGlobal;
    $patient_type = $patient->relation_name;
    $doctor = $appointment->doctor;

    $ssn = $patient->ssn;

    // $time = Carbon\Carbon::now()->format('d/m/Y');
    // $time = $diagnose->created_at->format('d/m/Y');
    $time = Carbon\Carbon::parse($diagnose->appointment->date)->format('d/m/Y');
    $current_date_time = Carbon\Carbon::now();

    $datetime1 = new DateTime($diagnose->arret_days_to);
    $datetime2 = new DateTime($diagnose->arret_days_from);
    $interval = $datetime1->diff($datetime2);
    $days = $interval->format('%a');
    $days_formated = str_pad($days + 1, 2, '0', STR_PAD_LEFT);

    $arret_from = Carbon\Carbon::createFromFormat('Y-m-d', $diagnose->arret_days_from)->format('d/m/Y');
    $arret_to = Carbon\Carbon::createFromFormat('Y-m-d', $diagnose->arret_days_to)->format('d/m/Y');

    $birth_date = Carbon\Carbon::parse($patient->birth)->format('d/m/Y');

    $arret = $appointment->appoint_number;

    // $arret = 'ARRET-000000881';

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Arret de travail</title>
    <link rel="icon" href="{{ URL::asset('assets/img/brand/favicon.png') }}" type="image/x-icon" />
    {{-- <link href="{{URL::asset('css/printing.css')}}" rel="stylesheet"> --}}
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: "Roboto", -apple-system, "San Francisco", "Segoe UI", "Helvetica Neue", sans-serif;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {

            margin: 1cm auto;
            background: #fff;
            box-shadow: 0 4px 5px rgba(75, 75, 75, 0.2);
            outline: 0;
        }

        /* Defines a class for manual page breaks via inserted .page-break element */
        div.page-break {
            page-break-after: always;
        }

        /* For top-level headings only */
        h1 {
            /* Force page breaks after */
            page-break-before: always;
        }

        /* For all headings */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            /* Avoid page breaks immediately */
            page-break-after: avoid;
        }

        /* For all paragraph tags */
        p {
            /* Reset the margin so that the text starts and ends at the expected marks */
            margin: 0;
        }

        /* For links in the document */
        a {
            /* Prevent colorization or decoration */
            text-decoration: none;
            color: black;
        }

        /* For tables in the document */
        table {
            /* Avoid page breaks inside */
            page-break-inside: avoid;
        }

        /* Use CSS Paged Media to switch from continuous documents to sheet-like documents with separate pages */
        @page {
            /* You can only change the size, margins, orphans, widows and page breaks here */

            /* Require that at least this many lines of a paragraph must be left at the bottom of a page */
            orphans: 4;
            /* Require that at least this many lines of a paragraph must be left at the top of a new page */
            widows: 2;
        }

        /* When the document is actually printed */
        @media print {

            html,
            body {
                background-color: #fff;
            }

            .page {

                width: initial !important;
                min-height: initial !important;
                margin: 0 !important;
                padding: 0 !important;
                border: initial !important;
                border-radius: initial !important;
                background: initial !important;
                box-shadow: initial !important;

                /* Force page breaks after each .page element of the document */
                page-break-after: always;
            }

            .printing_button {
                display: none;
            }
        }

        .page {
            width: 29.7cm;
            min-width: 29.7cm;
            min-height: 21cm;
            height: 21cm;
            padding-left: 0.2cm;
            padding-top: 0.2cm;
            padding-right: 0.2cm;
            padding-bottom: 0.2cm;
        }

        @page {
            size: A4 portrait;
            margin-left: 0.5cm;
            margin-top: 0.4cm;
            margin-right: 0.5cm;
            margin-bottom: 0.5cm;
            size: landscape
        }

        .full_page {
            display: flex;
            justify-content: space-between;
            width: 100%;
            height: 100%;
            height: 100vh;
            /* background: #ddd; */
        }

        .full_page .left {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: .5px dashed #000;
            padding: .5rem 1.5rem;
            /* padding: .5rem; */
            /* padding-right:.3rem; */
        }

        .full_page .right {
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* padding: .5rem; */
            padding: .5rem 1.5rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .header h4 {
            margin-bottom: 0;
        }

        .title {
            border-top: 1px solid #888;
            border-bottom: 1px solid #888;
            padding-top: .3rem;
            padding-bottom: .3rem;
        }

        .title p {
            font-size: .9rem;
        }

        .main {
            display: flex;
            justify-content: space-between;
            flex-direction: column;
        }

        .label_arret {
            text-align: center;
            border: 2px solid rgb(37, 37, 37);
            position: relative;
            padding: .5rem 5rem;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            width: fit-content;
            display: block;
            margin: 0 auto;
            margin-top: 1rem;
        }

        table.sub {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 90%;
            text-align: center;
            margin: 0 auto;
            margin-top: 2rem;
            font-size: .75rem;
        }

        table.sub th {
            font-size: .85em;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: .5rem;
        }

        table.sub td {
            padding: .625em;
            text-align: center;
        }

        table.sub tr {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: .35em;
        }

        .signature {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 4.5rem;
            font-size: .8rem;
        }

        .sign_doctor {
            text-align: center;
        }

        .paper_copy {
            font-size: .8rem;
            width: 100%;
            border-bottom: 1px solid #888;
            margin-bottom: .7rem;
            padding-bottom: .3rem;
        }

        .footer {
            margin-top: auto !important;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            font-size: .8rem;
        }

        .footer .qr_code {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            font-size: .6rem;
        }

        .footer .qr_code>span {
            display: block;
        }

        .bcTarget {
            display: block;
            margin: 0 auto;
            margin-top: .5rem;
        }

        .arret_message {
            margin-top: 2rem;
        }

        .arret_message>p {
            line-height: 1.5rem;
            text-align: justify;
            font-size: .8rem;
        }

        .arret_message>p:last-child {
            margin-top: 1rem;
        }

        /* Simulates the behavior of manual page breaks from `print` mode in `screen` mode */
        @media screen {

            /* Printing Button Start */
            .printing_button {
                text-align: center;
                position: relative;
            }

            .printing_button a {
                text-decoration: none;
                /* font-family: 'Roboto', sans-serif; */
                border-radius: 3rem;
                transition: .3s ease;
                border: 2px solid transparent;
                letter-spacing: 1px;
                font-size: .7rem;
            }

            .printing_button .back {
                position: absolute;
                top: 3rem;
                background-color: #ea6a8a;
                left: 10%;
                padding: .5rem 1rem;
                color: #fff;
            }

            .printing_button .back:hover {
                background-color: #fff;
                color: #ea6a8a;
                border-color: #ea6a8a;
            }

            .printing_button .print {
                background-color: #6aacea;
                color: #fff;
                /* font-weight: bolder; */
                text-transform: uppercase;
                position: absolute;
                top: 3rem;
                left: 20%;
                padding: 0.5rem 2rem;
            }

            .printing_button .print:hover {
                background-color: #fff;
                color: #6aacea;
                border-color: #6aacea;
            }

            div.page-break::before {
                content: "";
                display: block;
                /* Give a sufficient height to this element so that its drop shadow is properly rendered */
                height: 0.8cm;
                /* Offset the negative extra margin at the left of the non-pseudo element */
                margin-left: 0.5cm;
                /* Offset the negative extra margin at the right of the non-pseudo element */
                margin-right: 0.5cm;
                /* Make the bottom area appear as a part of the page margins of the upper virtual page */
                background-color: #fff;
                /* Show a drop shadow beneath the upper virtual page */
                box-shadow: 0 6px 5px rgba(75, 75, 75, 0.2);
            }

            /* Renders the empty space as a divider between the two virtual pages that are actually two parts of the same page */
            div.page-break {
                display: block;
                /* Assign the intended height plus the height of the pseudo element */
                height: 1.8cm;
                /* Apply a negative margin at the left to offset the page margins of the page plus some negative extra margin to paint over the border and shadow of the page */
                margin-left: -2.5cm;
                /* Apply a negative margin at the right to offset the page margins of the page plus some negative extra margin to paint over the border and shadow of the page */
                margin-right: -2.5cm;
                /* Create the bottom page margin on the upper virtual page (minus the height of the pseudo element) */
                margin-top: 1.2cm;
                /* Create the top page margin on the lower virtual page */
                margin-bottom: 2cm;
                /* Let this page appear as empty space between the virtual pages */
                /* background: #eee; */
            }
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 32px;
            color: rgba(0, 0, 0, 0.2);
            opacity: .4;
            /* Adjust the opacity as needed */
            pointer-events: none;
            /* Ensures the watermark doesn't interfere with the content */
        }
    </style>
</head>

<body>
    

    <div class="full_page" id="print_wrapper">
        <div class="left">
            <header class="header">
                <img class="logo" src="{{ $logo }}" alt="II" style="width: 100px;">
                <div style="text-align:center;">
                    <h4 style="margin:0;">Centre de Soins</h4>
                    {{-- <h4 style="margin:0;; margin-top:1rem; font-size:.8rem;">Arret de travail</h4> --}}
                </div>
            </header>
            <section class="title">
                <div style="display: flex; justify-content:space-between; margin-bottom:.5rem; font-size:.85rem;">
                    <p style="width:50%;"><span style="font-weight: bold; font-size:.8rem;">Nom du Patient:</span> <span
                            style="font-size:.8rem;">{{ $patient->name }}</span></p>
                    <p style="margin: 0;"><span style="font-weight: bold; font-size:.8rem;">Date de Naissance:</span>
                        <span style="font-size:.8rem;">{{ $birth_date }}</span>
                    </p>
                </div>
                <div style="display: flex; justify-content:space-between">
                    <p><span style="font-weight:bold; font-size:.8rem;">Sexe:</span> <span
                            style="margin-left:.5rem; font-size: .8rem;">
                            @if ($patient->gender == 1)
                                Féminin
                            @else
                                Masculin
                            @endif
                        </span></p>
                    <p style="margin: 0;"><span style="font-weight:bold; font-size:.8rem;">SSN Matricule:</span> <span
                            style="margin-left:1rem; font-size: .8rem;">{{ $ssn }}</span></p>
                </div>
            </section>
            <main class="main">
                <span style="margin-left:auto; margin-top:.8rem; font-size:.9rem;">DJIBOUTI, le
                    {{ $time }}</span>

                <span style="margin-top:.8rem; font-size:.9rem; width:100%; display:block">AVIS D'ARRET DE
                    TRAVAIL</span>
                <span style="margin-top:.8rem; font-size:.9rem; width:100%; display:block">Initial</span>
                <span class="label_arret">Arret de travail</span>

                <div class="arret_message">
                    <p>Je, soussigné(e), Docteur <strong>{{ $doctor->user->fullname }}</strong> Docteur en
                        médecine certifie avoir examiné ce jour <strong>
                            @if ($patient->gender == 1)
                                Mme.
                            @else
                                M.
                            @endif {{ $patient->name }}
                        </strong> et prescrit un arrêt de travail de <strong>{{ $days_formated }}
                            jour{{ $days_formated == 01 ? '' : 's' }}</strong> à compter du
                        <strong>{{ $arret_from }}</strong> jusqu'au
                        <strong>{{ $arret_to }}</strong> inclus.
                    </p>

                    <p>Cet arrêt de travail est délivré à l'interessée pour servir et faire valoir ce que de droit.
                    </p>

                </div>

                <div class="signature">
                    <div class="sign_patient">
                        <span>Signature du patient</span>
                    </div>
                    <div class="sign_doctor">
                        <p>Signature et cachet du médecin</p>
                        <p style="margin-top:1rem; font-weight:bold;">Dr.{{ $doctor->user->fullname }}</p>
                    </div>
                </div>
            </main>
            <strong style="margin-top: 1.5rem;font-size: .8rem;text-decoration: underline;">Ce document est certifié et délivré par l’un des médecins affiliés à l’hôpital de la CNSS</strong>

            <footer class="footer">
                <span class="paper_copy">Copie : PATIENT</span>
                <div class="br_code" style="text-align: center;">
                    {{-- Replace barcode with QR code --}}
                    {!! QrCode::size(60)->generate(route('arretCheck', $encryptedDiagnoseId)) !!}
                    {{-- <div id="barcodeTarget" class="bcTarget"></div> --}}
                </div>
                <div class="qr_code">
                    <span style="margin-bottom:.5rem;">Date d'impression: {{ $printed_time }}</span>
                    <span>Dr.{{ $doctor->user->fullname }}</span>
                </div>
            </footer>

        </div>
        <div class="right">
            <header class="header">
                <img class="logo" src="{{ $logo }}" alt="II" style="width: 100px;">
                <div style="text-align:center;">
                    <h4 style="margin:0;">Centre de Soins</h4>
                    {{-- <h4 style="margin:0;; margin-top:1rem; font-size:.8rem;">Arret de travail</h4> --}}
                </div>
            </header>
            <section class="title">
                <div style="display: flex; justify-content:space-between; margin-bottom:.5rem; font-size:.85rem;">
                    <p style="width:50%;"><span style="font-weight: bold; font-size:.8rem;">Nom du Patient:</span> <span
                            style="font-size:.8rem;">{{ $patient->name }}</span></p>
                    <p style="margin: 0;"><span style="font-weight: bold; font-size:.8rem;">Date de Naissance:</span>
                        <span style="font-size:.8rem;">{{ $birth_date }}</span>
                    </p>
                </div>
                <div style="display: flex; justify-content:space-between">
                    <p><span style="font-weight:bold; font-size:.8rem;">Sexe:</span> <span
                            style="margin-left:.5rem; font-size: .8rem;">
                            @if ($patient->gender == 1)
                                Féminin
                            @else
                                Masculin
                            @endif
                        </span></p>
                    <p style="margin: 0;"><span style="font-weight:bold; font-size:.8rem;">SSN Matricule:</span> <span
                            style="margin-left:1rem; font-size: .8rem;">{{ $ssn }}</span></p>
                </div>
            </section>
            <main class="main">
                <span style="margin-left:auto; margin-top:.8rem; font-size:.9rem;">DJIBOUTI, le
                    {{ $time }}</span>

                <span style="margin-top:.8rem; font-size:.9rem; width:100%; display:block">AVIS D'ARRET DE
                    TRAVAIL</span>
                <span style="margin-top:.8rem; font-size:.9rem; width:100%; display:block">Initial</span>
                <span class="label_arret">Arret de travail</span>

                <div class="arret_message">
                    <p>Je, soussigné(e), Docteur <strong>{{ $doctor->user->fullname }}</strong> Docteur en
                        médecine certifie avoir examiné ce jour <strong>
                            @if ($patient->gender == 1)
                                Mme.
                            @else
                                M.
                            @endif {{ $patient->name }}
                        </strong> et prescrit un arrêt de travail de <strong>{{ $days_formated }}
                            jour{{ $days_formated == 01 ? '' : 's' }}</strong> à compter du
                        <strong>{{ $arret_from }}</strong> jusqu'au
                        <strong>{{ $arret_to }}</strong> inclus.
                    </p>

                    <p>Cet arrêt de travail est délivré à l'interessée pour servir et faire valoir ce que de droit.
                    </p>

                </div>

                <div class="signature">
                    <div class="sign_patient">
                        <span>Signature du patient</span>
                    </div>
                    <div class="sign_doctor">
                        <p>Signature et cachet du médecin</p>
                        <p style="margin-top:1rem; font-weight:bold;">Dr.{{ $doctor->user->fullname }}</p>
                    </div>
                </div>
            </main>
            <strong style="margin-top: 1.5rem;font-size: .8rem;text-decoration: underline;">Ce document est certifié et délivré par l’un des médecins affiliés à l’hôpital de la CNSS</strong>
            <footer class="footer">
                <span class="paper_copy">Copie : EMPLOYEUR</span>
                <div class="br_code" style="text-align: center;">
                    {{-- Replace barcode with QR code --}}
                    {!! QrCode::size(60)->generate(route('arretCheck', $encryptedDiagnoseId)) !!}
                    {{-- <div id="barcodeTarget2" class="bcTarget"></div> --}}
                </div>
                <div class="qr_code">
                    <span style="margin-bottom:.5rem;">Date d'impression: {{ $printed_time }}</span>
                    <span>Dr.{{ $doctor->user->fullname }}</span>
                </div>
            </footer>
        </div>
    </div>



    {{-- --------------------------------- --}}

    {{-- Remove the old barcode generation script --}}
    {{-- <script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/barcode/jquery-barcode.min.js') }}"></script>
    <script>
        // ... old barcode script ...
    </script> --}}

    {{-- Keep printDiv script if needed for browser printing --}}
    <script type='text/javascript'>
        function printDiv() {
            // ... (print function if needed) ...
             window.print();
        }
    </script>
</body>

</html>
