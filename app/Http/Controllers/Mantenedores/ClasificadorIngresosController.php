<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClasificadorIngresosController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','mantenedores.clasificador_ingresos.index');
        return view('mantenedores.clasificador_ingresos.index');
    }

    public function totalPages(){
        $clasificadores =  DB::select('exec sp_clasificador ?', array(2));
        return response()->json($clasificadores);
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;
        $aranceles =  DB::select('exec sp_clasificador ?,?,?', array(1,$hasta,$desde));
        return response()->json($aranceles);
    }

    public function listSearch(Request $request){
        $anio = $request->anio;
        $descripcion = $request->descripcion;
        $estado = $request->estado;
        $listEstado =  DB::select('exec sp_clasificador ?,?,?,?,?', array(22,$anio,'',$descripcion,$estado));
        return response()->json($listEstado);
    }

    public function storeDataClasificadorIngresos(Request $request){

        $user = Auth::user()->per_login;
        $anio = $request->anio;
        $codigo = $request->codigo;
        $codigo_presupuestal = $request->codigo_presupuestal;
        $descripcion = $request->descripcion;

        try {
            DB::beginTransaction();
            DB::statement('exec sp_clasificador ?,?,?,?,?,?,?,?',
            array(7,$anio,"","","",$codigo,$descripcion,$codigo_presupuestal));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }

    public function deleteDataClasificadorIngresos(Request $request){
        try {
            $codigo = $request->codigo;
            DB::statement('exec sp_clasificador ?,?,?,?,?',
            array(9,"","","",$codigo));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function activeDataClasificadorIngresos(Request $request){
        try {
            $codigo = $request->codigo;

            DB::statement('exec sp_clasificador ?,?,?,?,?',
            array(23,"","","",$codigo));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function updateDataClasificadorIngresos(Request $request){

        $user = Auth::user()->per_login;
        $anio = $request->anio;
        $codigo = $request->codigo;
        $codigo_presupuestal = $request->codigo_presupuestal;
        $descripcion = $request->descripcion;
        $contable = transformNull($request->contable);
        $contableant = transformNull($request->contableant);

        try {
            DB::beginTransaction();
            DB::statement('exec sp_clasificador ?,?,?,?,?,?,?,?,?,?',
            array(8,$anio,"","",1,$descripcion,$codigo_presupuestal,$codigo,$contable,$contableant));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }

    public function listAniosClasificadorIngresos(){
        $clasificadorIngresos =  DB::select('exec sp_clasificador ?', array(21));
        return response()->json($clasificadorIngresos);
    }


    public function editDataClasificadorIngresos($id){
        $clasificador =  DB::select('exec sp_clasificador ?,?,?,?', array(5,"","",$id));
        return response()->json($clasificador);
    }

}
