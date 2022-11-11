<?php

namespace App\Http\Controllers;

use App\Models\Concession;
use App\Models\Config;
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
        // foreach (range(1, 12) as $m) {
        //     $n = rand(1, 30);
        //     for ($i = 0; $i < $n; $i++) {
        //         $p = Poubelle::create(['dateajout' => "2022-$m-11", 'users_id' => 18, 'taille' => $n]);
        //         $mm = rand(1, 5);
        //         for ($j = 0; $j < $mm; $j++) {
        //             Evacuation::create(['date' => "2022-$m-11", 'users_id' => 18, 'poubelle_id' => $p->id]);
        //         }
        //     }
        // }

        // foreach (range(1, 12) as $m) {
        //     User::create(['user_role' => 'chauffeur', 'name' => time(), 'email' => rand(1222,999999999), 'password' => time()]);
        // }

        // foreach (range(1, 52) as $m) {
        //     User::create(['user_role' => 'client', 'name' => time(), 'email' => rand(1222,999999999), 'password' => time()]);
        // }

        $cl = User::where('user_role', 'client')->count();
        $ch = User::where('user_role', 'chauffeur')->count();
        $pb = Poubelle::count();
        $pbp = Poubelle::count();
        $eva = Evacuation::count();

        $tabeva = $tabpb = [];
        foreach (range(1, 12) as $m) {
            array_push($tabeva, Evacuation::whereMonth('date', $m)->count());
            array_push($tabpb,  Poubelle::whereMonth('dateajout', $m)->count());
        }
        return view('admin.accueil', compact('cl', 'ch', 'pb', 'pbp', 'tabeva', 'tabpb', 'eva'));
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
        $item = request()->item;
        if ($item) {
            $poubelle = Poubelle::where('id', $item)->first();
            if ($poubelle) {
                $chauffeurs = User::where('user_role', 'chauffeur')->orderBy('id', 'desc')->get();
                $chauffeur = '-';
                $idchauf = '';
                $ev = $poubelle->evacuateurs()->first();
                if ($ev) {
                    $chauffeur = $ev->user->name;
                    $idchauf = $ev->user->id;
                }
                return view('admin.poubelle-detail', compact('poubelle', 'chauffeur', 'idchauf', 'chauffeurs'));
            }
        }
        $clients = User::where('user_role', 'client')->orderBy('id', 'desc')->get();
        return view('admin.poubelle', compact('clients'));
    }

    public function paiement()
    {
        return view('admin.paiement');
    }

    public function config()
    {
        $conf = Config::first();
        $conf = json_decode(@$conf->config);
        $compte = (float) @$conf->compte;
        $niveau1 = (float) @$conf->niveau1;
        $niveau2 = (float) @$conf->niveau2;
        $niveau3 = (float) @$conf->niveau3;
        $devise = @$conf->devise;
        $poubelles = Poubelle::orderBy('id', 'desc')->get();
        return view('admin.config', compact('compte', 'niveau1', 'niveau2', 'niveau3', 'devise', 'poubelles'));
    }
}
