<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\entryOffice;
use Illuminate\Http\Request;

class EntryOfficeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $today_formatted = $today->format('d/m/Y');

        // Récupération de l'utilisateur connecté
        $user = auth()->user();

        // Vérifier le rôle de l'utilisateur
        if (in_array($user->type, ['super_admin', 'admin'])) {
            // Si l'utilisateur est super_admin ou admin, afficher toutes les entrées
            $list = entryOffice::whereDate('created_at', $today)
                ->latest()
                ->paginate(30);
        } else {
            // Sinon, afficher uniquement les entrées créées par l'utilisateur connecté
            $list = entryOffice::where('taken_by', $user->id)
                ->whereDate('created_at', $today)
                ->latest()
                ->paginate(30);
        }

        return view('entryoffice.index', [
            'list' => $list,
            'today' => $today_formatted
        ]);
    }


    public function create()
    {
        return view('entryoffice.create');
    }

    public function search()
    {
        return view('entryoffice.search');
    }
}
