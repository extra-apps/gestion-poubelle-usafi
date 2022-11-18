<?php

namespace App\Http\Controllers;

use App\Models\Evacuateur;
use App\Models\Poubelle;
use App\Models\User;
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
        $map = [];
        $u = User::where('user_role', 'client')->get();

        foreach ($u as $e) {
            $d = (object) [];
            $d->user = $e->name;
            $d->map = $e->map;
            $l = '<p class="p-0 m-0"><i class="fa fa-trash text-success"></i> Poubelles :</p><ul>';
            foreach ($e->poubelles()->get() as $p) {
                $l .= "<li>" . num($p->id) . "</li></ul>";
            }
            $d->poubelle = $l;
            if ($e->map) {
                array_push($map, $d);
            }
        }
        return view('chauffeur.accueil', compact('map'));
    }
}
