<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DB;
use Illuminate\Support\Facades\Gate;

class PersonaController extends Controller
{
    public function index(){
        Gate::authorize('haveaccess','administracion.persona.index');
        return view('administracion.persona.index');
    }
 
    public function list($id){
        $pag = $id;
        $hasta=10;
        $desde = ($hasta*$pag)-$hasta;
        $personas =  DB::select('exec sp_persona ?,?,?', array(1,$hasta,$desde));
        return response()->json($personas);

    }

    public function totalPages(){
        $personas =  DB::select('exec sp_persona ?', array(3));
        return response()->json($personas);
    }

    public function listSearch(Request $request){
        $nombres = $request->nombres;
        $documento = $request->documento;
        $codigo = $request->codigo;
        $listEstado =  DB::select('exec sp_persona ?,?,?,?,?,?,?,?,?', array(27,'','',$nombres,$codigo,'','','',$documento));
        return response()->json($listEstado);
    }

    public function tipoPersona(){
        $tipopersona =  DB::select('exec sp_persona ?', array(28));
        return response()->json($tipopersona);
    }

    public function tipoDocumento(){
        $tipodocumento =  DB::select('exec sp_persona ?', array(29));
        return response()->json($tipodocumento);
    }

    public function tipoGrupo(){
        $tipodocumento =  DB::select('exec sp_persona ?', array(45));
        return response()->json($tipodocumento);
    }

    public function tipoLados(){
        $tipodocumento =  DB::select('exec sp_arancel ?', array(14));
        return response()->json($tipodocumento);
    }

    public function tipoJuntas(){
        $tipodocumento =  DB::select('exec sp_arancel ?', array(10));
        return response()->json($tipodocumento);
    }

    public function tipoDepartamento(){
        $tipodepartamento =  DB::select('exec sp_persona ?', array(30));
        return response()->json($tipodepartamento);
    }

    public function tipoProvincia($id){
        $tipoprovincia =  DB::select('exec sp_persona ?,?,?,?', array(31,'','',$id));
        return response()->json($tipoprovincia); 
    }

    public function tipoDistrito($id){
        $tipodistrito =  DB::select('exec sp_persona ?,?,?,?', array(32,'','',$id));
        return response()->json($tipodistrito); 
    }

    public function tipoJunta($id){
        $tipojunta =  DB::select('exec sp_persona ?,?,?,?', array(33,'','',$id));
        return response()->json($tipojunta); 
    }

    public function tipoCalle($id){
        $tipocalle =  DB::select('exec sp_persona ?,?,?,?', array(34,'','',$id));
        return response()->json($tipocalle); 
    }

    public function tipoSexo(){
        $tiposexo =  DB::select('exec sp_persona ?', array(35));
        return response()->json($tiposexo); 
    }

    public function tipoAreas(){
        $tiposareas =  DB::select('exec sp_persona ?', array(42));
        return response()->json($tiposareas); 
    }

    public function tipoRoles(Request $request){
        $nombres = $request->text;
        $listEstado =  DB::select('exec sp_persona ?,?,?,?', array(44,'','',$nombres));
        return response()->json($listEstado);

    }

    public function storeDataPersona(Request $request){
        $codigo=Auth::user()->persona_id;
        $user_insert=Auth::user()->per_login;

        $tipo_persona = $request->tipo_persona; 
        $ape_paterno = $request->ape_paterno;  
        $ape_materno = transformNull($request->ape_materno);
        $nombres = transformNull($request->nombres);
        $tipo_doc = $request->tipo_doc; 
        $num_doc = $request->num_doc; 
        $sexo = $request->sexo; 
        $calle = $request->calle; 
        
        $ff_registro = new DateTime($request->fecha_registro);
        $ffecha_registro= $ff_registro->format('d/m/Y H:i:s');
        $ff_nac = new DateTime($request->fecha_nac);
        $ffecha_nac= $ff_nac->format('m/d/Y H:i:s');

        $n_via = $request->n_via; 
        $interior = $request->interior;
        $mz = $request->mz;
        $lote = $request->lote;
        $edificio = $request->edificio;
        $piso = $request->piso;
        $dpto = $request->dpto;
        $tienda = $request->tienda;
        $fono_domicilio = $request->fono_domicilio;
        $direccion_completa = $request->direccion_completa;
        $fono_oficina = $request->fono_oficina;
        $celular = $request->celular;
        $email = $request->email;

        try {
            DB::beginTransaction();
            DB::statement('exec sp_persona ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? ,?,?,?,?,?,?,?,?,?,?',
            array(37,"","","","",$ape_paterno,$ape_materno,$nombres,$num_doc,$user_insert,$num_doc,$calle,$tipo_doc,$ffecha_nac,
            $sexo,$tipo_persona,$n_via,$interior,$mz,$lote,$piso,$edificio,$dpto,$tienda,$fono_domicilio,$fono_oficina,$celular,
            $email,"",$direccion_completa));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json(false);
        }

    }

