<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Paiement
 * 
 * @property int $id
 * @property int $poubelle_id
 * @property Carbon|null $date
 * @property float|null $montant
 * @property string|null $devise
 * @property string|null $niveau
 * 
 * @property Poubelle $poubelle
 *
 * @package App\Models
 */
class Paiement extends Model
{
	protected $table = 'paiement';
	public $timestamps = false;

	protected $casts = [
		'poubelle_id' => 'int',
		'montant' => 'float'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'poubelle_id',
		'date',
		'montant',
		'devise',
		'niveau'
	];

	public function poubelle()
	{
		return $this->belongsTo(Poubelle::class);
	}
}
