<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        if (Auth::user()->temp_password == 0) {
            return redirect()->route('dashboard');
        }
        return view('auth.login_change');
    }
    public function change(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'actual_pass' => 'required',
            'password' => [
                'required',
                'different:actual_pass',
                'confirmed',
                'min:12', // Ensures password has at least 12 characters
                'regex:/[0-9]/', // Ensures password contains at least one number
                'regex:/[@$!%*#?&]/', // Ensures password contains at least one special character
            ],
        ], [
            'password.required' => 'Vous devez saisir le nouveau mot de passe.',
            'password.min' => 'Le nouveau mot de passe doit contenir au moins 12 caractères.',
            'password.regex' => 'Le nouveau mot de passe doit contenir des chiffres et des caractères spéciaux.',
            'actual_pass.required' => 'Le champ du mot de passe actuel est obligatoire.',
            'password.different' => 'Le nouveau mot de passe doit être différent de l\'ancien mot de passe.',
            'password.confirmed' => 'Le mot de passe de confirmation ne correspond pas.',
        ]);
        $user = User::where('id', '=', auth()->user()->id)->first();
        if (Hash::check($request->actual_pass, $user->password)) {
            $user->update([
                'temp_password' => 0,
                'password' => $request->password
            ]);
            return redirect('/')->with('add', 'You have changed your password successfully');
        } else {
            return back()->with('error', 'Your old password field is incorrect');
        }

        dd('ok');
    }
}
