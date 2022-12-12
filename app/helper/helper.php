<?php

use Twilio\Rest\Client;
use App\Models\Flexpay;
use App\Models\Paiement;
use App\Models\Poubelle;
use App\Models\User;

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
                                Paiement::where('id', $payedata->paiement_id)->update(['paie' => 1, 'date' => now('Africa/Lubumbashi')]);
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

function sms($to = '', $msg = '')
{
    $e = routeeApi($to, $msg);
    return $e;
}

function routeeApi($to = '', $msg = '')
{
    $rep = false;
    $curl = curl_init();
    if (!file_exists('routeeToken.auth')) {
        touch('routeeToken.auth');
    }
    $file = fopen("routeeToken.auth", "r+");
    $token = file_get_contents("routeeToken.auth");
    fclose($file);

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://connect.routee.net/sms',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "body": "' . $msg . '",
            "to" : "' . $to . '",
            "from": "Usafi"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "Authorization: Bearer $token"
        ),
    ));
    $response = curl_exec($curl);
    $code = curl_getinfo($curl)['http_code'];
    // dd($response, $code);
    if ($code == 401) {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'https://auth.routee.net/oauth/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic NjM5MzMxNzE1NzljYzMwMDAxNTE2OTk3OmdabG85c3Q5N2c=='
            ),
        ));
        $resp = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($resp);
        if (is_object($resp)) {
            $file = fopen("routeeToken.auth", "w+");
            fwrite($file, $resp->access_token);
            fclose($file);
            return routeeApi($to, $msg);
        }
    } else if ($code == 201) {
        $rep = true;
    }
    curl_close($curl);
    return $rep;
}

function orangeApi($to = '', $msg = '')
{
    $rep = false;
    $curl = curl_init();
    if (!file_exists('OrangeToken.auth')) {
        touch('OrangeToken.auth');
    }
    $file = fopen("OrangeToken.auth", "r+");
    $token = file_get_contents("OrangeToken.auth");
    fclose($file);

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B2430000/requests',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
				"outboundSMSMessageRequest": {
					"address": "tel:+' . $to . '",
					"senderAddress":"tel:+2430000",
					"outboundSMSTextMessage": {
						"message": "' . $msg . '"
					}
				}
			}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            "Authorization: Bearer $token"
        ),
    ));
    $response = curl_exec($curl);
    $code = curl_getinfo($curl)['http_code'];
    if ($code == 401) {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'https://api.orange.com/oauth/v3/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic d1JubUplcmlHTU16NHVPTXAwUjBNbHJobGxNdFdTMEo6dGwwWDJRVXM4cXZMTnFJWQ=='
            ),
        ));
        $resp = curl_exec($ch);
        curl_close($ch);
        $resp = json_decode($resp);
        if (is_object($resp)) {
            $file = fopen("OrangeToken.auth", "w+");
            fwrite($file, $resp->access_token);
            fclose($file);
            return orangeApi($to, $msg);
        }
    } else if ($code == 201) {
        $rep = true;
    }
    curl_close($curl);
    return $rep;
}

function randMess()
{
    $msg = [
        "Le meilleur déchet est celui que l’on ne produit pas. Aller à l’origine du problème et avant tout de diminuer sa production de déchets.",
        "Les déchets sont nuisibles à la santé de l’être vivant Homme animal et plante d’où il est nécessaire de les traites comme il se doit. Eviter de les jeter n’importe ou mais plus important encore c’est d’éviter d’en produire en grande quantité.",
        "Produisez moins déchets et payer moins lors du ramassage, le fait de produire moins de déchets est bénéfique pour l’environnement et pour votre portefeuille.",
        "Toujours jeter les déchets dans une poubelle afin de garder notre environnement propre er sain.",
        "Produisez moins des déchets et payer moins mais surtout toujours être raccordé à un service d’assainissement tel que SadromGreen."
    ];
    return $msg[array_rand($msg)];
}

function sensibilisationMsg($tel = null)
{
    if ($tel) {
        return sms($tel, randMess());
    }

    $_f = 'data';
    if (!file_exists($_f)) {
        touch($_f);
        $file = fopen($_f, "w");
        fwrite($file, json_encode(['can' => true]));
        fclose($file);
    } else {
        $file = fopen($_f, "a+"); //cree le fichier data
        $f = json_decode(file_get_contents($_f), true);
        if (!$f) { // si data est vide
            fclose($file);
            $file = fopen($_f, "w");
            fwrite($file, json_encode(['can' => true]));
        }
        fclose($file);
    }

    $data = (object) json_decode(file_get_contents($_f), true);

    $now = new DateTime();
    $begin = new DateTime('06:00');
    $end = new DateTime('18:00');

    $last_bk_day = $data->last_bk ?? 0;
    $day = strtotime(date('d-m-Y'));
    if ($last_bk_day) {
        $last_bk_day = explode('H', $last_bk_day)[0];
        $last_bk_day = explode(' ', $last_bk_day)[0];
        $last_bk_day = strtotime($last_bk_day);
    }

    $can = $data->can;
    if ($last_bk_day < $day) {
        $can = true;
    }

    if ($now >= $begin && $now <= $end) {
        if ($can) {
            $u = User::where('user_role', 'client')->get();
            foreach ($u as $e) {
                $num = $e->telephone;
                sms($num, randMess());
            }
            $file = fopen($_f, "w");
            fwrite($file, json_encode(['can' => false, 'last_bk' => date('d-m-Y H:i:s')]));
            fclose($file);
        }
    }
}

function appelChauffeur($poubelle)
{
    $d = $poubelle->evacuateurs()->first();
    if ($d) {
        $tel = $d->user->telephone;
        $m = "Alerte : la poubelle " . num($poubelle->id) . " est pleine.";
        $_f = 'notif';
        if (!file_exists($_f)) {
            touch($_f);
            $file = fopen($_f, "w");
            fwrite($file, json_encode([]));
            fclose($file);
        } else {
            $file = fopen($_f, "a+");
            $f = json_decode(file_get_contents($_f), true);
            if (!$f) {
                fclose($file);
                $file = fopen($_f, "w");
                fwrite($file, json_encode([]));
            }
            fclose($file);
        }
        $data = json_decode(file_get_contents($_f), true);

        $find = false;
        $tab = [];
        foreach ($data as $e) {
            $e = (object) $e;
            if ($e->id == $poubelle->id) {
                $find = true;
                if ($e->can) {
                    sms($tel, $m);
                    $e->can = false;
                }
            }
            array_push($tab, $e);
        }

        if (!$find) {
            sms($tel, $m);
            array_push($tab, (object)['can' => false, 'id' => $poubelle->id, 'date' => time()]);
        }

        $file = fopen($_f, "w");
        fwrite($file, json_encode($tab));
        fclose($file);
    }
}

function canNotify($poubelle)
{
    $_f = 'notif';
    if (!file_exists($_f)) {
        return;
    }
    $data = json_decode(file_get_contents($_f), true);
    $tab = [];
    foreach ($data as $e) {
        $e = (object) $e;
        if ($e->id == $poubelle->id) {
            $e->can = true;
        }
        array_push($tab, $e);
    }
    $file = fopen($_f, "w");
    fwrite($file, json_encode($tab));
    fclose($file);
}
