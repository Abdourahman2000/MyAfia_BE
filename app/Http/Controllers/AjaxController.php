<?php

namespace App\Http\Controllers;



use App\Models\entryOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\MemberFamilyAmu;
use App\Models\ExceptionHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function getPatients(Request $request)
    {
        $ssn = $request->ssn;
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


            return response()->json([
                'status' => true,
                'data' => $dataReturned,
                'canprint' => auth()->user()->canprint,
                'canprintfamily' => auth()->user()->canprintfamily
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Aucun patient n'a été trouvé avec ce SSN"
            ], 500);
        }
    }

    public function storeFiche(Request $request)
    {
        $validated = $request->validate([
            'ssn' => 'required',
            'member_id' => 'required',
            'relation_code' => 'required',
            'name' => 'required',
            // 'is_exception' => 'boolean', // New validation rule
            'exception_reason' => 'required_if:is_exception,true' // Required only if is_exception is true
        ]);

        $ssn = $request->ssn;
        $memberId = $request->member_id;
        $relationCode = $request->relation_code;
        $name = $request->name;

        $existingFiche = entryOffice::where('ssn', $ssn)
            ->where('member_id', $memberId)
            ->where('relation_code', $relationCode)
            ->where('ssn', $ssn)
            ->whereDate('created_at', Carbon::today()) // Check if a record exists for today
            ->first();
        // If a record exists for the same day
        if ($existingFiche) {
            $historyArray = [
                'place' => Auth::user()->place,
                'date' => Carbon::now()->toDateTimeString(),
                'user' => Auth::user()->name,
            ];
            $existingFiche->update([
                'history' => $historyArray
            ]);
            return response()->json([
                'message' => 'Record already exists for today',
                'status' => true,
                'id' => $existingFiche->id
            ], 200);
        }


        // If no record exists, create a new one
        $ref = 0;
        $latest = entryOffice::latest()->first();
        if ($latest) {
            $ref = $latest->ref + 1;
        } else {
            $ref = 1;
        }
        $memberAmu = MemberFamilyAmu::where('SSN', $ssn)
            ->where('Nom', $name)
            ->where('MemberID', $memberId)
            ->where('RelationCode', $relationCode)
            ->first();

        $amuPhoto = 'data:image/jpeg;base64,' . base64_encode($memberAmu->Photo);

        $historyArray = [
            'place' => Auth::user()->place,
            'date' => Carbon::now()->toDateTimeString(),
            'user' => Auth::user()->name,
        ];
        $newFiche = entryOffice::create([
            'ref' => $ref,
            'name' => $memberAmu->Nom,
            'member_id' => $memberAmu->MemberID,
            'relation_code' => $memberAmu->RelationCode,
            'ssn' => $memberAmu->SSN,
            'birth' => $memberAmu->{'Date de naissance'},
            'gender' => $memberAmu->{'Sexe'},
            'regime' => $memberAmu->{'Regime'},
            'age' => $memberAmu->{'Age'},
            'access_soin' => $memberAmu->Acces_soin,
            'taken_by_name' => Auth::user()->name,
            'taken_place' => Auth::user()->place,
            'mother_name' => $memberAmu->{"Nom de la mere de l'assure"},
            'photo' => $amuPhoto,
            'exception_status' => null,
            'exception_reason' => null,
            'taken_by' => Auth::user()->id,
            'history' => $historyArray,
            'exception_status' => ($request->is_exception ? $request->is_exception : null),
            'exception_reason' => ($request->is_exception ? $request->exception_reason : null),
        ]);
        return response()->json([
            'message' => 'Data Inserted Successfully',
            'status' => true,
            'id' => $newFiche->id
        ], 200);
    }

    // public function searchPatient(Request $request)
    // {

    //     $ssn = $request->ssn;
    //     $name = $request->name;
    //     $mother_name = $request->mother_name;
    //     $searchBoolean = false;
    //     if (empty($ssn) && empty($name) && empty($mother_name)) {
    //         return response()->json([
    //             'status' => false,
    //             'data' => [],  // Ensure that an empty array is returned
    //             'message' => 'Vous devez saisir au moins une valeur'
    //         ], 500);
    //     }

    //     $results = MemberFamilyAmu::where(function ($query) use ($ssn, $name, $mother_name) {
    //         if (!empty($ssn) && strlen($ssn) >= 5) {
    //             $query->where('SSN', 'LIKE', "%$ssn%");
    //             $searchBoolean = true;
    //         }

    //         if (!empty($name) && strlen($name) >= 5) {
    //             $query->orWhere('Nom', 'LIKE', "%$name%");
    //             $searchBoolean = true;
    //         }

    //         if (!empty($mother_name) && strlen($mother_name) >= 5) {
    //             $query->orWhere('Nom de la mere de l\'assure', 'LIKE', "%$mother_name%");
    //             $searchBoolean = true;
    //         }
    //     })
    //         ->where('RelationCode', '1')->limit(200)
    //         ->get()->unique('Nom');
    //     $dataReturned = [];
    //     if ($results->count() != 0) {
    //         foreach ($results as $oneAMU) {
    //             // $rand = rand(0, 1);
    //             $rand = 0;
    //             $oneAMU->Photo = 'data:image/jpeg;base64,' . base64_encode($oneAMU->Photo);
    //             // Check if the patient is desactivated
    //             if (strtolower($oneAMU->{'Regime Travailleur'}) == 'desactiver') {
    //                 $activate_status = 'desactiver';
    //             }
    //             if ($rand == 1) {
    //                 $oneAMU->disactivated = true;
    //             } else {
    //                 $oneAMU->disactivated = false;
    //             }
    //             $dataReturned[] = $oneAMU;
    //         }

    //         return response()->json([
    //             'status' => true,
    //             // 'data' => $results->toArray()
    //             'data' => $dataReturned
    //         ], 200);  // Change to 200 for success
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'data' => [],  // Ensure that an empty array is returned
    //             'message' => "Aucun patient n'a été trouvé avec les informations données"
    //         ], 500);
    //     }
    // }

    public function searchPatient(Request $request)
    {
        $ssn = $request->ssn;
        $name = $request->name;
        $mother_name = $request->mother_name;
        $searchBoolean = false;

        if (empty($ssn) && empty($name) && empty($mother_name)) {
            return response()->json([
                'status' => false,
                'data' => [],  // Ensure that an empty array is returned
                'message' => 'Vous devez saisir au moins une valeur'
            ], 500);
        }

        // Build the query, but execute only if searchBoolean is true
        $query = MemberFamilyAmu::query();

        if (!empty($ssn) && strlen($ssn) >= 5) {
            $query->where('SSN', 'LIKE', "%$ssn%");
            $searchBoolean = true;
        }

        if (!empty($name) && strlen($name) >= 3) {
            $query->orWhere('Nom', 'LIKE', "%$name%");
            $searchBoolean = true;
        }

        if (!empty($mother_name) && strlen($mother_name) >= 4) {
            $query->orWhere('Nom de la mere de l\'assure', 'LIKE', "%$mother_name%");
            $searchBoolean = true;
        }

        // Only run this query if $searchBoolean is true
        if ($searchBoolean) {
            $results = $query->where('RelationCode', '1')
                ->limit(500)
                ->get()
                ->unique('Nom');

            $dataReturned = [];
            if ($results->count() != 0) {
                foreach ($results as $oneAMU) {
                    $rand = 0;
                    $oneAMU->Photo = 'data:image/jpeg;base64,' . base64_encode($oneAMU->Photo);
                    if (strtolower($oneAMU->{'Regime Travailleur'}) == 'desactiver') {
                        $activate_status = 'desactiver';
                    }
                    $oneAMU->disactivated = $rand == 1 ? true : false;
                    $dataReturned[] = $oneAMU;
                }

                return response()->json([
                    'status' => true,
                    'data' => $dataReturned
                ], 200);  // Success response
            } else {
                return response()->json([
                    'status' => false,
                    'data' => [],
                    'message' => "Aucun patient n'a été trouvé avec les informations données"
                ], 500);
            }
        } else {
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => "Aucun critère de recherche valide n'a été fourni"
            ], 500);
        }
    }

    public function getPatientForException(Request $request)
    {
        try {
            $ssn = $request->ssn;

            // Récupérer uniquement l'assuré principal (MemberID = 1) avec Acces_soin = 'NON'
            $assurePrincipal = MemberFamilyAmu::where('SSN', '=', $ssn)
                ->where('RelationCode', '=', 1)
                ->where('Acces_soin', '=', 'NON')
                ->first();

            if (!$assurePrincipal) {
                return response()->json([
                    'status' => false,
                    'message' => "Aucun assuré principal trouvé avec ce SSN ou l'accès aux soins est déjà activé"
                ], 404);
            }

            // Convertir la photo en base64
            $assurePrincipal->Photo = 'data:image/jpeg;base64,' . base64_encode($assurePrincipal->Photo);

            // Vérifier le statut du régime
            if (strtolower($assurePrincipal->{'Regime Travailleur'}) == 'desactiver') {
                return response()->json([
                    'status' => false,
                    'message' => "L'assuré principal est désactivé"
                ], 400);
            }

            return response()->json([
                'status' => true,
                'data' => [$assurePrincipal] // Retourné dans un tableau pour maintenir la compatibilité avec le front
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Une erreur est survenue lors de la récupération des données"
            ], 500);
        }
    }

    public function updateFamilyAccess(Request $request)
    {
        try {
            $validated = $request->validate([
                'ssn' => 'required',
                'name' => 'required',
                'date_fin_exception' => 'required|date',
                'reason' => 'required|string'
            ]);

            DB::beginTransaction();

            // Mise à jour sans timestamps
            DB::table('MEMBRE_FAMILLE_AMU')
                ->where('SSN', $validated['ssn'])
                ->update([
                    'Acces_soin' => 'OUI',
                    'date_fin_exception' => $validated['date_fin_exception']
                ]);

            // Enregistrement dans l'historique
            // ExceptionHistory::create([
            //     'user_id' => auth()->id(),
            //     'ssn' => $validated['ssn'],
            //     'nom' => $validated['name'],
            //     'date_fin_exception' => $validated['date_fin_exception'],
            //     'reason' => $validated['reason']
            // ]);

            ExceptionHistory::create([
                'user_id' => auth()->id(),
                'ssn' => $validated['ssn'],
                'nom' => $validated['name'],
                'date_fin_exception' => $validated['date_fin_exception'],
                'reason' => $validated['reason'],
                'type_exception' => ExceptionHistory::TYPE_PATIENT
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Mise à jour effectuée avec succès'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()
            ], 500);
        }
    }




    // cotisant 


    public function getEmployerForException(Request $request)
    {
        try {
            $compteCotisant = $request->compte_cotisant;

            // Récupérer UN SEUL employeur avec DISTINCT où Acces_soin = 'NON'
            $employeur = DB::table('MEMBRE_FAMILLE_AMU')
                ->select(
                    'Compte Cotisant',
                    'Nom de l\'employeur'
                )
                ->where('Compte Cotisant', $compteCotisant)
                ->where('Acces_soin', '=', 'NON')
                ->where('Regime Travailleur', '!=', 'DESACTIVER')
                ->groupBy('Compte Cotisant', 'Nom de l\'employeur')
                ->first();

            if (!$employeur) {
                return response()->json([
                    'status' => false,
                    'message' => "Aucun employeur trouvé avec ce compte cotisant ou l'accès aux soins est déjà activé"
                ], 404);
            }

            $employeurData = [
                'compte_cotisant' => $employeur->{'Compte Cotisant'},
                'nom_employeur' => $employeur->{'Nom de l\'employeur'}
            ];

            return response()->json([
                'status' => true,
                'data' => $employeurData
            ], 200);
        } catch (\Exception $e) {
            // Log::error('Erreur getEmployerForException: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => "Une erreur est survenue lors de la récupération des données"
            ], 500);
        }
    }

    public function updateEmployerAccess(Request $request)
    {
        try {
            $validated = $request->validate([
                'compte_cotisant' => 'required',
                'nom_employeur' => 'required',
                'date_fin_exception' => 'required|date'
            ]);

            DB::beginTransaction();

            // Compter d'abord les patients à mettre à jour
            $countToUpdate = DB::table('MEMBRE_FAMILLE_AMU')
                ->where('Compte Cotisant', $validated['compte_cotisant'])
                ->where('Regime Travailleur', '!=', 'DESACTIVER')
                ->where('Acces_soin', '=', 'NON')
                ->count();

            if ($countToUpdate === 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Aucun patient trouvé nécessitant une mise à jour'
                ], 404);
            }

            // Faire une seule mise à jour en masse
            DB::table('MEMBRE_FAMILLE_AMU')
                ->where('Compte Cotisant', $validated['compte_cotisant'])
                ->where('Regime Travailleur', '!=', 'DESACTIVER')
                ->where('Acces_soin', '=', 'NON')
                ->update([
                    'Acces_soin' => 'OUI',
                    'date_fin_exception' => $validated['date_fin_exception']
                ]);

            // Créer l'historique
            ExceptionHistory::create([
                'user_id' => auth()->id(),
                'compte_cotisant' => $validated['compte_cotisant'],
                'nom' => $validated['nom_employeur'],
                'date_fin_exception' => $validated['date_fin_exception'],
                'type_exception' => ExceptionHistory::TYPE_EMPLOYER,
                'reason' => 'Protocol d\'accord'
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Mise à jour effectuée avec succès',
                'count' => $countToUpdate,
                'reload' => true
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()
            ], 500);
        }
    }
}
