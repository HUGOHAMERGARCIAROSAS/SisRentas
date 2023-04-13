<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ParametrosController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','mantenedores.parametros.index');
        return view('mantenedores.parametros.index');
    }

    public function listAniosParametros(){
        $parametros =  DB::select('exec sp_parametro ?', array(24));
        return response()->json($parametros);
    }

    public function totalPages(){
        $parametros =  DB::select('exec sp_parametro ?', array(2));
        return response()->json($parametros);
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;
        $parametros =  DB::select('exec sp_parametro ?,?,?', array(1,$hasta,$desde));
        return response()->json($parametros);
    }

    public function listSearch(Request $request){
        $anio = $request->anio;
        $descripcion = $request->descripcion;
        $estado = $request->estado;
        $page = $request->page;

        $pag = $page;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;

        $listEstado =  DB::select('exec sp_parametro ?,?,?,?,?,?,?,?,?', array(25,$hasta,$desde,"","",$anio,$descripcion,"",$estado));
        return response()->json($listEstado);
    }

    public function listSearchTotal(Request $request){
        $anio = $request->anio;
        $descripcion = $request->descripcion;
        $estado = $request->estado;
        $listEstado =  DB::select('exec sp_parametro ?,?,?,?,?,?,?,?,?', array(26,"","","","",$anio,$descripcion,"",$estado));
        return response()->json($listEstado);
    }

    public function storeDataParametros(Request $request){

        $user = Auth::user()->per_login;
        $anio = $request->anio;
        $codigo = $request->codigo;
        $valor = $request->valor;
        $descripcion = $request->descripcion;

        $result =  DB::select('exec sp_parametro ?,?,?,?,?,?', array(27,"","","",$codigo,$anio));
        if($result[0]->total==0){
            try {
                DB::beginTransaction();
                DB::statement('exec sp_parametro ?,?,?,?,?,?,?,?,?,?,?',
                array(7,"","","",$codigo,$anio,$descripcion,"","",$user,$valor));
                DB::commit();
                return response()->json(true);
                }
            catch (\Exception $e) {
                DB::rollBack();
                return response()->json(false);
            }
        }else{
            return response()->json(false);
        }

    }

    public function updateDataParametros(Request $request){

        $user = Auth::user()->per_login;
        $codigo = $request->parametros_id;
        $valor = $request->valor;
        $descripcion = $request->descripcion;
        // try {
            DB::beginTransaction();
            DB::statement('exec sp_parametro ?,?,?,?,?,?,?,?,?,?,?',
                array(8,"","","",$codigo,"",$descripcion,"","","",$valor));
            DB::commit();
            return response()->json(true);
        // }
        // catch (\Exception $e) {
        //     DB::rollBack();
        //     return response()->json(false);
        // }

    }

    public function editDataParametros($id){
        $id =  DB::select('exec sp_parametro ?,?,?,?,?',
        array(10,"","","",$id));
        return response()->json($id);
    }


    public function deleteDataParametros(Request $request){
        try {
            $codigo = $request->codigo;
            DB::statement('exec sp_parametro ?,?,?,?,?',
            array(9,"","","",$codigo));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }



    public function activeDataParametros(Request $request){
        try {
            $codigo = $request->codigo;
            DB::statement('exec sp_parametro ?,?,?,?,?',
            array(28,"","","",$codigo));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }
}
