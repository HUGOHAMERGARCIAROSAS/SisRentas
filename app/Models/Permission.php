<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;
    protected $table = 'tarea';
    protected $primaryKey = 'tarea_id';
    protected $fillable = ['tar_nombre','tar_descripcion','tar_url','tar_activo','grupo_id','menu'];


    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }
}
