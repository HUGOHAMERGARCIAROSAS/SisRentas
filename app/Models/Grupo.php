<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    public $timestamps = false;
    protected $table = 'grupo';
    protected $primaryKey = 'grupo_id';
    protected $fillable = ['gru_nombre','gru_descripcion','gru_orden','gru_activo','gru_icono'];

    public function orderTareas() {
        return $this->hasMany('App\Models\Permission', 'grupo_id', 'grupo_id');
    }
}
 