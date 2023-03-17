<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FechasVencimientoController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','mantenedores.fechas_vencimiento.index');
        return view('mantenedores.fechas_vencimiento.index');
    }
}
