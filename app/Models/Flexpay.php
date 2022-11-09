<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Flexpay
 * 
 * @property int $id
 * @property string|null $user
 * @property string|null $cb_code
 * @property string|null $ref
 * @property string|null $pay_data
 * @property int|null $is_saved
 * @property int|null $callback
 * @property int|null $transaction_was_failled
 * @property Carbon|null $date
 *
 * @package App\Models
 */
class Flexpay extends Model
{
	protected $table = 'flexpay';
	public $timestamps = false;

	protected $casts = [
		'is_saved' => 'int',
		'callback' => 'int',
		'transaction_was_failled' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'user',
		'cb_code',
		'ref',
		'pay_data',
		'is_saved',
		'callback',
		'transaction_was_failled',
		'date'
	];
}
