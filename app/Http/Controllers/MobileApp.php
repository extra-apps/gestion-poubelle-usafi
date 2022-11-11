<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class MobileApp extends Controller
{

    public  function login(Request $request)
    {
        $attr = $request->all();
        $validator = Validator::make($attr, [
            'login' => 'required|string|',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            $m = implode(', ', $validator->errors()->all());
            $m = str_replace('.', '', $m);
            return response()->json(['success' => false, 'message' => $m]);
        }

        $success = false;
        $data = $validator->validated();
        $login = $data['login'];
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $_ = ['password' => $data['password'], 'email' => $login];
            if (Auth::attempt($_)) {
                $success = true;
            }
        } else if (is_numeric($login)) {
            $login = "+" . (float) $login;
            $_ = ['password' => $data['password'], 'telephone' => $login];
            if (Auth::attempt($_)) {
                $success = true;
            }
        } else {
            $m = "You must provide your email or phone number to login";
            return response()->json(['success' => false, 'message' => $m]);
        }

        if (!$success) {
            $m = "Echec de connexion";
            return response()->json(['success' => false, 'message' => $m]);
        }

        /** @var \App\Models\User $user **/
        $user = auth()->user();
        $role = $user->user_role;
        if (!in_array($role, ['chaffeur', 'client'])) {
            $m = "Veuiller utiliser l'interface web pour l'admin.";
            return response()->json(['success' => false, 'message' => $m]);
        }
        $u = (object) ['nom' => $user->name, 'email' => $user->email, 'telephone' => $user->telephone];


        return response()->json([
            'token' => $user->createToken('token_' . time())->accessToken,
            'user' => $u,
            'role' => $role,
            'success' => true,
            'message' => "Bienvenu $user->name"
        ]);
    }



    public function logout()
    {
        /** @var \App\Models\User $user **/
        $user = auth('api')->user();
        $user->tokens()->delete();
        return response()->json([]);
    }
}
