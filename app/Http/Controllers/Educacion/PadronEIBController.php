<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\InstitucionEducativa;
use App\Models\Educacion\PadronEIB;
use App\Models\Parametro\Anio;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Utilities\Utilitario;
use Exception;
use Illuminate\Support\Facades\DB;

class PadronEIBController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function _validate_ajaxopt1($rq)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;


        if ($rq->idiiee_padronweb == '') {
            $data['inputerror'][] = 'codigomodular_padronweb';
            $data['error_string'][] = '<br>Este campo es obligatorio buscar.';
            $data['status'] = FALSE;
        }

        if ($rq->estado_padronweb == 'SI') {
            $data['inputerror'][] = 'codigomodular_padronweb';
            $data['error_string'][] = '<br> Servicio Educativo Registrado en el Padron EIB.';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
    public function ajax_add_opt1(Request $rq)
    {
        $this->_validate_ajaxopt1($rq);
        $query = DB::table('edu_padron_eib as v1')
            ->join('par_importacion as v2', 'v2.id', '=', 'v1.importacion_id')
            ->orderBy('v2.fechaActualizacion', 'desc')
            ->take(1)
            ->select('v2.id', 'v1.anio_id as ano')
            ->get();
        $data = [
            'importacion_id' => $query->first()->id,
            'anio_id' => $query->first()->ano,
            'institucioneducativa_id' => $rq->idiiee_padronweb,
            'forma_atencion' => $rq->formaatencion_padronweb,
            'cod_lengua' => $rq->codigolengua_padronweb,
            'lengua_uno' => $rq->lenguauno_padronweb,
            'lengua_dos' => $rq->lenguados_padronweb,
            'lengua_3' => $rq->lengua3_padronweb,
            'ingreso' => 1,
        ];
        //return response()->json(['status' => TRUE, 'info' => $data]);
        $eib = PadronEIB::Create($data);
        if ($eib) {
            $iiee = InstitucionEducativa::find($rq->idiiee_padronweb);
            $iiee->es_eib = 'SI';
            $iiee->save();
        }
        return response()->json(['status' => TRUE, 'info' => $eib]);
    }

    public function ajax_delete_opt1($idpadroneib)
    {
        $eib = PadronEIB::find($idpadroneib);
        if ($eib) {
            $iiee = InstitucionEducativa::find($eib->institucioneducativa_id);
            $iiee->es_eib = null;
            $iiee->save();
        }
        $eib->delete();
        return response()->json(['status' => TRUE, 'eib' => $eib]);
    }
}
