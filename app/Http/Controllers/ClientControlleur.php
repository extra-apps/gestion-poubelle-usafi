<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Paiement;
use App\Models\Poubelle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientControlleur extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $u = Auth::user();
            if ($u->user_role != 'client') {
                abort(401);
            }
            if ($u->mustpay) {
                return redirect(route('client.abonnement'));
            }
            return $next($request);
        });
    }

    public function accueil()
    {

        $poubelles = Poubelle::where('users_id', auth()->user()->id)
            ->orderBy('niveau', 'desc')
            ->get();

        $paiements = Paiement::whereIn('poubelle_id', Poubelle::where('users_id', auth()->user()->id)->pluck('id')->all())->orderBy('id', 'desc')->get();
        return view('client.accueil', compact('poubelles', 'paiements'));
    }

    public function paiement_poubelle()
    {
        $item = request()->item;
        if ($item) {
            $poubelle = Poubelle::where(['id' => $item, 'users_id' => auth()->user()->id])->first();
            if ($poubelle) {

                $config = Config::first();
                $config = @json_decode($config->config);
                $niveau = $poubelle->niveau;

                $montant = @$config->$niveau;
                $devise = @$config->devise;
                return view('client.paiement_poubelle', compact('poubelle', 'montant', 'devise', 'niveau'));
            }
        }

        return redirect(route('client.accueil'));
    }
}
