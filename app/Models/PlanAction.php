<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlanAction
 * 
 * @property int $id
 * @property string|null $codeplan
 * @property string|null $priorite
 * @property string|null $sujetaction
 * @property string|null $description
 * @property Carbon|null $dateaction
 * @property string|null $statusaction
 * @property Carbon|null $dateplanfin
 * @property string|null $actionsuivant
 * @property string|null $typeaction
 * @property Carbon|null $datereelfin
 * @property int $risque_id
 * @property Carbon|null $dateajout
 * 
 * @property Risque $risque
 *
 * @package App\Models
 */
class PlanAction extends Model
{
	protected $table = 'plan_action';
	public $timestamps = false;

	protected $casts = [
		'risque_id' => 'int'
	];

	protected $dates = [
		'dateaction',
		'dateplanfin',
		'datereelfin',
		'dateajout'
	];

	protected $fillable = [
		'codeplan',
		'priorite',
		'sujetaction',
		'description',
		'dateaction',
		'statusaction',
		'dateplanfin',
		'actionsuivant',
		'typeaction',
		'datereelfin',
		'risque_id',
		'dateajout'
	];

	public function risque()
	{
		return $this->belongsTo(Risque::class);
	}
}
