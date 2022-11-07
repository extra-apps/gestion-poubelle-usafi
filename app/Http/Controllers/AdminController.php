<?php

namespace App\Http\Controllers;

use App\Models\Concession;
use App\Models\Evacuation;
use App\Models\Parcelle;
use App\Models\Plainte;
use App\Models\PlanAction;
use App\Models\Poubelle;
use App\Models\Profil;
use App\Models\Projet;
use App\Models\Risque;
use App\Models\User;
use App\Models\UsersHasRisque;
use App\Models\Ville;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = Auth::user();
            if ($u->user_role != 'admin') {
                abort(401);
            }
            return $next($request);
        });
    }

    public function accueil()
    {
        $cl = User::where('user_role', 'client')->count();
        $ch = User::where('user_role', 'chauffeur')->count();
        $pb = Poubelle::count();
        $pbp = Poubelle::count();

        $tabeva = $tabpb = [];
        foreach (range(1, 12) as $m) {
            array_push($tabeva, Evacuation::whereMonth('date', $m)->count() );
            array_push($tabpb,  Poubelle::whereMonth('dateajout', $m)->count());
        }
        return view('admin.accueil', compact('cl', 'ch', 'pb', 'pbp', 'tabeva', 'tabpb'));
    }

    public function client()
    {
        return view('admin.client');
    }

    public function chauffeur()
    {
        return view('admin.chauffeur');
    }

    public function poubelle()
    {
        $clients = User::where('user_role', 'client')->orderBy('id', 'desc')->get();
        return view('admin.poubelle', compact('clients'));
    }
}
