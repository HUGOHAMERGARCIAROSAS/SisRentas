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

    //CLASIFICACION DE ARANCELES RUSTICOS
    public function clasificacionArancelRustico(){
        $clasificacionarancelesrusticos =  DB::select('exec sp_combos ?', array(3));
        return response()->json($clasificacionarancelesrusticos);
    }

    //CATEGORIA DE ARANCELES RUSTICOS
    public function categoriaArancelRustico(){
        $categoriaarancelesrusticos =  DB::select('exec sp_combos ?', array(4));
        return response()->json($categoriaarancelesrusticos);
    }

     //TIPO TRIBUTOS
     public function listGrupoTributos(){
        $grupotributos =  DB::select('exec sp_combos ?', array(5));
        return response()->json($grupotributos);
    }

     //GENERICA - TRIBUTOS
     public function lisGenericoTributos(){
        $genericotributos =  DB::select('exec sp_combos ?', array(6));
        return response()->json($genericotributos);
    }

     //SUB GENERICA - TRIBUTOS
     public function listSubgenericosTributos($id){
        $subgenericostributos =  DB::select('exec sp_combos ?,?', array(7,$id));
        return response()->json($subgenericostributos);
    }

     //ESPECIFICAS
     public function listEspecificaTributos($id){
        $especificatributos =  DB::select('exec sp_combos ?,?', array(8,$id));
        return response()->json($especificatributos);
    }

     //AREAS
     public function listAreaTributos(){
        $areatributos =  DB::select('exec sp_combos ?', array(9));
        return response()->json($areatributos);
    }

    // FUENTES DE FINANCIAMIENTO

    public function listFuentesTributos(){
        $fuentesfinanciamiento =  DB::select('exec sp_combos ?', array(10));
        return response()->json($fuentesfinanciamiento);
    }

}
