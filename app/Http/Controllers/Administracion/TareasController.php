<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
class TareasController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','administracion.tareas.index');
        return view('administracion.tareas.index');
    }

    public function totalPages(){
        $roles =  DB::select('exec sp_tarea ?,?,?,?,?,?,?,?,?,?,?', array("","","","","","","","","","",2));
        return response()->json($roles);
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;

        $tareas =  DB::select('exec sp_tarea ?,?,?,?,?,?,?,?,?,?,?', array("","","","","","","","",$desde,$hasta,1));
        return response()->json($tareas);
    }

    public function storeDataTareas(Request $request){;
        $tar_nombre = $request->tar_nombre; 
        $tar_descripcion = $request->tar_descripcion;
        $tar_url = $request->tar_url;
        $tar_icono = $request->tar_icono;
        $tar_orden = $request->tar_orden;
        $grupo_id = $request->grupo_id;
        if($request->tar_menu==true){$tar_menu=1;}else{$tar_menu=2;}

        $result =  DB::select('exec sp_tarea ?,?,?,?,?,?,?,?,?,?,?', array("",$grupo_id,$tar_nombre,"","","","","","","",16));
        if($result[0]->total==0){
            try {
                DB::beginTransaction();
                DB::statement('exec sp_tarea ?,?,?,?,?,?,?,?,?,?,?',
                array("",$grupo_id,$tar_nombre,$tar_descripcion,$tar_icono,$tar_orden,$tar_url,"",$tar_menu,"",7));
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

    public function deleteDataTareas(Request $request){
        try {
            $tarea_id = $request->tarea_id;
            DB::statement('exec sp_tarea ?,?,?,?,?,?,?,?,?,?,?',
            array($tarea_id,"","","","","","","","","",9));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function activeDataTareas(Request $request){
        try {
            $tarea_id = $request->tarea_id;

            DB::statement('exec sp_tarea ?,?,?,?,?,?,?,?,?,?,?',
            array($tarea_id,"","","","","","","","","",15));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function editDataTareas($id){
        $grupos =  DB::select('exec sp_tarea ?,?,?,?,?,?,?,?,?,?,?', array($id,"","","","","","","","","",10));
        return response()->json($grupos);
    }

    public function updateDataTareas(Request $request){

        $tar_nombre = $request->tar_nombre; 
        $tar_descripcion = $request->tar_descripcion;
        $tar_url = $request->tar_url;
        
        $tar_orden = transformNull($request->tar_orden);
        $grupo_id = $request->grupo_id;
        $tarea_id = $request->tarea_id;

        if($request->tar_menu=='true'){$tar_menu=1;}else{$tar_menu=0;}

        $result =  DB::select('exec sp_tarea ?,?,?,?,?,?,?,?,?,?,?', array("",$grupo_id,$tar_nombre,"","","","","","","",17));
        if($result[0]->total==0){
            try {
                    DB::beginTransaction();
                    DB::statement('exec sp_tarea ?,?,?,?,?,?,?,?,?,?,?',
                    array($tarea_id,$grupo_id,$tar_nombre,$tar_descripcion,"",$tar_orden,$tar_url,"",$tar_menu,"",8));
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
        $tar_nombre = $request->tar_nombre;
        $listEstado =  DB::select('exec sp_tarea ?,?,?,?,?,?,?,?,?,?,?', array('','',$tar_nombre,'','','','','','','',13));
        return response()->json($listEstado);
    }
}
