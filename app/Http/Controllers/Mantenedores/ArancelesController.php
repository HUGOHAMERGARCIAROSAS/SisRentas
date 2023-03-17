<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArancelesController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','mantenedores.aranceles.index');
        return view('mantenedores.aranceles.index');
    }

    public function totalPages(){
        $aranceles =  DB::select('exec sp_arancel ?', array(2));
        return response()->json($aranceles);
    }

    public function listArancelesTotalJuntas(){
        $todosjuntas =  DB::select('exec sp_ubicacion ?', array(10));
        return response()->json($todosjuntas);
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;
        $aranceles =  DB::select('exec sp_arancel ?,?,?', array(1,$hasta,$desde));
        return response()->json($aranceles);
    }

    public function listSearch(Request $request){
        $anio = $request->anio;
        $descripcion = $request->descripcion;
        $junta = $request->junta;
        $listEstado =  DB::select('exec sp_arancel ?,?,?,?,?,?,?,?,?,?,?,?', array(17,'','','',$anio,null,'','','','',$junta,$descripcion));
        return response()->json($listEstado);
    }

    public function storeDataAranceles(Request $request){

        $user = Auth::user()->per_login;
        $anio = $request->anio;
        $numero = $request->numero;
        $importe = $request->importe;
        $cuadra = $request->cuadra;
        $lado = $request->lado;
        $junta_via = $request->junta_via;

        try {
            DB::beginTransaction();
            DB::statement('exec sp_arancel ?,?,?,?,?,?,?,?,?,?,?',
            array(7,"","","",$anio,$importe,$numero,$junta_via,$cuadra,$lado,$user));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }

    public function updateDataAranceles(Request $request){

        $user = Auth::user()->per_login;
        $anio = $request->anio;
        $numero = $request->numero;
        $importe = $request->importe;
        $cuadra = $request->cuadra;
        $lado = $request->lado;
        $junta_via = $request->junta_via;
        $arancel_id = $request->arancel_id;

        try {
            DB::beginTransaction();
            DB::statement('exec sp_arancel ?,?,?,?,?,?,?,?,?,?,?',
            array(11,"","",$arancel_id,"",$importe,$numero,$junta_via,$cuadra,$lado,$user));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }

    public function listAniosAranceles(){
        $aranceles =  DB::select('exec sp_arancel ?', array(15));
        return response()->json($aranceles);
    }


    public function deleteDataAranceles(Request $request){
        try {
            $codigo = $request->codigo;
            DB::statement('exec sp_arancel ?,?,?,?,?',
            array(9,"","",$codigo,""));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function editDataAranceles($id){
        $aranceles =  DB::select('exec sp_arancel ?,?,?,?', array(8,"","",$id));
        return response()->json($aranceles);
    }

    public function activeDataAranceles(Request $request){
        try {
            $codigo = $request->codigo;

            DB::statement('exec sp_arancel ?,?,?,?,?',
            array(18,"","",$codigo,""));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function updateDataUbigeos(Request $request){
        $codigo = $request->codigo;
        $descripcion = $request->descripcion;
        try {
            DB::beginTransaction();
            DB::statement('exec sp_ubicacion ?,?,?,?,?,?,?',
            array(8,"","","",$codigo,"",$descripcion));
            DB::commit();
            return response()->json(true);
            }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function editDataUbigeos($id){
        $ubigeos =  DB::select('exec sp_ubicacion ?,?,?,?,?,?,?', array(9,"","","",$id,"",""));
        return response()->json($ubigeos);
    }
}
