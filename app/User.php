<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserTrait;

class User extends Authenticatable
{
    use Notifiable,UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'usuario';
    protected $primaryKey = 'persona_id';
    public $remember_token = false;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'per_login', 'fecha_creacion','estado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    // public function persona()
    // {
    //     return $this->belongsTo('App\Persona');
    // }

    public function persona()
    {
        return $this->hasOne('App\Persona','persona_id');
    }
}
