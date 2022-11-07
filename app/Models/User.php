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
 * @property string|null $fonction
 * @property string|null $role1
 * @property string|null $service
 * @property string|null $observation
 *
 * @property Collection|Projet[] $projets
 * @property Collection|Risque[] $risques
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

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
        'fonction',
        'role1',
        'service',
        'observation'
    ];

    public function projets()
    {
        return $this->hasMany(Projet::class, 'users_id');
    }

    public function risques()
    {
        return $this->belongsToMany(Risque::class, 'users_has_risque', 'users_id');
    }
}
