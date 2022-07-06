<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Entidad;
use App\Models\Presupuesto\UnidadEjecutora;
use App\Models\Presupuesto\TipoGobierno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            ->where('pres_unidadejecutora.tipogobierno', $tipogobierno)->get();
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
            'codigo' => $request->entidad_codigo,
            'tipogobierno' => $request->entidad_tipogobierno,
            'unidad_ejecutora' => $request->entidad_nombre,
            'abreviatura' => $request->entidad_abreviado,
        ]);
        $entidad->save();

        return response()->json(array('status' => true, 'nuva entidad' => $entidad));
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
        $entidad->codigo = $request->entidad_codigo;
        $entidad->tipogobierno = $request->entidad_tipogobierno;
        $entidad->unidad_ejecutora = $request->entidad_nombre;
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

        if ($request->gerencia == '') {
            $data['inputerror'][] = 'gerencia';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }

        return $data;
    }
    public function ajax_add_gerencia(Request $request)
    {
        $val = $this->_validategerencia($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $entidad = Entidad::Create([
            'entidad' => $request->gerencia,
            'abreviado' => $request->gerencia_abreviado,
            'unidadejecutadora_id' => $request->entidad_id,
            'estado' => 1,
        ]);

        return response()->json(array('status' => true, 'codigo' => $entidad->id));
    }
    public function cargarOficina($gerencia_id)
    {
        $oficinas = Entidad::where('dependencia', $gerencia_id)->get();
        return response()->json(compact('oficinas'));
    }
    private function _validateoficina($request)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($request->oficina == '') {
            $data['inputerror'][] = 'oficina';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }

        return $data;
    }
    public function ajax_add_oficina(Request $request)
    {
        $val = $this->_validateoficina($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $gerencia = Entidad::where('id', $request->gerencia_id)->first();
        $entidad = Entidad::Create([
            'entidad' => $request->oficina,
            'abreviado' => $request->oficina_abreviado,
            'unidadejecutadora_id' => $gerencia->unidadejecutadora_id,
            'dependencia' => $request->gerencia_id,
            'estado' => 1,
        ]);

        return response()->json(array('status' => true, 'codigo' => $entidad->id));
    }

    /* public function ajax_edit($perfil_id)
    {
        $menu = Perfil::find($perfil_id);

        return response()->json(compact('menu'));
    } */

    /*  private function _validate($request)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($request->sistema_id == '') {
            $data['inputerror'][] = 'sistema_id';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        if ($request->nombre == '') {
            $data['inputerror'][] = 'nombre';
            $data['error_string'][] = 'Este campo es obligatorio.';
            $data['status'] = FALSE;
        }
        return $data;
    } */
    /* 
    public function ajax_add(Request $request)
    {
        $val = $this->_validate($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $perfil = Perfil::Create([
            'sistema_id' => $request->sistema_id,
            'nombre' => $request->nombre,
            'estado' => '1',
        ]);

        $menu = Menu::where('sistema_id', $request->sistema_id)->where('dependencia')->where('posicion', '1')->where('estado', '1')->first();
        if ($menu)
            Menuperfil::Create(['perfil_id' => $perfil->id, 'menu_id' => $menu->id]);
        return response()->json(array('status' => true));
    }
    public function ajax_update(Request $request)
    {
        $val = $this->_validate($request);
        if ($val['status'] === FALSE) {
            return response()->json($val);
        }
        $perfil = Perfil::find($request->id);
        $perfil->sistema_id = $request->sistema_id;
        $perfil->nombre = $request->nombre;
        $perfil->save();

        return response()->json(array('status' => true, 'update' => $request, 'perfil' => $perfil));
    }
    public function ajax_delete($perfil_id)
    {
        $perfil = Perfil::find($perfil_id);
        $perfil->delete();
        return response()->json(array('status' => true, 'perfil' => $perfil));
    }

    public function listarmenu($perfil_id, $sistema_id)
    {
        $datas = MenuRepositorio::getMenu($sistema_id);
        $ticket = '';
        $ticket .= '<input type="hidden" class="form-control" name="perfil" id="perfil" value="' . $perfil_id . '">';
        $ticket .= '<ul >'; //class="checktree"
        foreach ($datas as $value) {
            $perfilmenu = Menuperfil::where('perfil_id', $perfil_id)->where('menu_id', $value->id)->first();
            $ticket .= '<li><label>';
            $ticket .= '<input id="menu" name="menu[]" type="checkbox" value="' . $value->id . '" ' . (isset($perfilmenu->id) ? 'checked' : '') . '> ' . $value->nombre;
            $ticket .= '</label><ul>';
            $menus = Menu::where('dependencia', $value->id)->get();
            foreach ($menus as $menu) {
                $perfilmenus = Menuperfil::where('perfil_id', $perfil_id)->where('menu_id', $menu->id)->first();
                $ticket .= '<li><label>';
                $ticket .= '<input id="menu" name="menu[]" type="checkbox" value="' . $menu->id . '" ' . (isset($perfilmenus->id) ? 'checked' : '') . '> ' . $menu->nombre;
                $ticket .= '</label></li>';
            }
            $ticket .= '</ul></li>';
        }
        $ticket .= '</ul>';
        return  $ticket;
    }
    public function ajax_add_menu(Request $request)
    {
        $modulos = Menu::where('sistema_id', $request->msistema_id)->get();
        foreach ($modulos as $modulo) {
            if ($request->menu) {
                $encontrado = false;
                foreach ($request->menu as $menu) {
                    if ($menu == $modulo->id) {
                        $encontrado = true;
                        $menuperfil = Menuperfil::where('perfil_id', $request->perfil)->where('menu_id', $menu)->first();
                        if (!$menuperfil) {
                            Menuperfil::Create(['perfil_id' => $request->perfil, 'menu_id' => $menu]);
                        }
                        break;
                    }
                }
                if ($encontrado == false) {
                    Menuperfil::where('perfil_id', $request->perfil)->where('menu_id', $modulo->id)->delete();
                }
            } else {
                Menuperfil::where('perfil_id', $request->perfil)->where('menu_id', $modulo->id)->delete();
            }
        }
        return response()->json(array('status' => true));
    }
    public function ajax_estado($perfil_id)
    {
        $perfil = Perfil::find($perfil_id);
        $perfil->estado = $perfil->estado == 1 ? 0 : 1;
        $perfil->save();
        return response()->json(array('status' => true, 'estado' => $perfil->estado));
    }
    public function listarsistema($perfil_id, $sistema_id)
    {
        $data = SistemaRepositorio::listarSistemaPerfil($perfil_id, $sistema_id);
        return response()->json(array('status' => true, 'sistemas' => $data));
    }
    public function ajax_add_sistema(Request $request)
    {
        $sistemas = Sistema::where('estado', '1')->get();
        foreach ($sistemas as $sistema) {
            if ($request->csistemas) {
                $encontrado = false;
                foreach ($request->csistemas as $csistema) {
                    if ($csistema == $sistema->id) {
                        $encontrado = true;
                        $pas = PerfilAdminSistema::where('perfil_id', $request->cperfil_id)->where('sistema_id', $csistema)->first();
                        if (!$pas) {
                            PerfilAdminSistema::Create(['perfil_id' => $request->cperfil_id, 'sistema_id' => $csistema]);
                        }
                        break;
                    }
                }
                if ($encontrado == false) {
                    PerfilAdminSistema::where('perfil_id', $request->cperfil_id)->where('sistema_id', $sistema->id)->delete();
                }
            } else {
                PerfilAdminSistema::where('perfil_id', $request->cperfil_id)->where('sistema_id', $sistema->id)->delete();
            }
        }
        return response()->json(array(
            'status' => true, 'csistemas' => $request->csistemas, 'sistemas' => $sistemas, 'csistema_id' => $request->csistema_id, 'cperfil_id' => $request->cperfil_id
        ));
    } */
}
