<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commentaire
 * 
 * @property int $id
 * @property string|null $sujet
 * @property string|null $commentaire
 * @property int $users_id
 * @property Carbon|null $date
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Commentaire extends Model
{
	protected $table = 'commentaire';
	public $timestamps = false;

	protected $casts = [
		'users_id' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'sujet',
		'commentaire',
		'users_id',
		'date'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id');
	}
}