    public function validacionPersona($id){
        $validacion =  DB::select('exec sp_persona ?,?,?,?,?', array(36,'','','',$id));
        return response()->json($validacion); 
    }

    public function deleteDataPersona(Request $request){
        try {
            $persona_id=$request->persona_id;

            DB::statement('exec sp_persona ?,?,?,?,?',
            array(38,"","","",$persona_id));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function activeDataPersona(Request $request){
        try {
            $persona_id=$request->persona_id;

            DB::statement('exec sp_persona ?,?,?,?,?',
            array(39,"","","",$persona_id));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function editDataPersona($id){
        $persona =  DB::select('exec sp_persona ?,?,?,?,?', array(40,"","","",$id));
        return response()->json($persona);
    }

    public function ValidateDniDataPersona($id){
        $persona =  DB::select('exec sp_persona ?,?,?,?', array(46,"","",$id));
        return response()->json($persona);
    }

    public function tipoExpediente(){
        $expediente =  DB::select('exec sp_persona ?', array(44));
        return response()->json($expediente);
    }

    public function updateDataPersona(Request $request){
        $codigo=Auth::user()->persona_id;
        $user_update=Auth::user()->per_login;
        $persona_id =transformNull($request->persona_id); 
        $tipo_persona = transformNull($request->tipo_persona);
        $ape_paterno =transformNull($request->ape_paterno); 
        $tipo_doc =transformNull($request->tipo_doc); 
        $num_doc =transformNull( $request->num_doc);
        $sexo =transformNull($request->sexo); 
        $calle = transformNull($request->calle);
        $direccion_completa =transformNull($request->direccion_completa); 
        $email = transformNull($request->email);
        $ff_nac = new DateTime($request->fecha_nac);
        $ffecha_nac= $ff_nac->format('m/d/Y H:i:s');

        $celular =transformNull($request->celular);
        $fono_oficina =transformNull($request->fono_oficina);
        $fono_domicilio =transformNull($request->fono_domicilio);
        $tienda =transformNull($request->tienda);
        $dpto =transformNull($request->dpto);
        $piso =transformNull($request->piso);
        $edificio =transformNull($request->edificio);
        $lote =transformNull($request->lote);
        $mz =transformNull($request->mz);
        $interior =transformNull($request->interior);
        $n_via =transformNull($request->n_via);
        $ape_materno =transformNull($request->ape_materno);
        $nombres = transformNull($request->nombres);

        try {
            DB::beginTransaction();
            DB::statement('exec sp_persona ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? ,?,?,?,?,?,?,?,?,?,?',
            array(41,"","","",$persona_id,$ape_paterno,$ape_materno,$nombres,$num_doc,$user_update,
                    "1",$calle,$tipo_doc,$ffecha_nac,$sexo,$tipo_persona,$n_via,$interior,$mz,$lote,
                    $piso,$edificio,$dpto,$tienda,$fono_domicilio,$fono_oficina,$celular,$email,1,$direccion_completa));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }

    }


    public function selectPersonSearch(Request $request){
        $nombres = $request->nombres;
        $listEstado =  DB::select('exec sp_persona ?,?,?,?', array(43,'','',$nombres));
        return response()->json($listEstado);
    }


    public function tipoTramite(Request $request){
        $expediente =  DB::select('exec sp_persona ?', array(46));
        return response()->json($expediente);
    }
}
