<?php

namespace App\Http\Controllers\Biometrics;

use App\Http\Controllers\Controller;
use App\Models\MemberFamilyAmu;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BiometricsController extends Controller
{
    public function index()
    {
        return view('biometrics.index');
    }

    public function showFaceCapture()
    {
        return view('biometrics.face-capture');
    }

    public function empreinte()
    {
        return view('biometrics.empreinte');
    }

    // public function storeFaceCapture(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|string',
    //     ]);

    //     // Décoder l'image base64
    //     $imageData = $request->input('image');
    //     $imageData = str_replace('data:image/png;base64,', '', $imageData);
    //     $imageData = str_replace(' ', '+', $imageData);
    //     $decodedImage = base64_decode($imageData);

    //     // Créer un nom de fichier unique
    //     $fileName = 'face_' . time() . '.png';
    //     $path = public_path('uploads/biometrics/faces/' . $fileName);

    //     // Créer le dossier s'il n'existe pas
    //     if (!file_exists(public_path('uploads/biometrics/faces'))) {
    //         mkdir(public_path('uploads/biometrics/faces'), 0755, true);
    //     }

    //     // Sauvegarder l'image
    //     file_put_contents($path, $decodedImage);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Photo capturée avec succès',
    //         'path' => 'uploads/biometrics/faces/' . $fileName
    //     ]);
    // }

    public function getPatient(Request $request)
    {
        $ssn = 170333080;
        // Start adding the patient
        $results = MemberFamilyAmu::where('SSN', '=', $ssn)->orderBy('RelationCode', 'asc')->get()->unique('Nom');

        if ($results->count() != 0) {
            $dataReturned = [];
            foreach ($results as $oneAMU) {
                // $rand = rand(0, 1);
                $rand = 0;
                $oneAMU->Photo = 'data:image/jpeg;base64,' . base64_encode($oneAMU->Photo);
                if ($rand == 1) {
                    $oneAMU->disactivated = true;
                } else {
                    $oneAMU->disactivated = false;
                }
                // Check if the patient is desactivated
                if (strtolower($oneAMU->{'Regime Travailleur'}) == 'desactiver') {
                    $activate_status = 'desactiver';
                    $oneAMU->disactivated = true;
                }
                $oneAMU->{'Date de naissance'} = Carbon::parse($oneAMU->{'Date de naissance'})->format('d/m/Y');
                $dataReturned[] = $oneAMU;
            }


            return view('biometrics.getPatient', [
                'data' => $dataReturned,
                'canprint' => auth()->user()->canprint,
                'canprintfamily' => auth()->user()->canprintfamily
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Aucun patient n'a été trouvé avec ce SSN"
            ], 500);
        }
    }
}
