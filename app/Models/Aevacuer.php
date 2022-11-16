<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Aevacuer
 * 
 * @property int $id
 * @property int $poubelle_id
 * @property Carbon|null $date_plein
 * 
 * @property Poubelle $poubelle
 *
 * @package App\Models
 */
class Aevacuer extends Model
{
	protected $table = 'aevacuer';
	public $timestamps = false;

	protected $casts = [
		'poubelle_id' => 'int'
	];

	protected $dates = [
		'date_plein'
	];

	protected $fillable = [
		'poubelle_id',
		'date_plein'
	];

	public function poubelle()
	{
		return $this->belongsTo(Poubelle::class);
	}
}
