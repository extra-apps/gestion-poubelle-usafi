<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function connexion()
    {
        if (!User::where('user_role', 'admin')->first()) {
            User::create(['name' => 'Admin', 'password' => Hash::make('admin'), 'email' => 'admin@admin.admin', 'user_role' => 'admin']);
        }

        $validator = Validator::make(request()->all(), [
            'login' => 'required', 'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => implode(",", $validator->errors()->all())
            ]);
        }
        $data = $validator->validated();
        $_d['password'] = $data['password'];
        $_d['email'] = $data['login'];

        $return = request()->r;
        if (Auth::attempt($_d)) {
            $user = Auth::user();
            $role = strtolower($user->user_role);
            $route = '';
            if ($role == 'admin') {
                $route = route('admin.accueil');
            }
            if ($role == 'chauffeur') {
                $route = route('chauffeur.accueil');
            }
            if ($role == 'client') {
                $route = route('client.accueil');
            }

            return response()->json([
                'success' => true,
                'url' => $return ?? $route
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Echec de connexion, veuillez vérifier vos informations"
            ]);
        }
    }

    public function deconnexion()
    {
        auth('web')->logout();
        return redirect('/');
    }
}
