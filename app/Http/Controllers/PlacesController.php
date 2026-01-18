<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlacesController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $places = Place::with('createdBy')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(20);

        if (!empty($places)) {
            $places->appends($request->all());
        } else {
            return redirect()->route('places.index');
        }

        return view('places.index', [
            'places' => $places
        ]);
    }

    public function create()
    {
        // Not needed anymore since we use modals
        return redirect()->route('places.index');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:places,name',
            ], [
                'name.required' => 'Le nom de la place est obligatoire.',
                'name.string' => 'Le nom de la place doit être une chaîne de caractères.',
                'name.max' => 'Le nom de la place ne peut pas dépasser 255 caractères.',
                'name.unique' => 'Une place avec ce nom existe déjà.',
            ]);

            $place = Place::create([
                'name' => trim($request->name),
                'created_by' => Auth::id(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Nouvelle place ajoutée avec succès',
                    'place' => $place
                ]);
            }

            return redirect()->route('places.index')->with('add', 'Nouvelle place ajoutée avec succès');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function edit(Place $place)
    {
        // Not needed anymore since we use modals
        return redirect()->route('places.index');
    }

    public function update(Request $request, Place $place)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:places,name,' . $place->id,
            ], [
                'name.required' => 'Le nom de la place est obligatoire.',
                'name.string' => 'Le nom de la place doit être une chaîne de caractères.',
                'name.max' => 'Le nom de la place ne peut pas dépasser 255 caractères.',
                'name.unique' => 'Une place avec ce nom existe déjà.',
            ]);

            $place->update([
                'name' => trim($request->name),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Place mise à jour avec succès',
                    'place' => $place
                ]);
            }

            return redirect()->route('places.index')->with('edit', 'Place mise à jour avec succès');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Place $place)
    {
        // Check if place is being used by any users
        $userCount = $place->users()->count();
        if ($userCount > 0) {
            $message = "Cannot delete place '{$place->name}' because it is assigned to {$userCount} user(s). Please reassign these users before deleting the place.";
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 422);
            }
            
            return redirect()->route('places.index')->with('error', $message);
        }

        $placeName = $place->name;
        $place->delete();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Place '{$placeName}' deleted successfully"
            ]);
        }
        
        return redirect()->route('places.index')->with('delete', "Place '{$placeName}' deleted successfully");
    }
}