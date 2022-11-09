<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Poubelle
 * 
 * @property int $id
 * @property int $users_id
 * @property string|null $taille
 * @property string|null $niveau
 * @property int|null $etat
 * @property string|null $cap1
 * @property string|null $cap2
 * @property string|null $cap3
 * @property Carbon|null $dateajout
 * 
 * @property User $user
 * @property Collection|Evacuateur[] $evacuateurs
 * @property Collection|Evacuation[] $evacuations
 * @property Collection|Paiement[] $paiements
 *
 * @package App\Models
 */
class Poubelle extends Model
{
	protected $table = 'poubelle';
	public $timestamps = false;

	protected $casts = [
		'users_id' => 'int',
		'etat' => 'int'
	];

	protected $dates = [
		'dateajout'
	];

	protected $fillable = [
		'users_id',
		'taille',
		'niveau',
		'etat',
		'cap1',
		'cap2',
		'cap3',
		'dateajout'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'users_id');
	}

	public function evacuateurs()
	{
		return $this->hasMany(Evacuateur::class);
	}

	public function evacuations()
	{
		return $this->hasMany(Evacuation::class);
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class);
	}
}
