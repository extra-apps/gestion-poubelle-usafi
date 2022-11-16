<?php

namespace App\Http\Controllers;

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
            ->orderBy('id', 'desc')
            ->get();
        return view('client.accueil', compact('poubelles'));
    }
}
