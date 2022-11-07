<?php

namespace App\Http\Controllers;

use App\Models\Concession;
use App\Models\Parcelle;
use App\Models\Plainte;
use App\Models\PlanAction;
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
        // $cp = User::where('user_role', 'chefprojet')->count();
        // $ep = User::where('user_role', 'equipeprojet')->count();
        // $pa = PlanAction::count();
        // $pr = Projet::count();

        // $tabpro = $tabpl = $tabrisk = [];
        // foreach (range(1, 12) as $m) {
        //     array_push($tabpro, Projet::whereMonth('dateajout', $m)->count());
        //     array_push($tabrisk, Risque::whereMonth('dateajout', $m)->count());
        //     array_push($tabpl, PlanAction::whereMonth('dateajout', $m)->count());
        // }
        return view('admin.accueil');
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
        return view('admin.poubelle');
    }
}
