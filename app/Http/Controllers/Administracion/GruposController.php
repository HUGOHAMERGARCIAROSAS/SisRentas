<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GruposController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','administracion.grupos.index');
        return view('administracion.grupos.index');
    }

    public function totalPages(){
        $roles =  DB::select('exec sp_grupo ?,?,?,?,?,?,?,?,?', array("","","","","","","","",2));
        return response()->json($roles);
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;

        $roles =  DB::select('exec sp_grupo ?,?,?,?,?,?,?,?,?', array("","","","","","",$desde,$hasta,1));
        return response()->json($roles);
    }

    public function storeDataGrupos(Request $request){;
        $gru_nombre = trim($request->gru_nombre); 
        $gru_descripcion = $request->gru_descripcion;
        $gru_icono = $request->gru_icono;
        $gru_orden = $request->gru_orden;

        $result =  DB::select('exec sp_grupo ?,?,?,?,?,?,?,?,?', array("",$gru_nombre,"","","","","","",18));
        if($result[0]->total==0){
            try {
                DB::beginTransaction();
                DB::statement('exec sp_grupo ?,?,?,?,?,?,?,?,?,?',
                array("",$gru_nombre,$gru_descripcion,$gru_icono,$gru_orden,"","","",7,""));
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

    public function deleteDataGrupos(Request $request){
        try {
            $gru_id = $request->gru_id;
            DB::statement('exec sp_grupo ?,?,?,?,?,?,?,?,?',
            array($gru_id,"","","","","","","",9));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function activeDataGrupos(Request $request){
        try {
            $gru_id = $request->gru_id;

            DB::statement('exec sp_grupo ?,?,?,?,?,?,?,?,?',
            array($gru_id,"","","","","","","",17));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function editDataGrupos($id){
        $grupos =  DB::select('exec sp_grupo ?,?,?,?,?,?,?,?,?', array($id,"","","","","","","",11));
        return response()->json($grupos);
    }

    public function updateDataGrupos(Request $request){

        $grupo_id = $request->grupo_id;
        $gru_nombre = trim($request->gru_nombre);
        $gru_descripcion = $request->gru_descripcion;
        $gru_icono = trim($request->gru_icono);
        $gru_orden = trim($request->gru_orden);
        
        $result =  DB::select('exec sp_grupo ?,?,?,?,?,?,?,?,?', array($grupo_id,$gru_nombre,"","","","","","",19));
        
        if($result[0]->total==0){
            try {
                DB::beginTransaction();
                DB::statement('exec sp_grupo ?,?,?,?,?,?,?,?,?',
                array($grupo_id,$gru_nombre,$gru_descripcion,$gru_icono,$gru_orden,"","","",15));
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

    public function listSearch(Request $request){
        $gru_nombre = $request->gru_nombre;
        $listEstado =  DB::select('exec sp_grupo ?,?,?,?,?,?,?,?,?', array('',$gru_nombre,'','','','','','',13));
        return response()->json($listEstado);
    }

    public function listGruposPermisos(){
        $roles =  DB::select('exec sp_grupo ?,?,?,?,?,?,?,?,?', array("","","","","","","","",20));
        return response()->json($roles);
    }
}
