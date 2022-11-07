<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersHasRisque
 * 
 * @property int $users_id
 * @property int $risque_id
 * 
 * @property Risque $risque
 * @property User $user
 *
 * @package App\Models
 */
class UsersHasRisque extends Model
{
    protected $table = 'users_has_risque';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'users_id' => 'int',
        'risque_id' => 'int'
    ];

    protected $fillable = [
        'users_id',
        'risque_id'
    ];


    public function risque()
    {
        return $this->belongsTo(Risque::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
