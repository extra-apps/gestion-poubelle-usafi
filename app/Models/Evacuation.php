<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Evacuation
 * 
 * @property int $id
 * @property Carbon|null $date
 * @property int $poubelle_id
 * @property int $users_id
 * 
 * @property Poubelle $poubelle
 * @property User $user
 *
 * @package App\Models
 */
class Evacuation extends Model
{
	protected $table = 'evacuation';
	public $timestamps = false;

	protected $casts = [
		'poubelle_id' => 'int',
		'users_id' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'date',
		'poubelle_id',
		'users_id'
	];

	public function poubelle()
	{
		return $this->belongsTo(Poubelle::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id');
	}
}
