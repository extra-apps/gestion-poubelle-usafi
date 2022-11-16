<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Evacuateur;
use App\Models\Paiement;
use App\Models\PlanAction;
use App\Models\Poubelle;
use App\Models\Projet;
use App\Models\Risque;
use App\Models\User;
use App\Models\UsersHasRisque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function abonnement()
    {
        if (!auth()->check()) {
            return redirect('/');
        }
        if (!auth()->user()->mustpay) {
            return redirect(route('client.accueil'));
        }

        $config = Config::first();
        $config = @json_decode($config->config);

        $montant = @$config->compte;
        $devise = @$config->devise;
        return view('abonnement', compact('montant', 'devise'));
    }

    public function client()
    {
        $data = User::where('user_role', 'client')->orderBy('id', 'desc')->get();
        $tab = [];
        foreach ($data as $el) {
            $e = (object) $el->toArray();
            $e->nbpoubelle = $el->poubelles()->count();
            array_push($tab, $e);
        }
        return response()->json($tab);
    }

    public function client_a()
    {

        if (User::where(['email' => $em = request()->email])->first()) {
            return response()->json(['success' => false, "message" => "Veuillez utiliser un autre email : $em"]);
        }

        $tel =  request()->telephone;
        $tel = str_replace(['(', ')', '_'], '', $tel);
        if (strlen($tel) != 12) {
            return response()->json(['success' => false, "message" => "Telephone non valide : $tel"]);
        }

        if (User::where(['telephone' => $tel])->first()) {
            return response()->json(['success' => false, "message" => "Veuillez utiliser un autre numero : $tel"]);
        }

        $u = ['user_role' => 'client', 'name' => $cl = request()->name, 'telephone' => $tel, 'email' => $em];
        $u['password'] = Hash::make('123456');
        $u['mustpay'] = 1;
        User::create($u);
        return response()->json(['success' => true, "message" => "Le client $cl a été créé"]);
    }

    public function client_d()
    {
        User::where(['user_role' => 'client', 'id' =>  request()->id])->delete();
    }

    // ==============
    public function chauffeur()
    {
        $data = User::where('user_role', 'chauffeur')->orderBy('id', 'desc')->get();
        return response()->json($data);
    }

    public function chauffeur_a()
    {

        if (User::where(['email' => $em = request()->email])->first()) {
            return response()->json(['success' => false, "message" => "Veuillez utiliser un autre email : $em"]);
        }

        $tel =  request()->telephone;
        $tel = str_replace(['(', ')', '_'], '', $tel);
        if (strlen($tel) != 12) {
            return response()->json(['success' => false, "message" => "Telephone non valide : $tel"]);
        }
        if (User::where(['telephone' => $tel])->first()) {
            return response()->json(['success' => false, "message" => "Veuillez utiliser un autre numero : $tel"]);
        }

        $u = ['user_role' => 'chauffeur', 'name' => $cl = request()->name, 'telephone' => $tel, 'email' => $em];
        $u['password'] = Hash::make('123456');
        User::create($u);
        return response()->json(['success' => true, "message" => "Le chauffeur $cl a été créé"]);
    }

    public function chauffeur_d()
    {
        User::where(['user_role' => 'client', 'id' =>  request()->id])->delete();
    }


    // ==============
    public function poubelle()
    {
        $data = Poubelle::orderBy('id', 'desc')->get();
        $tab = [];
        foreach ($data as $el) {
            $e = (object) $el->toArray();
            $e->numero = num($el->id);
            $e->client = $el->user->name;
            $e->etat = 'NORMAL';
            $e->niveau = rand(10, 100) . '%';
            array_push($tab, $e);
        }
        return response()->json($tab);
    }

    public function poubelle_a()
    {
        Poubelle::create(request()->all());
        return response()->json(['success' => true, "message" => "La poubelle a été créé"]);
    }

    public function poubelle_d()
    {
        User::where(['user_role' => 'client', 'id' =>  request()->id])->delete();
    }

    public function paiement()
    {
        $data = Paiement::orderBy('id', 'desc')->get();
        $tab = [];
        foreach ($data as $el) {
            $e = (object) $el->toArray();
            $e->numero = num($el->id);
            $e->client = $el->user->name;
            $e->etat = 'NORMAL';
            $e->niveau = rand(10, 100) . '%';
            $e->montant = "$el->montant $el->devise";
            $e->date = $el->date->format('d-m-Y');
            array_push($tab, $e);
        }
        return response()->json($tab);
    }

    public function config()
    {
        $conf = (object)[];
        $conf->compte = (float) request()->compte;
        $conf->niveau1 = (float) request()->niveau1;
        $conf->niveau2 = (float) request()->niveau2;
        $conf->niveau3 = (float) request()->niveau3;
        $conf->devise = "CDF";

        $cnf = Config::first();
        if ($cnf) {
            $cnf->update(['config' => json_encode($conf)]);
        } else {
            Config::create(['config' => json_encode($conf)]);
        }
        return response()->json(['success' => true, "message" => "La configuration a été enregistrée"]);
    }

    public function evacuateur()
    {
        $idpub = request()->poubelle_id;
        $idus = request()->users_id;

        $ev = Evacuateur::where(['poubelle_id' => $idpub])->first();
        if ($ev) {
            $ev->update(['users_id' => $idus]);
        } else {
            Evacuateur::create(['users_id' => $idus, 'poubelle_id' => $idpub]);
        }
        return response()->json(['success' => true, "message" => "La configuration a été enregistrée"]);
    }
}
