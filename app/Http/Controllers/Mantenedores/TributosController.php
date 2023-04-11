<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TributosController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','mantenedores.tributos.index');
        return view('mantenedores.tributos.index');
    }

    public function totalPages(){
        $tributos =  DB::select('exec sp_tributo ?,?,?,?,?,?,?,?,?,?,?', array("","",null,"","","","","","","",2));
        return response()->json($tributos);
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;
        $tributos =  DB::select('exec sp_tributo ?,?,?,?,?,?,?,?,?,?,?', array("","",null,"","","","","",$desde,$hasta,1));
        return response()->json($tributos);
    }

    public function listSearch(Request $request){
        $descripcion = $request->descripcion;
        $grupo = $request->grupo;
        $generica = $request->generica;
        $subgenerica = $request->subgenerica;
        $especifica = $request->especifica;
        $area = $request->area;

        $listEstado =  DB::select('exec sp_tributo ?,?,?,?,?,?,?,?,?,?,?,?', array("",$descripcion,null,"","",$grupo,$especifica,"","","",16,$area));
        return response()->json($listEstado);
    }

    public function storeDataTributos(Request $request){

        $user = Auth::user()->per_login;
        $codigo = $request->codigo;
        $abrev = $request->abrev;
        $importe = $request->importe;
        $descripcion = $request->descripcion;
        $codigocontable = $request->codigocontable;
        $area = $request->area;
        $fuente = $request->fuente;
        $area_porc = $request->area_porc;
        $grupo = $request->grupo;
        $especifica = $request->especifica;

        try {
            DB::beginTransaction();
            DB::statement('exec sp_tributo ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
            array("",$descripcion,$importe,1,$abrev,$grupo,$especifica ,$codigocontable,"",$fuente,7,$area,$area_porc,null,$codigo,$user));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }

    public function updateDataTributos(Request $request){

        $user = Auth::user()->per_login;
        $codigo = $request->codigo;
        $abrev = $request->abrev;
        $importe = $request->importe;
        $descripcion = $request->descripcion;
        $codigocontable = $request->codigocontable;
        $area = $request->area;
        $fuente = $request->fuente;
        $area_porc = $request->area_porc;
        $grupo = $request->grupo;
        $especifica = $request->especifica;
        // $tributos_id = $request->tributos_id;

        try {
            DB::beginTransaction();
            DB::statement('exec sp_tributo ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
            array($codigo,$descripcion,$importe,1,$abrev,$grupo,$especifica ,$codigocontable,"",$fuente,8,$area,$area_porc,null,"",$user));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }

    public function editDataTributos($id){
        $id =  DB::select('exec sp_tributo ?,?,?,?,?,?,?,?,?,?,?', array($id,"",null,"","","","","","","",10));
        return response()->json($id);
    }

    public function activeDataTributos(Request $request){
        try {
            $codigo = $request->codigo;
            DB::statement('exec sp_tributo ?,?,?,?,?,?,?,?,?,?,?,',
            array($codigo,"",null,"","","","","","","",16));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function deleteDataTributos(Request $request){
        try {
            $codigo = $request->codigo;
            DB::statement('exec sp_tributo ?,?,?,?,?,?,?,?,?,?,?',
            array($codigo,"",null,"","","","","","","",9));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }
}
