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
 * 
 * @property Poubelle $poubelle
 *
 * @package App\Models
 */
class Evacuation extends Model
{
	protected $table = 'evacuation';
	public $timestamps = false;

	protected $casts = [
		'poubelle_id' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'date',
		'poubelle_id'
	];

	public function poubelle()
	{
		return $this->belongsTo(Poubelle::class);
	}
}
