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
        $aranceles =  DB::select('exec sp_arancelr ?', array(2));
        return response()->json($aranceles);
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;
        $aranceles =  DB::select('exec sp_arancelr ?,?,?', array(1,$hasta,$desde));
        return response()->json($aranceles);
    }

    public function listSearch(Request $request){
        $anio = $request->anio;
        $descripcion = $request->descripcion;
        $listEstado =  DB::select('exec sp_arancelr ?,?,?,?,?,?,?,?,?,?,?,?', array(13,'','','',$anio,null,'','','','','',$descripcion));
        return response()->json($listEstado);
    }

    public function storeDataArancelesRustico(Request $request){

        $user = Auth::user()->per_login;
        $anio = $request->anio;
        $clasificacion = $request->clasificacion;
        $importe = $request->importe;
        $categoria = $request->categoria;
        try {
            DB::beginTransaction();
            DB::statement('exec sp_arancelr ?,?,?,?,?,?,?,?',
            array(7,"","","",$anio,$importe,$categoria,$clasificacion));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }

    public function updateDataArancelesRusticos(Request $request){

        $user = Auth::user()->per_login;
        $anio = $request->anio;
        $importe = $request->importe;
        $categoria = $request->categoria;
        $clasificacion = $request->clasificacion;
        $arancelr_id = $request->arancelr_id;

        try {
            DB::beginTransaction();
            DB::statement('exec sp_arancelr ?,?,?,?,?,?,?,?',
            array(11,"","",$arancelr_id,$anio,$importe,$categoria,$clasificacion));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }

    public function listAniosArancelesRusticos(){
        $arancelesr =  DB::select('exec sp_arancelr ?', array(12));
        return response()->json($arancelesr);
    }


    public function deleteDataArancelesRusticos(Request $request){
        try {
            $codigo = $request->codigo;
            DB::statement('exec sp_arancelr ?,?,?,?,?',
            array(9,"","",$codigo,""));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function editDataArancelesRusticos($id){
        $aranceles =  DB::select('exec sp_arancelr ?,?,?,?', array(8,"","",$id));
        return response()->json($aranceles);
    }

    public function activeDataArancelesRusticos(Request $request){
        try {
            $codigo = $request->codigo;

            DB::statement('exec sp_arancelr ?,?,?,?,?',
            array(14,"","",$codigo,""));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }
}
