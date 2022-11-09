<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Config
 * 
 * @property int $id
 * @property string|null $config
 *
 * @package App\Models
 */
class Config extends Model
{
	protected $table = 'config';
	public $timestamps = false;

	protected $fillable = [
		'config'
	];
}
