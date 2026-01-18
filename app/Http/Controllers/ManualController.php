<?php

namespace App\Http\Controllers;

use App\Models\entryOffice;
use Illuminate\Http\Request;
use App\Models\MemberFamilyAmu;
use Illuminate\Support\Facades\Artisan;

class ManualController extends Controller
{
    public function clear()
    {
        $url = url('/');

        // Clear Application Cache
        Artisan::call('cache:clear');

        // Clear Configuration Cache
        Artisan::call('config:clear');

        // Clear Route Cache
        Artisan::call('route:clear');

        // Clear View Cache
        Artisan::call('view:clear');

        // Clear Compiled Classes and Services Cache
        Artisan::call('clear-compiled');

        // Clear All Caches
        Artisan::call('optimize:clear');

        system('composer dump-autoload');


        return redirect($url);
        // return 'Caches cleared successfully.';
    }

    public function getAMU($ssn)
    {
        $results = MemberFamilyAmu::where('SSN', '=', $ssn)->orderBy('RelationCode', 'asc')->get()->unique('Nom');

        $ssn = $ssn;

        // Start adding the patient
        $results = MemberFamilyAmu::where('SSN', '=', $ssn)->orderBy('RelationCode', 'asc')->get()->unique('Nom');
        if ($results->count() != 0) {
            foreach ($results as $oneAMU) {
                $oneAMU->Photo = 'data:image/jpeg;base64,' . base64_encode($oneAMU->Photo);
                // Check if the patient is desactivated
                if (strtolower($oneAMU->{'Regime Travailleur'}) == 'desactiver') {
                    $activate_status = 'desactiver';
                }

                // $principal_gender = '';
                // $principal_husband_details = null;
                // $principal_wife_details = null;

                // $patient_name  = null;
                // $patient_birth = null;
                // $patient_gender = null;
                // $patient_mother = null;
                // $patient_address = null;
                // $access_soin = null;

                // $patient_name  = ucwords(strtolower($oneAMU->Nom));
                // $patient_birth = $oneAMU->{'Date de naissance'};
                // $patient_gender = $oneAMU->Sexe;
                // $patient_mother = $oneAMU->{"Nom de la mere de l'assure"};
                // $patient_address = $oneAMU->{"Ville/Region"} . ' ' . $oneAMU->{'Localité'};
                // $final_image_name = 'data:image/jpeg;base64,' . base64_encode($oneAMU->Photo);


                // if ($activate_status == 'desactiver') {
                //     $access_soin = 0;
                // } else {
                //     $access_soin = ($oneAMU->{'Acces_soin'} == 'OUI') ? 1 : 0;
                // }

                // // Detect the relation name
                // $relation_name = '';
                // $marital_status = 'single';
                // if ($oneAMU->RelationCode == 1) {
                //     $relation_name = 'principal';
                //     $principal_gender = $oneAMU->Sexe;
                // } else if ($oneAMU->RelationCode > 1 && $oneAMU->RelationCode < 11) {
                //     $marital_status = 'married';
                //     if (strtolower($patient_gender) == 'm') {
                //         $relation_name = 'husband';
                //     } else {
                //         $relation_name = 'wife';
                //     }
                // } else if (($oneAMU->RelationCode > 10 && $oneAMU->RelationCode < 92) || ($oneAMU->RelationCode > 93 && $oneAMU->RelationCode < 98)) {
                //     $relation_name = 'child';
                // }

                // // Create the patient
                // $patientGlobal = PatientGlobal::create([
                //     'name' => $patient_name,
                //     'ax_matricule' => $ax_matricule,
                //     'birth' => $patient_birth,
                //     'gender' => (strtolower($patient_gender) == 'm') ? 0 : 1,
                //     'gender_letter' => strtolower($patient_gender),
                //     'ssn' => $ssn,
                //     'mother_name' => $patient_mother,
                //     'address' => $patient_address,
                //     'patient_number' => $patient_number,
                //     'last_visit' => null,
                //     'family_number' => $family_number,
                //     'picture' => $final_image_name,
                //     'access_soin' => $access_soin,
                //     'regime' => $oneAMU->Regime,
                //     'regime_worker' => $oneAMU->{"Regime Travailleur"},
                //     'active_status' => $activate_status,
                //     'is_dead' => $oneAMU->{'Décés'},

                //     // MemberID and relation code
                //     'member_id' => $oneAMU->{'MemberID'},
                //     'relationship' => $oneAMU->{'Lien parenté'},
                //     'relation_code' => $oneAMU->RelationCode,
                //     'relation_name' => $relation_name
                // ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'No patient found with this SSN'
            ], 500);
        }

        return $results;


        // ---------------------------
    }
}
