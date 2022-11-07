<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Projet
 * 
 * @property int $id
 * @property string|null $nomprojet
 * @property string|null $description
 * @property string|null $caracteristique
 * @property string|null $competences
 * @property Carbon|null $datedebut
 * @property Carbon|null $datefin
 * @property string|null $cout
 * @property string|null $delaiclient
 * @property string|null $elementcontrat
 * @property string|null $coordonateurqualite
 * @property string|null $expertdesigner
 * @property string|null $periodicitereunion
 * @property string|null $devis
 * @property string|null $cahierdecharge
 * @property string|null $planning
 * @property string|null $specificationsystem
 * @property string|null $plandevelopement
 * @property string|null $observationcp
 * @property string|null $planqualite
 * @property string|null $planvalidation
 * @property string|null $nomequipe
 * @property Carbon|null $dateajout
 * @property int $users_id
 * 
 * @property User $user
 * @property Collection|Risque[] $risques
 *
 * @package App\Models
 */
class Projet extends Model
{
	protected $table = 'projet';
	public $timestamps = false;

	protected $casts = [
		'users_id' => 'int'
	];

	protected $dates = [
		'datedebut',
		'datefin',
		'dateajout'
	];

	protected $fillable = [
		'nomprojet',
		'description',
		'caracteristique',
		'competences',
		'datedebut',
		'datefin',
		'cout',
		'delaiclient',
		'elementcontrat',
		'coordonateurqualite',
		'expertdesigner',
		'periodicitereunion',
		'devis',
		'cahierdecharge',
		'planning',
		'specificationsystem',
		'plandevelopement',
		'observationcp',
		'planqualite',
		'planvalidation',
		'nomequipe',
		'dateajout',
		'users_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id');
	}

	public function risques()
	{
		return $this->hasMany(Risque::class);
	}
}
