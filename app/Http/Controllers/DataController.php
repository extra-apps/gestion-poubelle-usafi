<?php

namespace App\Http\Controllers;

use App\Models\PlanAction;
use App\Models\Projet;
use App\Models\Risque;
use App\Models\User;
use App\Models\UsersHasRisque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
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

        $u = ['user_role' => 'client', 'name' => $cl = request()->name, 'telephone' => $tel, 'email' => $em];
        $u['password'] = Hash::make('123456');
        User::create($u);
        return response()->json(['success' => true, "message" => "Le client $cl été créé"]);
    }

    public function client_d()
    {
        User::where(['user_role' => 'client', 'id' =>  request()->id])->delete();
    }

    public function equipeprojet()
    {
        $data = User::where('user_role', 'equipeprojet')->orderBy('id', 'desc')->get();
        return response()->json($data);
    }

    public function equipeprojet_a()
    {

        $data = User::where(['user_role' => 'equipeprojet', 'name' => $na = request()->name])->first();
        if ($data) {
            return response()->json(['success' => false, "message" => "L'agent $data->name existe déjà"]);
        }
        if (User::where(['email' => $em = request()->email])->first()) {
            return response()->json(['success' => false, "message" => "Veuillez utiliser un autre email : $em"]);
        }

        $u = ['user_role' => 'equipeprojet', 'name' => request()->name, 'role1' => request()->role, 'observation' => request()->observation, 'service' => request()->service, 'email' => $em];
        $u['password'] = Hash::make('123456');
        $u['service'] = request()->service;
        $u['observation'] = request()->observation;
        User::create($u);
        return response()->json(['success' => true, "message" => "L'agent $na été créé"]);
    }

    public function equipeprojet_d()
    {
        User::where(['user_role' => 'equipeprojet', 'id' =>  request()->id])->delete();
    }

    public function projet()
    {
        $data = Projet::orderBy('id', 'desc')->get();
        $tab = [];
        foreach ($data as $el) {
            $e = (object) [];
            $e->id = $el->id;
            $e->nomprojet = $el->nomprojet;
            $e->datedebut = $el->datedebut->format('d-m-Y');
            $e->datefin = $el->datefin->format('d-m-Y');
            $e->cout = $el->cout;

            $idr = Risque::where('projet_id', $e->id)->pluck('id')->all();
            $uids = UsersHasRisque::whereIn('risque_id', $idr)->pluck('users_id')->all();
            $equip = User::whereIn('id', $uids)->pluck('name')->all();
            $eq = implode(', ', $equip);
            $e->equipe = empty($eq) ? '-' : $eq;
            array_push($tab, $e);
        }
        return response()->json($tab);
    }

    public function projet_a()
    {
        $validator = Validator::make(
            request()->all(),
            [
                'nomprojet' => 'required',
                'description' => 'required',
                'caracteristique' => 'required',
                'competences' => 'required',
                'datedebut' => 'required|date',
                'datefin' => 'required|date',
                'cout' => 'required',
                'delaiclient' => 'sometimes',
                'elementcontrat' => 'sometimes',
                'coordonateurqualite' => 'sometimes',
                'expertdesigner' => 'sometimes',
                'periodicitereunion' => 'sometimes',
                'devis' => 'sometimes',
                'cahierdecharge' => 'sometimes',
                'planning' => 'sometimes',
                'specificationsystem' => 'sometimes',
                'plandevelopement' => 'sometimes',
                'observationcp' => 'sometimes',
                'planqualite' => 'sometimes',
                'planvalidation' => 'sometimes'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => implode(",", $validator->errors()->all())
            ]);
        }

        $data = $validator->validated();
        $data['users_id'] = auth()->user()->id;

        Projet::create($data);
        return response()->json(['success' => true, "message" => "Le projet a été créé"]);
    }

    public function projet_d()
    {
        Projet::where(['id' =>  request()->id])->delete();
        return redirect(request()->back);
    }

    public function risque()
    {
        $data = Risque::where('projet_id', request()->projet_id)->orderBy('id', 'desc')->get();
        $tab = [];
        foreach ($data as $el) {
            $e = (object) $el->toArray();
            $e->daterisque = $el->daterisque->format('d-m-Y');
            $e->datelimite = $el->datelimite->format('d-m-Y');

            $uids = UsersHasRisque::where('risque_id', $el->id)->pluck('users_id')->all();
            $equip = User::whereIn('id', $uids)->pluck('name')->all();
            $eq = implode(',', $equip);
            $e->equipe = empty($eq) ? '-' : $eq;
            array_push($tab, $e);
        }
        return response()->json($tab);
    }

    public function risque_a()
    {
        $validator = Validator::make(
            request()->all(),
            [
                'projet_id' => 'required',
                'nomclient' => 'required',
                'categorierisque' => 'required',
                'probabilitedoccurence' => 'required',
                'impact' => 'sometimes|',
                'gravite' => 'sometimes|',
                'source' => 'sometimes',
                'description' => 'sometimes',
                'daterisque' => 'sometimes|date',
                'actionmitigation' => 'sometimes',
                'coefficientexposition' => 'sometimes',
                'etatrisque' => 'sometimes',
                'datelimite' => 'sometimes|date',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => implode(",", $validator->errors()->all())
            ]);
        }

        $data = $validator->validated();
        $data['users_id'] = auth()->user()->id;

        $ri = Risque::create($data);
        $equipepro = request()->equipepro;
        if ($equipepro) {
            foreach ($equipepro as $i) {
                UsersHasRisque::create(['users_id' => $i, 'risque_id' => $ri->id]);
            }
        }
        return response()->json(['success' => true, "message" => "Le risque a été enregistré"]);
    }

    public function risque_d()
    {
        Risque::where(['id' =>  request()->id])->delete();
    }

    public function plan()
    {
        $data = PlanAction::where('risque_id', request()->risque_id)->orderBy('id', 'desc')->get();
        $tab = [];
        foreach ($data as $el) {
            $e = (object) $el->toArray();
            $e->dateaction = $el->dateaction->format('d-m-Y');
            $e->dateplanfin = $el->dateplanfin->format('d-m-Y');
            $e->datereelfin = $el->datereelfin->format('d-m-Y');
            array_push($tab, $e);
        }
        return response()->json($tab);
    }

    public function plan_a()
    {

        $validator = Validator::make(
            request()->all(),
            [
                'risque_id' => 'required',
                'codeplan' => 'required',
                'priorite' => 'required',
                'sujetaction' => 'required',
                'dateaction' => 'required|',
                'statusaction' => 'sometimes',
                'description' => 'sometimes',
                'dateplanfin' => 'sometimes|date',
                'actionsuivant' => 'sometimes',
                'typeaction' => 'sometimes',
                'datereelfin' => 'sometimes|date',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => implode(",", $validator->errors()->all())
            ]);
        }

        $data = $validator->validated();
        PlanAction::create($data);
        return response()->json(['success' => true, "message" => "Le plan d'action a été enregistré"]);
    }

    public function plan_d()
    {
        PlanAction::where(['id' =>  request()->id])->delete();
    }
}
