<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipeprojetController extends Controller
{
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $u = Auth::user();
        //     if ($u->user_role != 'admin') {
        //         abort(401);
        //     }
        //     return $next($request);
        // });
    }

    public function accueil()
    {
        return view('equipe-projet.accueil');
    }

    public function projet()
    {
        return view('equipe-projet.projet');
    }

    public function equipe()
    {
        return view('equipe-projet.equipe');
    }
}
