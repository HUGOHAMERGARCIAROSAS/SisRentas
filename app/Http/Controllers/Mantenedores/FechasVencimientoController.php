<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class FechasVencimientoController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','mantenedores.fechas_vencimiento.index');
        return view('mantenedores.fechas_vencimiento.index');
    }

    public function totalPages(){
        $aranceles =  DB::select('exec sp_arancel ?', array(2));
        return response()->json($aranceles);
    }

    public function listArancelesTotalJuntas(){
        $todosjuntas =  DB::select('exec sp_arancel ?', array(10));
        return response()->json($todosjuntas);
    }

    public function listFechaVencimientos(){
        $aniohoy = date("Y");
        $fechasvencimientos = DB::select('exec sp_arancel ?,?', array(19,$aniohoy));
        return response()->json($fechasvencimientos);
    }

    public function getListAniosFechasVencimientos(){
        $fechas_anios =  DB::select('select distinct anio from parametro_mes order by anio desc');
        return response()->json($fechas_anios);
    }

    public function listSearch(Request $request){
        $anio = $request->anio;
        $mes = $request->mes;
        $listEstado =  DB::select('exec sp_arancel ?,?,?', array(20,$anio,$mes));
        return response()->json($listEstado);
    }

    public function editDataFechaVencimientos($id){
        $aranceles =  DB::select('exec sp_arancel ?,?', array(22,$id));
        return response()->json($aranceles);
    }


    public function storeDataFechaVencimientos(Request $request){
        //VARIABLES RECIBIDAS
        $user = Auth::user()->per_login;
        $anio = $request->anio;
        $mes = $request->mes;
        $vpredial = $request->vpredial;
        $varbitrios = $request->varbitrios;

        //Fecha Hoy
        $date = Carbon::now();
        $fdate = $date->format('d/m/y');

        //Fecha Predial
        $fvpredial = new Carbon($vpredial);
        $ffvpredial = $fvpredial->format('d/m/y');
        //Fecha Arbitrios
        $fvarbitrios = new Carbon($varbitrios);
        $ffvarbitrios = $fvarbitrios->format('d/m/y');

        try {
            DB::beginTransaction();

            $fechasvencimientos = DB::select('exec sp_arancel ?,?,?', array(21,$anio,$mes));

            if ($fechasvencimientos[0]->valida==0){
                DB::table('parametro_mes')->insert([
                    'tipo' => 2,
                    'mes' => $mes,
                    'anio'=> $anio,
                    'fecha_emision'=>$fdate ,
                    'fecha_vence'=>$ffvarbitrios,
                    'fecha_predial'=>$ffvpredial,
                    'fecha_valida'=>$fdate
                ]);
                DB::commit();
                return response()->json(true);
            }else{
                return response()->json(false);
            }

        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }


    public function updateDataFechaVencimientos(Request $request){

        $user = Auth::user()->per_login;
        $parametro_mes_ID = $request->parametro_mes_ID;
        $vpredial = $request->vpredial;
        $varbitrios = $request->varbitrios;

        //Fecha Hoy
        $date = Carbon::now();
        $fdate = $date->format('d/m/y');

        //Fecha Predial
        $fvpredial = new Carbon($vpredial);
        $ffvpredial = $fvpredial->format('d/m/y');
        //Fecha Arbitrios
        $fvarbitrios = new Carbon($varbitrios);
        $ffvarbitrios = $fvarbitrios->format('d/m/y');

        try {
            DB::beginTransaction();
            DB::table('parametro_mes')
            ->where('parametro_mes_ID',$parametro_mes_ID )
            ->update(['fecha_vence' => $ffvarbitrios,'fecha_predial' => $ffvpredial,'fecha_valida'=>$fdate]);
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }
}
