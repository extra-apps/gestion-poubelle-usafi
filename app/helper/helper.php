<?php

use App\Models\Aevacuer;
use App\Models\Flexpay;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Support\Facades\DB;

define('FLEXPAY_HEADERS', [
    "Content-Type: application/json",
    "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzI2NzM2NzQ4LCJzdWIiOiI2ZGQzMWVmOTNkNzQ2ZmQ2NmU5ZjZjZDRhMWNjM2M2YiJ9.A5wcsvDM1wi_xdsWJQOM18IZaBPvyTPRAQFgvi0WIlg"
]);

function startFlexPay($devise, $montant, $telephone, $ref, $cb_code)
{
    $_api_headers = FLEXPAY_HEADERS;
    $marchand = 'GROUPER';

    $telephone = (float) $telephone;
    $data = array(
        "merchant" => $marchand,
        "type" => "1",
        "phone" => "$telephone",
        "reference" => "$ref",
        "amount" => "$montant",
        "currency" => "$devise",
        "callbackUrl" => route('payment.callback', $cb_code),
    );


    $data = json_encode($data);
    // $gateway = "http://41.243.7.46:3006/api/rest/v1/paymentService"; // test
    $gateway = "https://backend.flexpay.cd/api/rest/v1/paymentService";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $gateway);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $_api_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    $response = curl_exec($ch);
    $rep['status'] = false;
    if (curl_errno($ch)) {
        $rep['message'] = "Une erreur s'est produite lors du traitement de votre requête, veuillez reessayer.";
    } else {
        $jsonRes = json_decode($response);
        $code = $jsonRes->code ?? '';
        if ($code != "0") {
            $rep['message'] = "Une erreur s'est produite lors du traitement de votre requête : " . @$jsonRes->message;
            $rep['data'] = $jsonRes;
        } else {
            $rep['status'] = true;
            $rep['message'] = "Transaction initialisée avec succès. Veuillez saisir votre code Mobile Money pour confirmer la transaction. En suite appuyez sur le bouton ci-dessous pour vérifier la transaction.";
            $rep['data'] = $jsonRes;
        }
    }
    curl_close($ch);
    return $rep;
}

function completeFlexpayTrans()
{
    $pendingPayments = Flexpay::where(['callback' => '1', 'is_saved' => '0', 'transaction_was_failled' => '0'])->get();
    foreach ($pendingPayments as $e) {
        $payedata = json_decode($e->pay_data);
        $orderNumber = $payedata->apiresponse->orderNumber;
        if (transaction_was_success($orderNumber) == true) {
            $payedata = $payedata->paydata;
            if ($payedata->type == 'abonnement') {
                User::where('id', $payedata->users_id)->update(['mustpay' => 0]);
            } else {
                Paiement::create(['poubelle_id' => $payedata->poubelle_id, 'montant' => $payedata->montant, 'devise' => $payedata->devise, 'date' => now('Africa/Lubumbashi')]);
                Aevacuer::where(['poubelle_id' => $payedata->poubelle_id])->delete();
            }
            $e->update(['is_saved' => 1]);
        } else {
            $e->update(['transaction_was_failled' => 1]);
        }
    }
}

function transaction_was_success($orderNumber)
{
    $_api_headers = FLEXPAY_HEADERS;

    $gateway = "https://backend.flexpay.cd/api/rest/v1/check/" . $orderNumber;
    // $gateway = "http://41.243.7.46:3006/api/rest/v1/check/" . $orderNumber;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $gateway);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $_api_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    $response = curl_exec($ch);
    $status = false;
    if (!curl_errno($ch)) {
        curl_close($ch);
        $jsonRes = json_decode($response);
        $code = $jsonRes->code ?? '';
        if ($code == "0") {
            if ($jsonRes->transaction->status == '0') {
                $status = true;
            }
        }
    }
    return $status;
}

function num($n)
{
    if ($n <= 9) {
        return "P-00$n";
    }

    if ($n > 9 and $n < 99) {
        return "P-0$n";
    }

    if ($n > 99 and $n < 999) {
        return "P-$n";
    }

    return "P-$n";
}
