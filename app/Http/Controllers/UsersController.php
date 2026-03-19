<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Place;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $places = Place::all();
        
        $users = User::with('place')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('place', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhereHas('place', function ($placeQuery) use ($search) {
                        $placeQuery->where('name', 'like', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate(20);

        if (!empty($users)) {
            $users->appends($request->all());
        } else {
            return redirect()->route('users.index');
        }

        return view('users.index', [
            'users' => $users,
            'places' => $places
        ]);
    }

    public function create()
    {
        $places = Place::all();
        return view('users.create', compact('places'));
    }

    public function createStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'password' => 'required',
            'email' => 'required|email|unique:users,email',
            'type' => 'required',
            'place_id' => 'required|exists:places,id',
            'gender' => 'required',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'temp_password' => 1,
            'place_id' => $request->place_id,
            'type' => $request->type,
            'taken_by' => Auth::user()->name,
            'gender' => $request->gender,
            'remember_token' => Str::random(10),
            'canprint' => $request->boolean('canprint'),
            'canexcept' => $request->boolean('canexcept'),
            'canprintfamily' => $request->boolean('canprintfamily'),
            'canbiometrie' => $request->boolean('canbiometrie'),
        ]);
        return redirect()->route('users.index')->with('add', 'New user added to the system');
    }
}