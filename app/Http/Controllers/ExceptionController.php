<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExceptionController extends Controller
{
    public function create()
    {
        return view('exception.create');
    }

    public function updateException(Request $request)
    {
        try {
            $validated = $request->validate([
                'ssn' => 'required',
                'name' => 'required',
                'date_fin_exception' => 'required|date',
                'reason' => 'required|string'
            ]);
    
            // Mise à jour de la table MEMBRE_FAMILLE_AMU
            // Votre logique de mise à jour ici
    
            return response()->json([
                'status' => true,
                'message' => 'Mise à jour effectuée avec succès'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()
            ], 500);
        }
    }

    public function createEmployer()
    {
        return view('exception.employer.create');
    }
}
