<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $table = 'roles';
    protected $primaryKey = 'rol_id';
    protected $fillable = ['rol_nombre','rol_descripcion','rol_activo'];


    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function permissions(){
        return $this->belongsToMany('App\Models\Permission');
    }
}
