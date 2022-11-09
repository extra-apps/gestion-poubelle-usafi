<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Evacuateur
 * 
 * @property int $id
 * @property int $poubelle_id
 * @property int $users_id
 * 
 * @property Poubelle $poubelle
 * @property User $user
 *
 * @package App\Models
 */
class Evacuateur extends Model
{
	protected $table = 'evacuateur';
	public $timestamps = false;

	protected $casts = [
		'poubelle_id' => 'int',
		'users_id' => 'int'
	];

	protected $fillable = [
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
