<?php

namespace App\Http\Controllers\TramiteDocumentario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DB;
class ExpedienteController extends Controller
{
    public function index(){
        return view('tramite_documentario.expediente.index');
    }

    public function list(){
        $personas =  DB::select('exec trd_expediente ?', array(1));
        return response()->json($personas);
    }

    public function listSearch(Request $request){
        $numero = $request->numero;
        $anio = $request->anio;
        $interesado = $request->interesado;
        $asunto = $request->asunto;
        $listEstado =  DB::select('exec trd_expediente ?,?,?,?,?,?,?,?,?,?,?', array(3,'','','','',$interesado,$asunto,'',$numero,'',$anio));
        return response()->json($listEstado);
    }
    public function editDatExpediente($id,$anio){
        $persona =  DB::select('exec trd_expediente ?,?,?,?,?,?,?,?,?,?,?', array(4,'','','','','','','',$id,'',$anio));
        return response()->json($persona);
    }

    public function selectPersonSearch(Request $request){
        $nombres = $request->nombres;
        $listEstado =  DB::select('exec rhSP_persona ?,?,?,?', array(45,'','',$nombres));
        return response()->json($listEstado);
    }
    public function updateDataExpediente(Request $request){
        $usuario=Auth::user()->per_login;
        
        $coddocumento = $request->numero;
        $tipodoc = $request->tipodoc;
        $remitente = $request->remitente;
        $folios = $request->folios;
        $anio = $request->anio;
        if($request->get('estado')==true){
            $estado=1;
        }else{
            $estado=0;
        }
        
        $codcontri =is_null($request->codcontri) ? '' : $request->codcontri;
        $asunto =is_null($request->asunto) ? '' : $request->asunto;
        $referencia =is_null($request->referencia) ? '' : $request->referencia;
        $descdocumento =is_null($request->descdocumento) ? '' : $request->descdocumento;

        $tipotramite = $request->tptra_id;

        try {
            DB::beginTransaction();
            DB::statement('exec trd_expediente ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
            array(5,"","",$asunto,"",$descdocumento,$remitente,$referencia,$coddocumento,"",$anio,$usuario,"","",$folios,$tipodoc,$tipotramite,$estado,"",$codcontri));
            DB::commit();
            return response()->json(true);
            }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function deleteDataExpediente(Request $request){
        try {
            $numero=$request->numero;
            $anio=$request->anio;
            $usuario=Auth::user()->per_login;
            DB::beginTransaction();
            DB::statement('exec trd_expediente ?,?,?,?,?,?,?,?,?,?,?,?', array(6,'','','','','','','',$numero,'',$anio,$usuario));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }


    public function adjuntarArchivoExpediente(Request $request){

        $numero = $request->numero;
        $anio = $request->anio;

        try {
            DB::beginTransaction();
            if ($request->file('archivo')) {
                $size = $request->file('archivo')->getSize();
                $file = $request->file('archivo');
                $name = "exp"."".time().$file->getClientOriginalName();
                $path = 'archivos/tramite/';
                $file->move($path, $name);
                $doc_sustentatorio = $name;
                // $name_doc = $file->getClientOriginalName();
            }

            DB::statement('exec trd_expediente ?,?,?,?,?,?,?,?,?,?,?',
            array(79,'','',$doc_sustentatorio,'','','','',$numero,'',$anio));
            DB::commit();
            return response()->json(true);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }
    
    
}
