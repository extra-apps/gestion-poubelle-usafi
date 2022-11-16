<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Flexpay;
use App\Models\Paiement;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function payCallBack($cb_code = null)
    {
        if ($cb_code) {
            Flexpay::where(['is_saved' => 0, 'cb_code' => $cb_code])->update(['callback' => 1]);
        }
    }

    public function initPayement()
    {
        if (!auth()->check()) return;
        $user = auth()->user();
        $attr = request()->all();
        $validator = Validator::make($attr, [
            'telephone' => 'required|'
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'message' => implode(",", $validator->errors()->all())];
        }
        $data = $validator->validated();
        if ($user->mustpay  == 0) return;

        $config = Config::first();
        $config = @json_decode($config->config);
        $montant = (float) @$config->compte;
        $devise = @$config->devise;

        if ($montant == 0) {
            return ['success' => false, 'message' => "Montant de paiement semble etre invalide."];
        }

        $telephone = "243" . $data['telephone'];

        $ref = strtoupper(uniqid('pay-', true));
        $cb_code = time() . rand(10000, 90000);
        $_paydata = [
            'type' => 'abonnement',
            'devise' => $devise,
            'montant' => $montant,
            'telephone' => $telephone,
            'users_id' => $user->id
        ];

        $rep = startFlexPay($devise, $montant, $telephone, $ref, $cb_code);

        $tab =   [];
        if ($rep['status'] == true) {
            $tab['ref'] = $ref;
            $paydata = [
                'paydata' => $_paydata,
                'apiresponse' => $rep['data']
            ];
            Flexpay::create([
                'user' => $user,
                'cb_code' => $cb_code,
                'ref' => $ref,
                'pay_data' => json_encode($paydata),
                'date' => now('Africa/Lubumbashi')
            ]);
            return ['success' => true, 'message' => [$rep['message']], 'ref' => $ref];
        } else {
            return ['success' => false, 'message' => [$rep['message']]];
        }
    }


    public function checkPayement($ref = null)
    {
        if (!auth()->check()) return;
        if (!$ref) {
            return [];
        }

        $flex = Flexpay::where([
            'ref' => $ref,
            'is_saved' => 1
        ])->first();

        if ($flex) {
            $m = "Votre transaction est enregistrée avec succès.";
            return ['success' => true, 'message' => [$m]];
        } else {
            $m = "Aucune transaction enregistrée.";
            return ['success' => false, 'message' => [$m]];
        }
    }
}
