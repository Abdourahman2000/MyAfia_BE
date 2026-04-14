<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\entryOffice;
use Illuminate\Http\Request;
use App\Models\MemberFamilyAmu;
use App\Models\Diagnose;
use Illuminate\Support\Facades\Auth;

class PrintController extends Controller
{
    public function printAuth($id)
    {
        // dd($id);
        $authform = entryOffice::find($id);
        if (!$authform) {
            return response()->json([
                'status' => false,
                'message' => 'No fiche found with this ID',
            ], 500);
        }
        return view('printing.auth', [
            'authform' => $authform
        ]);
    }

    public function printBiometricsPost(Request $request)
    {
        $ref = time() . rand(10, 99);
        

        // Mock authform object since print_biomi expects an entryOffice model instance
        $authform = (object) [
            'ref' => $ref,
            'name' => $request->name,
            'type' => auth()->user()->type ?? 'agent',
            'place' => auth()->user()->place,
            'numero_assure' => $request->numeroAssure,
            'birthDate' => $request->dateNaiss,
            'regime' => $request->regime,
            'access_soin' => $request->hasRight == "true" || $request->hasRight == "1" || $request->hasRight === true ? 'OUI' : 'NON',
            'created_at' => Carbon::now()->toDateTimeString(),
            'photo' => $request->photo,
            'history' => [
                [
                    'place' => auth()->user()->place,
                    'date' => Carbon::now()->toDateTimeString(),
                    'user' => auth()->user()->name,
                ]
            ],
            'exception_status' => false,
            'exception_reason' => null,
        ];

        return view('printing.print_biomi', [
            'authform' => $authform,
        ]);
    }

    public function printFamily($ssn)
    {
        // Check if user has permission to print family
        if (!auth()->user()->canprintfamily) {
            abort(403, 'Unauthorized action.');
        }

        // Use SSN directly for family printing
        if (!$ssn) {
            return response()->json([
                'status' => false,
                'message' => 'No SSN provided',
            ], 500);
        }

        // Fetch all family members with the given SSN
        $familyMembers = MemberFamilyAmu::where('SSN', $ssn)
            ->orderBy('RelationCode', 'asc')
            ->get();

        if ($familyMembers->count() == 0) {
            return response()->json([
                'status' => false,
                'message' => 'No family members found with this SSN',
            ], 500);
        }

        // Process each family member
        foreach ($familyMembers as $member) {
            // Convert photo to base64
            $member->Photo = 'data:image/jpeg;base64,' . base64_encode($member->Photo);

            // Format birth date
            $member->formatted_birth_date = Carbon::parse($member->{'Date de naissance'})->format('d/m/Y');
        }

        return view('printing.family', [
            'ssn' => $ssn,
            'familyMembers' => $familyMembers
        ]);
    }

    public function arretCheck($diagnose_id)
    {
        $decryptedDiagnoseId = $this->decryptCompact($diagnose_id);
        $encryptedDiagnoseId = $this->encryptCompact($decryptedDiagnoseId);
        $diagnose = Diagnose::find($decryptedDiagnoseId);
        if (!$diagnose) {
            return response()->json([
                'status' => false,
                'message' => "Le fichier que vous essayez d'imprimer n'existe pas."
            ], 500);
        }
        

        return view('printing.arret_travailCHECK', [
            'diagnose' => $diagnose,
            'encryptedDiagnoseId' => $encryptedDiagnoseId
        ]);
    }

    function encryptCompact($value, $key = 'your-custom-key')
    {
        $cipher = 'AES-128-CBC';
        $iv = substr(hash('sha256', $key), 0, 16); // Generate a fixed-length IV
        $encrypted = openssl_encrypt($value, $cipher, $key, 0, $iv);
        return base64_encode($encrypted);
    }

    function decryptCompact($encryptedValue, $key = 'your-custom-key')
    {
        $cipher = 'AES-128-CBC';
        $iv = substr(hash('sha256', $key), 0, 16);
        $decoded = base64_decode($encryptedValue);
        return openssl_decrypt($decoded, $cipher, $key, 0, $iv);
    }
}
