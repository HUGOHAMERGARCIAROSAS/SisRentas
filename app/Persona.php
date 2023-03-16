<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $connection = 'dbtramitedoc';
    protected $table = 'persona';
    protected $primaryKey = 'persona_id';
    public $timestamps = false;


    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }
}
