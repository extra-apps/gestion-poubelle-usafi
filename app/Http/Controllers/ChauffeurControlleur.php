<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Evacuateur;
use App\Models\Evacuation;
use App\Models\Paiement;
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
        $chid = auth()->user()->id;

        foreach ($u as $e) {
            $d = (object) [];
            $d->user = $e->name;
            $d->map = $e->map;
            $l = '<p class="p-0 m-0"><i class="fa fa-trash text-success"></i> Poubelles :</p><ul>';
            $find = false;
            foreach ($e->poubelles()->get() as $p) {
                if (@$p->evacuateurs()->first()->users_id == $chid) {
                    $l .= "<li>" . num($p->id) . "</li></ul>";
                    $find = true;
                }
            }
            $d->poubelle = $l;
            if ($e->map) {
                if ($find) {
                    array_push($map, $d);
                }
            }
        }
        return view('chauffeur.accueil', compact('map'));
    }

    public function evacuer()
    {
        $poub = Poubelle::where('id', request()->poubelle_id)->first();
        if (!$poub) {
            return response()->json(['success' => false, 'message' => 'poubelle ??']);
        }

        if (empty($poub->niveau)) {
            return response()->json(['success' => false, 'message' => 'Aucun niveau détécté dans la poubelle, impossible de l\'evacuer.']);
        }

        Evacuation::create(['date' => now('Africa/Lubumbashi'), 'poubelle_id' => $poub->id, 'users_id' => auth()->user()->id]);
        $niveau = @$poub->niveau;
        $config = Config::first();
        $config = @json_decode($config->config);
        $montant = (float) @$config->$niveau;
        $devise = @$config->devise;
        Paiement::create(['date' => now('Africa/Lubumbashi'), 'poubelle_id' => $poub->id, 'paie' => 0, 'niveau' => $niveau, 'montant' => $montant, 'devise' => $devise]);
        $poub->update(['cap1' => 0, 'cap2' => 0, 'cap3' => 0, 'niveau' => '',]);
        // $poub->update(['canempty' => 0]);
        return response()->json(['success' => true, 'message' => "Vous venez d'enregistrer l'évacuation de la poubelle " . num($poub->id)]);
    }
}
