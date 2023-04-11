<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IpmReajusteController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','mantenedores.ipm_reajuste.index');
        return view('mantenedores.ipm_reajuste.index');
    }

    public function listAniosIpmReajuste(){
        $ipm_reajuste =  DB::select('exec sp_ipmreajuste ?', array(12));
        return response()->json($ipm_reajuste);
    }

    public function totalPages(){
        $ipm_reajuste =  DB::select('exec sp_ipmreajuste ?', array(2));
        return response()->json($ipm_reajuste);
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;
        $tributos =  DB::select('exec sp_ipmreajuste ?,?,?', array(1,$hasta,$desde));
        return response()->json($tributos);
    }

    public function listSearch(Request $request){
        $anio = $request->anio;

        $listEstado =  DB::select('exec sp_ipmreajuste ?,?', array(13,$anio));
        return response()->json($listEstado);
    }

    public function storeDataIpmReajuste(Request $request){

        $user = Auth::user()->per_login;
        $anio = $request->anio;
        $mes = $request->mes;
        $mensual = $request->mensual;
        $acumulado = $request->acumulado;

        $result =  DB::select('exec sp_ipmreajuste ?,?,?,?,?,?,?,?', array(14,$anio,$mes,"","",null,$acumulado,$mensual));
        if($result[0]->total==0){
            try {
                DB::beginTransaction();
                DB::statement('exec sp_ipmreajuste ?,?,?,?,?,?,?,?',
                array(7,$anio,$mes,"","",null,$acumulado,$mensual));
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

    public function updateDataIpmReajuste(Request $request){

        $user = Auth::user()->per_login;
        $idipm = $request->idipm;
        $mensual = $request->mensual;
        $acumulado = $request->acumulado;
        try {
            DB::beginTransaction();
            DB::statement('exec sp_ipmreajuste ?,?,?,?,?,?,?,?',
            array(11,"","",$idipm,"",null,$acumulado,$mensual));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }

    public function editDataIpmReajuste($id){
        $id =  DB::select('exec sp_ipmreajuste ?,?,?,?',
        array(8,"","",$id));
        return response()->json($id);
    }


}
