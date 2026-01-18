@php
    use Carbon\Carbon;

    $ssn = null;

    $mytime = Carbon::now();
    $printed_time = $mytime->toDateTimeString();

    $patient = $authform->name;
    $ssn = $authform->ssn;

    // $time = Carbon::now()->format('d/m/Y');
    $time = Carbon::parse($authform->created_at)->format('d/m/Y');
    $current_date_time = Carbon::now();

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fiche d'autorisation {{ $authform->name }}</title>
    <link rel="icon" href="{{ URL::asset('assets/images/favicon/myafia_favicon.png') }}" type="image/x-icon" />
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

            .exception_yes {
                font-weight: bold !important;
                /* background: #4caf50 !important; */
                color: #4caf50 !important;
                padding: 0 !important;
                border-radius: 1rem !important;
                font-size: 1.1rem;
            }

            .exception_no {
                font-weight: bold !important;
                background: #E91E63 !important;
                color: #E91E63 !important;
                padding: 0 !important;
                border-radius: 1rem !important;
                font-size: 1.1rem;
            }
        }

        .page {
            width: 21cm;
            min-width: 21cm;
            min-height: 29.7cm;
            height: 29.7cm;
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
            size: portrait;
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
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* border-right: .5px dashed #000; */
            padding: .5rem;
            /* padding-right:.3rem; */
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
            margin-top: 2.5rem;
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


        /* Custom styles */
        .patient_information {
            margin-top: 3rem;
            display: flex;
            gap: 1rem;
            width: 100%;
        }

        .left_section {}

        .left_section img {
            width: 150px;
            border-radius: .5rem;
            object-fit: cover;
            aspect-ratio: 1;
        }

        .right_section {
            display: flex;
            flex-direction: column;
            gap: .3rem;
            width: 100%;
        }

        .right_section>p {
            display: flex;
            justify-content: space-between;
            padding-bottom: .3rem;
            border-bottom: 1px dotted #ddd;
        }

        .right_section>p span {
            font-size: .75rem;
        }

        .extra_information {
            margin-top: 2rem;

        }

        .extra_information h3 {
            font-size: .9rem;
        }

        .extra_information_div {
            display: flex;
            flex-direction: column;
            gap: .5rem;
            width: 50%;
        }

        .extra_information_div>p {
            display: flex;
            justify-content: space-between;
            font-size: .9rem;
            padding-bottom: .3rem;
            border-bottom: 1px dotted #ddd;
        }

        .exception_yes {
            font-weight: bold;
            background: #4caf50;
            color: #fff;
            padding: .2rem 2rem;
            border-radius: 1rem;
        }

        .exception_no {
            font-weight: bold;
            background: #E91E63;
            color: #fff;
            padding: .2rem 2rem;
            border-radius: 1rem;
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

    <style>
        .showing_history_p {
            width: 49%;
            font-size: .7rem;
        }

        .showing_history_p:nth-child(odd) {
            border-right: 1px dotted #ccc;
            padding-right: .5rem;
        }

        .showing_history_p:nth-child(even) {
            border-left: 1px dotted #ccc;
            padding-left: .7rem;
        }
    </style>

</head>

<body>

    <div class="full_page" id="print_wrapper">
        <div class="left">
            <header class="header">
                <img class="logo" src="{{ asset('assets/images/myafia_only_logo.png') }}" alt="II"
                    style="width: 100px; height:120px; object-fit:contain;">
                <div style="text-align:center;">
                    {{-- <h4 style="margin:0;">Centre de Soins</h4> --}}
                    <img class="logo" src="{{ asset('assets/images/cnss_logo.png') }}" alt="II"
                        style="width: 100px;">
                </div>
            </header>

            <main class="main">
                <div
                    style="display: flex; justify-content:space-between; align-items:center; margin-top:.8rem; border-top:1px solid #888; border-bottom:1px solid #888; padding:.5rem 0;">
                    <span class="label_arret" style="margin:0;">Fiche d'autorisation</span>
                    <span style="margin-left:auto; font-size:.9rem;">DJIBOUTI, le
                        {{ $time }}</span>
                </div>


                <div class="patient_information">
                    <div class="left_section">
                        <img alt="image du patient" src="{{ $authform->photo }}" />
                    </div>
                    <div class="right_section">
                        <p>
                            <span>Référence</span>
                            <span>{{ $authform->ref }}</span>
                        </p>
                        <p>
                            <span>Nom du patient</span>
                            <span>{{ $authform->name }}</span>
                        </p>
                        <p>
                            <span>Type d'utilisateur</span>
                            <span>{{ ucfirst($authform->createdBy->type) }}</span>
                        </p>
                        <p>
                            <span>Numéro de sécurité sociale (SSN)</span>
                            <span>{{ $authform->ssn }}</span>
                        </p>
                        <p>
                            <span>Date de naissance</span>
                            <span>{{ Carbon::parse($authform->birth)->format('d/m/Y') }}</span>
                        </p>
                        <p>
                            <span>Âge</span>
                            <span>{{ Carbon::parse($authform->birth)->age }} Ans</span>
                        </p>
                        <p>
                            <span>Régime</span>
                            <span>{{ $authform->regime }}</span>
                        </p>
                        <p>
                            <span>Lieu</span>
                            <span>{{ $authform->createdBy->place }}</span>
                        </p>
                        <p>
                            <span>Accès aux soins :</span>
                            <span style="font-weight: bold;">{{ $authform->access_soin }}</span>
                        </p>
                        <p>
                            <span>Créé le</span>
                            <span>{{ $authform->created_at }}</span>
                        </p>
                        <p>
                            <span>Créé par</span>
                            <span>{{ $authform->createdBy->name }}</span>
                        </p>
                        <p>
                            <span>Imprimé par</span>
                            <span>{{ auth()->user()->name }}</span>
                        </p>
                        <p>
                            <span>Site Agent</span>
                            <span>{{ auth()->user()->place }}</span>
                        </p>
                        @if ($authform->exception_status)
                            <p>
                                <span>Statut d'exception</span>
                                <span>Oui</span>
                            </p>
                            <p>
                                <span>Motif de l'exception</span>
                                <span>{{ $authform->exception_reason }}</span>
                            </p>
                        @endif
                    </div>
                </div>

                <div class="extra_information">
                    <h3>Historique</h3>
                    <div class="extra_information_div"
                        style="width:100%; display:flex; justify-content:space-between; gap:.3rem; flex-wrap:wrap; flex-direction: row;">
                        @foreach ($authform->history as $history)
                            <p class="showing_history_p">
                                <span>{{ $history['place'] }}</span>
                                <span>{{ $history['user'] }}</span>
                                <span>{{ Carbon::parse($history['date'])->format('d/m/Y H:i:s') }}</span>
                            </p>
                        @endforeach
                    </div>
                </div>



                <div class="signature">
                    <div class="sign_patient">
                        <span style="font-weight: bold;">Quiconque se rend coupable de fausse déclaration est passible
                            de poursuites penales.</span>
                    </div>
                    <div class="sign_doctor">
                        <p>Cachet bureau d'entrée</p>
                    </div>
                </div>
            </main>
            <footer class="footer">
                <span class="paper_copy"></span>
                <div class="br_code">
                    <div id="qrcodeTarget" class="bcTarget">
                    </div>
                </div>
                <div class="qr_code">
                    <span style="margin-bottom:.5rem; font-size:.65rem;">Date d'impression: {{ $printed_time }}</span>
                    <span style="font-size:.65rem;">{{ auth()->user()->name }}</span>
                </div>
            </footer>

        </div>
    </div>



    {{-- --------------------------------- --}}

    <script src="{{ URL::asset('assets/libs/jquery/jquery-3.6.1.min.js') }}"></script>
    {{-- <script src="{{ URL::asset('assets/libs/barcode/jquery-barcode.min.js') }}"></script> --}}
    <script src="{{ URL::asset('assets/libs/barcode/qrcode.min.js') }}"></script>

    <script>
        var qrcode = new QRCode(document.getElementById("qrcodeTarget"), {
            text: "https://www.example.com", // Text or URL to encode
            width: 90, // Width of the QR code
            height: 90, // Height of the QR code
            colorDark: "#000000", // Dark color of the QR code
            colorLight: "#ffffff", // Light background color
            correctLevel: QRCode.CorrectLevel.H // Error correction level (L, M, Q, H)
        });
        qrcode.makeCode("{{ $authform->ref }}");
    </script>

</body>

</html>
