<?php

namespace App\Http\Controllers;

use App\Models\Aevacuer;
use App\Models\Commentaire;
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
        $contrat = @file_get_contents('contrat.txt');
        return view('abonnement', compact('montant', 'devise', 'contrat'));
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
        $u = request()->u;
        if ($u) {
            $idp = Evacuateur::where('users_id', $u)->pluck('poubelle_id')->all();
            $data = Poubelle::whereIn('id', $idp)
                ->orderBy('niveau', 'desc')
                ->get();
        } else {
            $data = Poubelle::orderBy('niveau', 'desc')->get();
        }

        $tab = [];
        foreach ($data as $el) {
            $e = (object) $el->toArray();
            $e->numero = num($el->id);
            $e->client = $el->user->name;
            if ($el->niveau == 'niveau1') {
                $n = 50;
            } else if ($el->niveau == 'niveau2') {
                $n = 75;
            } else if ($el->niveau == 'niveau3') {
                $n = 100;
            } else {
                $n = 0;
            }
            $e->niveau = $n;
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
            $e->client = $el->poubelle->user->name;
            if ($el->niveau == 'niveau1') {
                $n = 50;
            } else if ($el->niveau == 'niveau2') {
                $n = 75;
            } else if ($el->niveau == 'niveau3') {
                $n = 100;
            } else {
                $n = 0;
            }
            $e->niveau = $n;
            $e->montant = "$el->montant $el->devise";
            $e->date = $el->date->format('d-m-Y H:i:s');
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

    public function capteur()
    {
        $p = (int) str_replace('P-', '', request()->poubelle);
        $cap1 = (int) request()->cap1;
        $cap2 = (int) request()->cap2;
        $cap3 = (int) request()->cap3;
        $niveau = '';
        $error = 0;
        $poubelle = Poubelle::where('id', $p)->first();
        if ($poubelle) {
            if (in_array($cap1, [1, 0]) and in_array($cap2, [1, 0]) and in_array($cap3, [1, 0])) {
                if ($cap1 == $cap2 and $cap2 == $cap3 and $cap3 == 0) {
                    $niveau = 'niveau1';
                    $poubelle->update(['niveau' => $niveau, 'cap1' => 0, 'cap2' => 0, 'cap3' => 0, 'mustpay' => 0]); // vide
                } else if ($cap1 == $cap2 and $cap2 == $cap3 and $cap3 == 1) {
                    $niveau = 'niveau3';
                    $poubelle->update(['niveau' => $niveau, 'cap1' => 1, 'cap2' => 1, 'cap3' => 1, 'mustpay' => 1]); // full | niveau 3
                    appelChauffeur($poubelle);
                } else if ($cap1 == 1 and $cap2 == 0 and $cap3 == 0) {
                    $niveau = 'niveau1';
                    $poubelle->update(['niveau' => $niveau, 'cap1' => $cap1, 'cap2' => $cap2, 'cap3' => $cap3, 'mustpay' => 1]); // niveau 1
                    canNotify($poubelle);
                } else if ($cap1 == 1 and $cap2 == 1 and $cap3 == 0) {
                    $niveau = 'niveau2';
                    $poubelle->update(['niveau' => $niveau, 'cap1' => $cap1, 'cap2' => $cap2, 'cap3' => $cap3, 'mustpay' => 1]); // niveau 2
                    canNotify($poubelle);
                } else {
                    $poubelle->update(['niveau' => null, 'cap1' => $cap1, 'cap2' => $cap2, 'cap3' => $cap3, 'mustpay' => 0]); // erreur
                    $error = 1;
                }
            } else {
                $error = 1;
            }
        } else {
            $error = 1;
        }

        echo ("#{$error}#");
        // return response("$$niveau$");
    }

    public function commentaire()
    {
        $data = request()->all();
        $data['users_id'] = auth()->user()->id;
        Commentaire::create($data);
    }

    public function sensibilisation($email = null)
    {
        $msg = '';
        if ($email) {
            $u = User::where('email', $email)->first();
            if ($u) {
                sensibilisationMsg($u->telephone);
                $msg = "Message de sensibilisation envoyé au client {$u->name} : {$u->telephone}";
            } else {
                $msg = "Email $email est invalide";
            }
        } else {
            sensibilisationMsg();
            $msg = "Message de sensibilisation envoyé à tous les clients";
        }

        return $msg;
    }
}
