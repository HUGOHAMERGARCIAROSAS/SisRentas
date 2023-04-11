<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Grupo;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','administracion.roles.index');
        return view('administracion.roles.index');
    }

    public function totalPages(){
        $roles =  DB::select('exec sp_roles ?,?,?,?,?,?,?', array("","","","","","",2));
        return response()->json($roles);
    }

    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;

        $roles =  DB::select('exec sp_roles ?,?,?,?,?,?,?', array("","","","",$desde,$hasta,1));
        return response()->json($roles);
    }

    public function totalPermissions(Request $request){
        $codigo=Auth::user()->persona_id;
        $permissions =  DB::select('exec sp_roles ?,?,?,?,?,?,?', array("","","","","","",23));
        return response()->json($permissions);
    }
    public function totalPermissionsUsuario(Request $request){
        $codigo=Auth::user()->persona_id;
        $permissions =  DB::select('exec sp_roles ?,?,?,?,?,?,?', array("",$codigo,"","","","",22));
        return response()->json($permissions);
    }

    public function storeDataRoles(Request $request){;
        $rol_nombre = trim($request->rol_nombre);
        $rol_descripcion = $request->rol_descripcion;

        $result =  DB::select('exec sp_roles ?,?,?,?,?,?,?', array("",$rol_nombre,"","","","",14));
        if($result[0]->total==0){
            try {
                DB::beginTransaction();
                DB::statement('exec sp_roles ?,?,?,?,?,?,?,?,?',
                array("",$rol_nombre,$rol_descripcion,"","","",7,"",""));
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

    public function deleteDataRoles(Request $request){
        try {
            $rol_id = $request->rol_id;
            DB::statement('exec sp_roles ?,?,?,?,?,?,?',
            array($rol_id,"","","","","",9));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function activeDataRoles(Request $request){
        try {
            $rol_id = $request->rol_id;

            DB::statement('exec sp_roles ?,?,?,?,?,?,?',
            array($rol_id,"","","","","",12));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function editDataRoles($id){
        $usuario =  DB::select('exec sp_roles ?,?,?,?,?,?,?', array($id,"","","","","",10));
        return response()->json($usuario);
    }

    public function pruebaPrueba(){
        $usuario = Grupo::whereHas('orderTareas', function($q) {
            $q->where('gru_activo','=','1');
        })->with(['orderTareas' => function($q) {
            $q->where('tar_activo','=','1');
        }])->get();

        return response()->json($usuario);
    }

    public function updateDataRoles(Request $request){

        $rol_id = $request->rol_id;
        $rol_nombre = trim($request->rol_nombre);
        $rol_descripcion = $request->rol_descripcion;

        $result =  DB::select('exec sp_roles ?,?,?,?,?,?,?', array($rol_id,$rol_nombre,"","","","",15));
        if($result[0]->total==0){
            try {
                DB::beginTransaction();
                DB::statement('exec sp_roles ?,?,?,?,?,?,?,?,?',
                array($rol_id,$rol_nombre,$rol_descripcion,"","","",8,"",""));
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

    public function validateDataRolesUsuario($id,$persona_id){
        $usuario =  DB::select('exec sp_roles ?,?,?,?,?,?,?,?,?', array($id,"","","","","",26,"",$persona_id));
        return response()->json($usuario);
    }

    public function editDataRolesUsuario($id){
        $usuario =  DB::select('exec sp_usuario ?,?,?,?,?', array(45,"","","",$id));
        return response()->json($usuario);
    }

    public function deleteDataRolesUsuario(Request $request){
        try {
            $id = $request->urol_id;
            DB::statement('exec sp_roles ?,?,?,?,?,?,?', array($id,"","","","","",24));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function activeDataRolesUsuario(Request $request){
        try {
            $id = $request->urol_id;
            DB::statement('exec sp_roles ?,?,?,?,?,?,?', array($id,"","","","","",25));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }


    public function listSearch(Request $request){
        $rol_nombre = $request->rol_nombre;
        $listEstado =  DB::select('exec sp_roles ?,?,?,?,?,?,?', array('',$rol_nombre,'','','','',13));
        return response()->json($listEstado);
    }
    public function getGruposPermisosByGrupos(){
        $usuario = Grupo::whereHas('orderTareas', function($q) {
            $q->where('gru_activo','=','1');
        })->with(['orderTareas' => function($q) {
            $q->where('tar_activo','=','1');
        }])->get();

        return response()->json($usuario);
    }
    public function listaPermisosRolesList($id){
        $listEstado =  DB::select('exec sp_roles ?,?,?,?,?,?,?', array($id,'','','','','',28));
        return response()->json($listEstado);
    }
    public function listaPermisosRolesTitulo($id){
        $listEstado =  DB::select('exec sp_roles ?,?,?,?,?,?,?', array($id,'','','','','',29));
        return response()->json($listEstado);
    }
    public function updateRolesPermisosActual(Request $request){
        try {
            DB::beginTransaction();
            DB::statement('exec sp_roles ?,?,?,?,?,?,?',
            array($request->rol_id,"","","","","",30));
            DB::commit();
            foreach ($request->seleccionados as $item) {
                DB::beginTransaction();
                DB::statement('exec sp_roles ?,?,?,?,?,?,?,?,?',
                array($request->rol_id,"","","","","",31,"",$item));
                DB::commit();
            }
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }
    public function asignaPermisoRoles(){
        Gate::authorize('haveaccess','administracion.permisosrol.roles');
        return view('administracion.roles.asignar');
    }
    public function updateDataAsignarRoles(Request $request, $id){
        try {
            DB::beginTransaction();
            DB::statement('exec sp_roles ?,?,?,?,?,?,?',
            array($id,"","","","","",19));
            DB::commit();

                for ($i=0; $i < count($request->permission); $i++) {
                    DB::beginTransaction();
                    DB::statement('exec sp_roles ?,?,?,?,?,?,?',
                    array($id,"","","","",$request->permission[$i],18));
                    DB::commit();
                }
                return redirect()->route('administracion.roles.index');
            }
            catch (\Exception $e) {
                return redirect()->back()->with('error','Seleccione un permiso para este rol.');
            }

    }
}







