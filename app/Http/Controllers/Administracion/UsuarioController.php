<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UsuarioController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','administracion.usuario.index');
        return view('administracion.usuario.index');
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;
        $usuarios =  DB::select('exec sp_usuario ?,?,?', array(1,$hasta,$desde));
        return response()->json($usuarios);
    }

    public function listSearch(Request $request){
        $nombres = $request->nombres;
        $documento = $request->documento;
        $codigo = $request->codigo;
        $listEstado =  DB::select('exec sp_usuario ?,?,?,?,?,?', array(36,'','',$nombres,$codigo,$documento));
        return response()->json($listEstado);
    }

    public function totalPages(){
        $personas =  DB::select('exec sp_usuario ?', array(2));
        return response()->json($personas);
    }

    public function storeDataUsuario(Request $request){
        $codigo=Auth::user()->persona_id;

        $login = $request->login; 
        $persona_id = $request->persona_id;  
        $password =  bcrypt($request->password);

        try {
            DB::beginTransaction();
            DB::statement('exec sp_usuario ?,?,?,?,?,?,?,?,?,?',
            array(7,"","","",$persona_id,"","","",$login,$password));
            DB::commit();
            return response()->json(true);
            }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }



    public function deleteDataUsuario(Request $request){
        try {
            $persona_id=$request->persona_id;

            DB::statement('exec sp_usuario ?,?,?,?,?',
            array(38,"","","",$persona_id));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function activeDataUsuario(Request $request){
        try {
            $persona_id=$request->persona_id;

            DB::statement('exec sp_usuario ?,?,?,?,?',
            array(39,"","","",$persona_id));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function editDataUsuario($id){
        $usuario =  DB::select('exec sp_usuario ?,?,?,?,?', array(40,"","","",$id));
        return response()->json($usuario);
    }

    public function updateDataUsuario(Request $request){
        
        $login = $request->login;
        $persona_id = $request->persona_id;

        try {
            DB::beginTransaction();
            DB::statement('exec sp_usuario ?,?,?,?,?,?,?,?,?,?',
            array(41,"","","",$persona_id,"","","",$login,""));
            DB::commit();
            return response()->json(true);
            }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }


    public function updateDataRolesUsuario(Request $request){
        $rol_id = $request->rol_id;
        $persona_ID = $request->persona_id;

        try {
            DB::beginTransaction();
            DB::statement('exec sp_usuario ?,?,?,?,?,?,?,?,?,?',
            array(44,"","","",$persona_ID,"","","",$rol_id,""));
            DB::commit();
            return response()->json(true);
            }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function editDataUsuarioPassword($id){
        $usuario =  DB::select('exec sp_usuario ?,?,?,?,?', array(42,"","","",$id));
        return response()->json($usuario);
    }

    public function updateDataUsuarioPassword(Request $request){
        
        $password = bcrypt($request->password);
        $persona_id = $request->persona_id;

        try {
            DB::beginTransaction();
            DB::statement('exec sp_usuario ?,?,?,?,?',
            array(43,"","",$password,$persona_id));
            DB::commit();
            return response()->json(true);
            }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }
}
