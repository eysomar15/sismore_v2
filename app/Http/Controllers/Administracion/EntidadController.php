<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Entidad;
use App\Models\Presupuesto\UnidadEjecutora;
use App\Models\Presupuesto\TipoGobierno;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;

class EntidadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function principal()
    {
        //$entidad = UnidadEjecutora::all();
        $tipogobierno = TipoGobierno::all();
        return view('administracion.Entidad.Principal', compact('tipogobierno'));
    }

    public function gerencia()
    {
        $tipogobierno = TipoGobierno::all();
        return view('administracion.Entidad.Gerencia', compact('tipogobierno'));
    }
    public function oficina()
    {
        $tipogobierno = TipoGobierno::all();
        return view('administracion.Entidad.Oficina', compact('tipogobierno'));
    }

    public function listarDTentidad($tipogobierno)
    {
        /* if ($dependencia == 0)
            $data = Entidad::select('pres_entidad.*')
                ->where('pres_entidad.unidadejecutadora_id', $unidadejecutora_id)
                ->where('pres_entidad.dependencia')
                ->get();
        else $data = Entidad::select('pres_entidad.*')
            ->where('pres_entidad.unidadejecutadora_id', $unidadejecutora_id)
            ->where('pres_entidad.dependencia', $dependencia)
            ->get(); */
        $data = UnidadEjecutora::select('pres_unidadejecutora.*', 'v2.tipogobierno as nombretipogobierno')
            ->join('pres_tipo_gobierno as v2', 'v2.id', '=', 'pres_unidadejecutora.tipogobierno')
            ->where('pres_unidadejecutora.tipogobierno', $tipogobierno)->orderBy('id', 'desc')->get();
        return  datatables()::of($data)
            /* ->editColumn('grupo', function ($data) {
                if ($data->dependencia) return $data->grupo;
                else return '';
            }) */
            ->addColumn('action', function ($data) {
                $acciones = '';
                $acciones .= '<a href="#" class="btn btn-info btn-sm" onclick="edit(' . $data->id . ')"  title="MODIFICAR"> <i class="fa fa-pen"></i> </a>';
                $acciones .= '&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="borrar(' . $data->id . ')" title="ELIMINAR"> <i class="fa fa-trash"></i> </a>';

                return $acciones;
            })

            ->rawColumns(['action'/* , 'grupo' */])
            ->make(true);
    }

    public function listarDTgerencia($entidad_id)
    {
        $data = Entidad::where('unidadejecutadora_id', $entidad_id)->where('dependencia')->orderBy('id', 'desc')->get();
        return  datatables()::of($data)
            ->addColumn('action', function ($data) {
                $acciones = '';
                $acciones .= '<a href="#" class="btn btn-info btn-sm" onclick="edit(' . $data->id . ')"  title="MODIFICAR"> <i class="fa fa-pen"></i> </a>';
                $acciones .= '&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="borrar(' . $data->id . ')" title="ELIMINAR"> <i class="fa fa-trash"></i> </a>';
                return $acciones;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function listarDToficina($gerencia_id)
    {
        $data = Entidad::where('dependencia', $gerencia_id)->orderBy('id', 'desc')->get();
        return  datatables()::of($data)
            ->addColumn('action', function ($data) {
                $acciones = '';
                $acciones .= '<a href="#" class="btn btn-info btn-sm" onclick="edit(' . $data->id . ')"  title="MODIFICAR"> <i class="fa fa-pen"></i> </a>';
                $acciones .= '&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="borrar(' . $data->id . ')" title="ELIMINAR"> <i class="fa fa-trash"></i> </a>';
                return $acciones;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    private function _validateentidad($request)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($request->entidad_codigo == '') {
            $data['inputerror'][] = 'entidad_codigo';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }

        if ($request->entidad_nombre == '') {
            $data['inputerror'][] = 'entidad_nombre';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }

        if ($request->entidad_abreviado == '') {
            $data['inputerror'][] = 'entidad_abreviado';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        return $data;
    }
    public function ajax_add_entidad(Request $request)
    {
        $val = $this->_validateentidad($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $entidad = UnidadEjecutora::Create([
            'codigo_ue' => $request->entidad_codigo,
            'tipogobierno' => $request->entidad_tipogobierno,
            'nombre_ejecutora' => $request->entidad_nombre,
            'abreviatura' => $request->entidad_abreviado,
        ]);
        $entidad->save();

        return response()->json(array('status' => true, 'entidad' => $entidad));
    }
    public function ajax_edit_entidad($entidad_id)
    {
        $entidad = Unidadejecutora::find($entidad_id);
        return response()->json(compact('entidad'));
    }
    public function ajax_update_entidad(Request $request)
    {
        $val = $this->_validateentidad($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $entidad = UnidadEjecutora::find($request->entidad_id);
        $entidad->codigo_ue = $request->entidad_codigo;
        $entidad->tipogobierno = $request->entidad_tipogobierno;
        $entidad->nombre_ejecutora = $request->entidad_nombre;
        $entidad->abreviatura = $request->entidad_abreviado;
        $entidad->save();

        return response()->json(array('status' => true, 'tipo' => $entidad));
    }
    public function ajax_delete_entidad($entidad_id)
    {
        $entidad = UnidadEjecutora::find($entidad_id);
        $entidad->delete();
        return response()->json(array('status' => true));
    }
    public function cargarEntidad($tipogobierno_id)
    {
        $unidadejecutora = UnidadEjecutora::where('tipogobierno', $tipogobierno_id)->get();
        return response()->json(compact('unidadejecutora'));
    }

    public function cargarGerencia($entidad_id)
    {
        $gerencias = Entidad::where('unidadejecutadora_id', $entidad_id)->where('dependencia')->get();
        return response()->json(compact('gerencias'));
    }
    private function _validategerencia($request)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        if ($request->vista == '2') {
            if ($request->gerencia_entidad == '') {
                $data['inputerror'][] = 'gerencia_entidad';
                $data['error_string'][] = 'Este campo es obligatorio.';
                $data['status'] = FALSE;
            }
            if ($request->gerencia_nombre == '') {
                $data['inputerror'][] = 'gerencia_nombre';
                $data['error_string'][] = 'Este campo es obligatorio.';
                $data['status'] = FALSE;
            }
        } else {
            if ($request->gerencia == '') {
                $data['inputerror'][] = 'gerencia';
                $data['error_string'][] = 'Este campo es obligatorio.';
                $data['status'] = FALSE;
            }
        }

        return $data;
    }
    public function ajax_add_gerencia(Request $request)
    {
        $val = $this->_validategerencia($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        if ($request->vista == '2') {
            $entidad = Entidad::Create([
                'entidad' => $request->gerencia_nombre,
                'codigo' => $request->gerencia_codigo,
                'abreviado' => $request->gerencia_abreviado,
                'unidadejecutadora_id' => $request->gerencia_entidad,
                'estado' => 1,
            ]);
        } else {
            $entidad = Entidad::Create([
                'entidad' => $request->gerencia,
                'abreviado' => $request->gerencia_abreviado,
                'unidadejecutadora_id' => $request->entidad_id,
                'estado' => 1,
            ]);
        }
        return response()->json(array('status' => true, 'codigo' => $entidad->id));
    }
    public function ajax_update_gerencia(Request $request)
    {
        $val = $this->_validategerencia($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $entidad = Entidad::find($request->gerencia_id);
        $entidad->codigo = $request->gerencia_codigo;
        $entidad->entidad = $request->gerencia_nombre;
        $entidad->unidadejecutadora_id = $request->gerencia_entidad;
        $entidad->abreviado = $request->gerencia_abreviado;
        $entidad->save();

        return response()->json(array('status' => true, 'tipo' => $entidad));
    }
    public function ajax_edit_gerencia($gerencia_id)
    {
        $gerencia = Entidad::find($gerencia_id);
        $entidad = UnidadEjecutora::find($gerencia->unidadejecutadora_id);
        $gerencia->tipogobierno = $entidad->tipogobierno;
        return response()->json(compact('gerencia'));
    }
    public function cargarOficina($gerencia_id)
    {
        $oficinas = Entidad::where('dependencia', $gerencia_id)->get();
        return response()->json(compact('oficinas'));
    }
    public function ajax_delete_gerencia($gerencia_id)
    {
        $entidad = Entidad::find($gerencia_id);
        $entidad->delete();
        return response()->json(array('status' => true));
    }
    private function _validateoficina($request)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;
        if ($request->vista == 2) {
            if ($request->oficina_gerencia == '') {
                $data['inputerror'][] = 'oficina_gerencia';
                $data['error_string'][] = 'Este campo es obligatorio.';
                $data['status'] = FALSE;
            }
            if ($request->oficina_nombre == '') {
                $data['inputerror'][] = 'oficina_nombre';
                $data['error_string'][] = 'Este campo es obligatorio.';
                $data['status'] = FALSE;
            }
        } else {
            if ($request->oficina == '') {
                $data['inputerror'][] = 'oficina';
                $data['error_string'][] = 'Este campo es obligatorio.';
                $data['status'] = FALSE;
            }
        }
        return $data;
    }
    public function ajax_add_oficina(Request $request)
    {
        $val = $this->_validateoficina($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }

        if ($request->vista == 2) {
            $entidad = Entidad::Create([
                'codigo' => $request->oficina_codigo,
                'entidad' => $request->oficina_nombre,
                'abreviado' => $request->oficina_abreviado,
                'unidadejecutadora_id' => $request->oficina_entidad,
                'dependencia' => $request->oficina_gerencia,
                'estado' => 1,
            ]);
        } else {
            $gerencia = Entidad::where('id', $request->gerencia_id)->first();
            $entidad = Entidad::Create([
                'entidad' => $request->oficina,
                'abreviado' => $request->oficina_abreviado,
                'unidadejecutadora_id' => $gerencia->unidadejecutadora_id,
                'dependencia' => $request->gerencia_id,
                'estado' => 1,
            ]);
        }

        return response()->json(array('status' => true, 'codigo' => $entidad->id));
    }
    public function ajax_update_oficina(Request $request)
    {
        $val = $this->_validateoficina($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $entidad = Entidad::find($request->oficina_id);
        $entidad->codigo = $request->oficina_codigo;
        $entidad->entidad = $request->oficina_nombre;
        $entidad->unidadejecutadora_id = $request->oficina_entidad;
        $entidad->abreviado = $request->oficina_abreviado;
        $entidad->save();

        return response()->json(array('status' => true, 'tipo' => $entidad));
    }
    /*  */
    public function ajax_edit_oficina($oficina_id)
    {
        $oficina = Entidad::find($oficina_id);
        $entidad = UnidadEjecutora::find($oficina->unidadejecutadora_id);
        $oficina->tipogobierno = $entidad->tipogobierno;
        return response()->json(compact('oficina'));
    }
    public function ajax_delete_oficina($oficina_id)
    {
        $entidad = Entidad::find($oficina_id);
        $entidad->delete();
        return response()->json(array('status' => true));
    }
}
