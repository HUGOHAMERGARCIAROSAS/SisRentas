<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function index(){
        return view('mantenedores.caja.index');
    }

    public function getCajaTotalPage(){
        $caja =  DB::select('exec sp_caja ?', array(2));
        return response()->json($caja);
    }
    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;

        $cajas =  DB::select('exec sp_caja ?,?,?', array(1,$hasta,$desde));
        return response()->json($cajas);
    }


}
