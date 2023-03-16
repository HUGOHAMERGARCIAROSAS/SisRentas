<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UbigeoController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','mantenedores.ubigeos.index');
        return view('mantenedores.ubigeo.index');
    }

    public function totalPages(){
        $ubigeos =  DB::select('exec sp_ubicacion ?,?,?,?,?,?', array(2,"","","","",""));
        return response()->json($ubigeos);
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;

        $ubigeos =  DB::select('exec sp_ubicacion ?,?,?,?,?,?', array(1,$hasta,$desde,"","",""));
        return response()->json($ubigeos);
    }

    public function listSearch(Request $request){
        $descripcion = $request->descripcion;
        $listEstado =  DB::select('exec sp_ubicacion ?,?,?,?,?,?,?', array(3,'','','','','',$descripcion));
        return response()->json($listEstado);
    }

    public function storeDataUbigeos(Request $request){;
        $codigo = $request->codigo; 
        $descripcion = $request->descripcion;

        $result =  DB::select('exec sp_ubicacion ?,?,?,?,?', array(4,"","","",$codigo));
        if($result[0]->total==0){
            try {
                DB::beginTransaction();
                DB::statement('exec sp_ubicacion ?,?,?,?,?,?,?,?',
                array(5,"","","","",$codigo,$descripcion,""));
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


    public function deleteDataUbigeos(Request $request){
        try {
            $codigo = $request->codigo;
            DB::statement('exec sp_ubicacion ?,?,?,?,?',
            array(6,"","","",$codigo));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function activeDataUbigeos(Request $request){
        try {
            $codigo = $request->codigo;

            DB::statement('exec sp_ubicacion ?,?,?,?,?',
            array(7,"","","",$codigo));
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
