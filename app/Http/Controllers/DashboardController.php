<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\entryOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $user = Auth::user();
    
        // Nombre total de fiches
        $fiche_total = entryOffice::count();
    
        // Nombre de fiches créées aujourd'hui
        $fiche_today = entryOffice::whereDate('created_at', $today)->count();
    
        // Nombre de fiches créées aujourd'hui par l'utilisateur connecté
        $fiche_user_today = entryOffice::whereDate('created_at', $today)
                                        ->where('taken_by', $user->id)
                                        ->count();
    
        // Nombre total de fiches créées par l'utilisateur connecté
        $fiche_user_total = entryOffice::where('taken_by', $user->id)->count();
    
        // Nombre total d'utilisateurs
        $usersCount = User::count();
    
        return view('dashboard.index', [
            'fiche_total' => $fiche_total,
            'fiche_today' => $fiche_today,
            'fiche_user_today' => $fiche_user_today,
            'fiche_user_total' => $fiche_user_total,
            'usersCount' => $usersCount,
        ]);
    }
    
}
