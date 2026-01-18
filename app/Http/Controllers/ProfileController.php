<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Place;
use Illuminate\View\View;
use App\Models\entryOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request, User $user): View
    {
        $today = Carbon::today();
        $fiche = entryOffice::query();
        $fiche_user_today = $fiche->whereDate('created_at', $today)->where('taken_by', $user->id)->get()->count();
        $places = Place::all();
        
        // Load the place relationship
        $user->load('place');
        
        return view('profile.edit', [
            'user' => $user,
            'fiche_user_today' => $fiche_user_today,
            'places' => $places
        ]);
    }

    public function resetPassword(Request $request, User $user)
    {
        if (!$user) {
            return back()->withErrors("L'utilisateur n'existe pas");
        }
        $user->update([
            'password' => $request->password,
            'temp_password' => 1
        ]);
        return back()->with('add', "Le mot de passe a été mis à jour pour l'utilisateur sélectionné");
    }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    // /**
    //  * Delete the user's account.
    //  */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }

    public function togglePrint(User $user, Request $request)
    {
        // Valider la requête
        $request->validate([
            'canprint' => 'required|boolean',
        ]);

        // Mettre à jour le champ canprint
        $user->canprint = $request->input('canprint');
        $user->save();

        // Retourner une réponse JSON
        return response()->json([
            'success' => true,
            'canprint' => $user->canprint,
            'message' => 'Print option updated successfully.',
        ]);
    }
    public function toggleExcept(User $user, Request $request)
    {
        // Valider la requête
        $request->validate([
            'canexcept' => 'required|boolean',
        ]);

        // Mettre à jour le champ canexcept
        $user->canexcept = $request->input('canexcept');
        $user->save();

        // Retourner une réponse JSON
        return response()->json([
            'success' => true,
            'canexcept' => $user->canexcept,
            'message' => 'Exception option updated successfully.',
        ]);
    }

    public function togglePrintFamily(User $user, Request $request)
    {
        // Valider la requête
        $request->validate([
            'canprintfamily' => 'required|boolean',
        ]);

        // Mettre à jour le champ canprintfamily
        $user->canprintfamily = $request->input('canprintfamily');
        $user->save();

        // Retourner une réponse JSON
        return response()->json([
            'success' => true,
            'canprintfamily' => $user->canprintfamily,
            'message' => 'Family print option updated successfully.',
        ]);
    }

    public function updatePlace(User $user, Request $request)
    {
        // Valider la requête
        $request->validate([
            'place_id' => 'nullable|exists:places,id',
        ]);

        // Mettre à jour le champ place_id
        $user->place_id = $request->input('place_id');
        $user->save();

        // Retourner une réponse JSON
        return response()->json([
            'success' => true,
            'place_id' => $user->place_id,
            'place_name' => $user->place ? $user->place->name : null,
            'message' => 'Place updated successfully.',
        ]);
    }
}