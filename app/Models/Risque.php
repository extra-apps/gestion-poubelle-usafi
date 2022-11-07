<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Risque
 * 
 * @property int $id
 * @property string|null $nomclient
 * @property string|null $categorierisque
 * @property int|null $probabilitedoccurence
 * @property string|null $impact
 * @property string|null $gravite
 * @property string|null $source
 * @property string|null $description
 * @property Carbon|null $daterisque
 * @property string|null $actionmitigation
 * @property string|null $coefficientexposition
 * @property string|null $etatrisque
 * @property Carbon|null $datelimite
 * @property int $projet_id
 * @property Carbon|null $dateajout
 * 
 * @property Projet $projet
 * @property Collection|PlanAction[] $plan_actions
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Risque extends Model
{
	protected $table = 'risque';
	public $timestamps = false;

	protected $casts = [
		'probabilitedoccurence' => 'int',
		'projet_id' => 'int'
	];

	protected $dates = [
		'daterisque',
		'datelimite',
		'dateajout'
	];

	protected $fillable = [
		'nomclient',
		'categorierisque',
		'probabilitedoccurence',
		'impact',
		'gravite',
		'source',
		'description',
		'daterisque',
		'actionmitigation',
		'coefficientexposition',
		'etatrisque',
		'datelimite',
		'projet_id',
		'dateajout'
	];

	public function projet()
	{
		return $this->belongsTo(Projet::class);
	}

	public function plan_actions()
	{
		return $this->hasMany(PlanAction::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_has_risque', 'risque_id', 'users_id');
	}
}
