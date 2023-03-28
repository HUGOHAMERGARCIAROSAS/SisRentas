<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CombosController extends Controller
{
    // COMBO DE MESES
    public function meses(){
        $meses =  DB::select('exec sp_combos ?', array(1));
        return response()->json($meses);
    }

    // COMBO DE MESES
    public function mesesTodos(){
        $meses =  DB::select('exec sp_combos ?', array(2));
        return response()->json($meses);
    }
}
