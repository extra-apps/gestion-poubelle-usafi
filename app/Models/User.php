<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $telephone
 * @property string|null $user_role
 * @property int|null $mustpay
 *
 * @property Collection|Evacuateur[] $evacuateurs
 * @property Collection|Evacuation[] $evacuations
 * @property Collection|Poubelle[] $poubelles
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $casts = [
        'mustpay' => 'int'
    ];

    protected $dates = [
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'telephone',
        'user_role',
        'mustpay'
    ];

    public function evacuateurs()
    {
        return $this->hasMany(Evacuateur::class, 'users_id');
    }

    public function evacuations()
    {
        return $this->hasMany(Evacuation::class, 'users_id');
    }

    public function poubelles()
    {
        return $this->hasMany(Poubelle::class, 'users_id');
    }
}
