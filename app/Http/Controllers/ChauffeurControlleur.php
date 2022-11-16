<?php

namespace App\Http\Controllers;

use App\Models\Evacuateur;
use App\Models\Poubelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChauffeurControlleur extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = Auth::user();
            if ($u->user_role != 'chauffeur') {
                abort(401);
            }
            return $next($request);
        });
    }

    public function accueil()
    {
        $idp = Evacuateur::where('users_id', auth()->user()->id)->pluck('poubelle_id')->all();
        $poubelles = Poubelle::whereIn('id', $idp)
            ->orderBy('id', 'desc')
            ->get();
        return view('chauffeur.accueil', compact('poubelles'));
    }
}
