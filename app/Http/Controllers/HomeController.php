<?php

namespace App\Http\Controllers;

use App\Models\Administracion\Sistema;
use App\Models\Administracion\UsuarioPerfil;
use App\Models\Educacion\CentroPoblado;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\Matricula;
use App\Models\Presupuesto\BaseGastos;
use App\Models\Presupuesto\BaseIngresos;
use App\Models\Presupuesto\TipoGobierno;
use App\Models\Vivienda\CentroPobladoDatass;
use App\Repositories\Administracion\MenuRepositorio;
use App\Repositories\Administracion\SistemaRepositorio;
use App\Repositories\Administracion\UsuarioPerfilRepositorio;
use App\Repositories\Administracion\UsuarioRepositorio;
use App\Repositories\Educacion\CuadroAsigPersonalRepositorio;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Repositories\Educacion\InstEducativaRepositorio;
use App\Repositories\Educacion\MatriculaDetalleRepositorio;
use App\Repositories\Educacion\MatriculaRepositorio;
use App\Repositories\Educacion\NivelModalidadRepositorio;
use App\Repositories\Educacion\PadronWebRepositorio;
use App\Repositories\Educacion\PlazaRepositorio;
use App\Repositories\Educacion\TabletaRepositorio;
use App\Repositories\Educacion\UgelRepositorio;
use App\Repositories\Vivienda\CentroPobladoDatassRepositorio;
use App\Repositories\Vivienda\CentroPobladoRepositotio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sistemas = SistemaRepositorio::Listar_porUsuario(auth()->user()->id);
        $usuper = UsuarioPerfilRepositorio::get_porusuariosistema(auth()->user()->id, '4');
        session()->put(['usuario_id' => auth()->user()->id]);
        session()->put(['total_sistema' => $sistemas->count()]);
        session()->put(['perfil_id' => $usuper ? $usuper->perfil_id : 0]);

        $usuario = UsuarioRepositorio::Usuario(auth()->user()->id);

        if ($usuario->first() != null) {
            session(['dnisismore$' => $usuario->first()->dni]);
            session(['passwordsismore$' => $usuario->first()->password]);
        }
        // return session('dnisismore$');
        if ($sistemas->count() == 1)
            return $this->sistema_acceder($sistemas->first()->sistema_id);
        // return session('usuario_id');
        return view('Access', compact(('sistemas')));
    }

    public function sistema_acceder($sistema_id)
    {
        // session()->forget('sistema_id');
        // session()->forget('sistema_nombre');
        // session()->forget('menuNivel01');
        // session()->forget('menuNivel02');

        session(['sistema_id' => $sistema_id]);

        $sistema = Sistema::find($sistema_id);
        session(['sistema_nombre' => $sistema->nombre]);

        $menuNivel01 = MenuRepositorio::Listar_Nivel01_porUsuario_Sistema(auth()->user()->id, $sistema_id);
        session(['menuNivel01' => $menuNivel01]);

        $menuNivel02 = MenuRepositorio::Listar_Nivel02_porUsuario_Sistema(auth()->user()->id, $sistema_id);
        session(['menuNivel02' => $menuNivel02]);

        switch ($sistema_id) {
            case (1):
                return $this->educacion($sistema_id);
                break;
            case (2):
                return $this->vivienda($sistema_id);
                break;
            case (4):
                return $this->administracion($sistema_id);
                break;
            case (5):
                return $this->presupuesto($sistema_id);
                break;
            case (6):
                return $this->trabajo($sistema_id);
                break;
            default:
                return 'Ruta de sistema no establecida';
                break;
        }
    }

    public function administracion($sistema_id)
    {
        $sistemas = SistemaRepositorio::listar_sistemasconusuarios(1);
        //return $sistemas;
        return view('home', compact('sistema_id', 'sistemas'));
    }

    public function trabajo($sistema_id)
    {
        return view('home', compact('sistema_id'));
    }


    public function presupuesto($sistema_id)
    {
        $impG = Importacion::where('fuenteimportacion_id', '13')->where('estado', 'PR')->orderBy('fechaActualizacion', 'desc')->first();
        $impI = Importacion::where('fuenteimportacion_id', '15')->where('estado', 'PR')->orderBy('fechaActualizacion', 'desc')->first();
        //return $impI;

        $opt1 = BaseGastos::where('importacion_id', $impG->id)->select(DB::raw('sum(pim) as pim'), DB::raw('100*sum(devengado)/sum(pim) as eje'))->first();
        $card1['pim'] = $opt1->pim;
        $card1['eje'] = $opt1->eje;

        $opt1 = BaseGastos::where('pres_base_gastos.importacion_id', $impG->id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->select(
                'v4.id',
                'v4.tipogobierno as gobiernos',
                DB::raw('sum(pres_base_gastos.pim) as pim'),
                DB::raw('100*sum(pres_base_gastos.devengado)/sum(pres_base_gastos.pim) as eje')
            )
            ->groupBy('id', 'gobiernos')
            ->orderBy('v4.id', 'asc')
            ->get();
        $card2['pim'] = $opt1[1]->pim;
        $card2['eje'] = $opt1[1]->eje;
        $card3['pim'] = $opt1[2]->pim;
        $card3['eje'] = $opt1[2]->eje;
        $card4['pim'] = $opt1[0]->pim;
        $card4['eje'] = $opt1[0]->eje;
        //return $opt1;

        return view('home', compact('sistema_id', 'card1', 'card2', 'card3', 'card4', 'impG', 'impI'));
    }

    public function presupuestografica1($importacion_id)
    {
        $info = BaseGastos::where('pres_base_gastos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_gastos.pim) as y'),
            )
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        foreach ($info as $key => $value) {
            if ($value->name == 'GOBIERNO NACIONAL') $value->name = 'GOB. NACIONAL';
            if ($value->name == 'GOBIERNOS REGIONALES') $value->name = 'GOB. REGIONALES';
            if ($value->name == 'GOBIERNOS LOCALES') $value->name = 'GOB. LOCALES';
        }
        return response()->json(compact('info'));
    }

    public function presupuestografica2($importacion_id)
    {
        $info = BaseGastos::where('pres_base_gastos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->join('pres_producto_proyecto as v5', 'v5.id', '=', 'pres_base_gastos.productoproyecto_id')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_gastos.pim) as y'),
            )
            ->where('v5.codigo', '2')
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        foreach ($info as $key => $value) {
            if ($value->name == 'GOBIERNO NACIONAL') $value->name = 'GOB. NACIONAL';
            if ($value->name == 'GOBIERNOS REGIONALES') $value->name = 'GOB. REGIONALES';
            if ($value->name == 'GOBIERNOS LOCALES') $value->name = 'GOB. LOCALES';
        }
        return response()->json(compact('info'));
    }

    public function presupuestografica3($importacion_id)
    {
        $info = BaseIngresos::where('pres_base_ingresos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_ingresos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_ingresos.pim) as y'),
            )
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        foreach ($info as $key => $value) {
            if ($value->name == 'GOBIERNO NACIONAL') $value->name = 'GOB. NACIONAL';
            if ($value->name == 'GOBIERNOS REGIONALES') $value->name = 'GOB. REGIONALES';
            if ($value->name == 'GOBIERNOS LOCALES') $value->name = 'GOB. LOCALES';
        }
        return response()->json(compact('info'));
    }
    public function presupuestografica4($importacion_id)
    {
        $base = BaseGastos::select(
            'v3.id',
            'v2.anio as ano',
            'v6.tipogobierno as tipo',
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNO NACIONAL',pres_base_gastos.pim,0)) as pim1"),
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS REGIONALES',pres_base_gastos.pim,0)) as pim2"),
            DB::raw("sum(IF(v6.tipogobierno='GOBIERNOS LOCALES',pres_base_gastos.pim,0)) as pim3"),
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_pliego as v4', 'v4.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v5', 'v5.id', '=', 'v4.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v6', 'v6.id', '=', 'v5.tipogobierno')
            ->where('v3.estado', 'PR')
            ->groupBy('id', 'ano', 'tipo')
            ->get();
        $data['categoria'] = [];
        $data['series'] = [];
        $dx1 = [];
        $dx2 = [];
        $dx3 = [];
        //$data['categoria'][] = [2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022,]; //$ba->ano;
        foreach ($base as $key => $ba) {
            if ($ba->tipo == 'GOBIERNO NACIONAL') {
                $data['categoria'][] = $ba->ano;
                $dx1[] = $ba->pim1;
            }
            if ($ba->tipo == 'GOBIERNOS REGIONALES')
                $dx2[] = $ba->pim2;
            if ($ba->tipo == 'GOBIERNOS LOCALES')
                $dx3[] = $ba->pim3;
        }
        $data['series'][] = ['name' => 'GOBIERNO NACIONAL', 'color' => '#7e57c2',  'data' => $dx1];
        $data['series'][] = ['name' => 'GOBIERNOS REGIONALES', 'color' => '#317eeb',  'data' => $dx2];
        $data['series'][] = ['name' => 'GOBIERNOS LOCALES', 'color' => '#ef5350', 'data' => $dx3];
        return response()->json(compact('data'));
    }

    public function presupuestografica4x($importacion_id)
    {
        $base = BaseGastos::select(
            'v3.id',
            'v2.anio as name',
            'v2.anio as drilldown',
            DB::raw("sum(pres_base_gastos.pim) as pim"),
            DB::raw('ROUND(sum(pres_base_gastos.devengado),2) as devengado'),
            DB::raw("ROUND(100*sum(pres_base_gastos.devengado)/sum(pres_base_gastos.pim),1) as y")
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->where('v3.estado', 'PR')
            ->groupBy('id', 'name')
            ->get();

        /* $info = BaseGastos::where('v5.estado', 'PR')
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->join('par_importacion as v5', 'v5.id', '=', 'pres_base_gastos.importacion_id')
            ->select(
                DB::raw('year(v5.fechaActualizacion) as ano'),
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_gastos.pia) as pia'),
                DB::raw('sum(pres_base_gastos.pim) as pim'),
                DB::raw('sum(pres_base_gastos.devengado) as ejecutado'),
                DB::raw('ROUND(100*sum(pres_base_gastos.devengado)/sum(pres_base_gastos.pim),1) as pejecutado'),
            )
            ->groupBy('ano', 'id', 'name')
            //->orderBy('v4.pos', 'asc')
            ->get(); */

        $data['categoria'] = [];
        $data['series'] = [];
        $base2 = [];
        $dx1 = [];
        $dx2 = [];
        $dx3 = [];
        foreach ($base as $key => $ba) {
            /* $ba->name =  $ba->name;
            $data2 = []; */
            /* foreach ($info as $inf) {
                if ($inf->ano == $ba->name)
                    $data2[] = [$inf->name, $inf->pia];
            }
            $base2[] = ['name' => $ba->name, 'id' => $ba->drilldown, 'data' => $data2]; */

            $data['categoria'][] = $ba->name;
            $dx2[] = $ba->pim; // ['name' => $ba->pim, 'drilldown' => $ba->drilldown]; //pim
            $dx3[] = $ba->devengado; // ['name' => $ba->devengado, 'drilldown' => $ba->drilldown]; //devengado
        }
        $data['series'][] = ['name' => 'PIM', 'color' => '#317eeb',  'data' => $dx2];
        $data['series'][] = ['name' => 'DEVENGADO', 'color' => '#ef5350', 'data' => $dx3];
        return response()->json(compact('data'));
    }

    public function presupuestografica5($importacion_id)
    {
        $base = BaseGastos::select(
            'v2.anio as name',
            //DB::raw("sum(pres_base_gastos.pim) as y"),
            DB::raw("ROUND(100*sum(pres_base_gastos.devengado)/sum(pres_base_gastos.pim),1) as y")
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_gastos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_gastos.importacion_id')
            ->join('pres_producto_proyecto as v4', 'v4.id', '=', 'pres_base_gastos.productoproyecto_id')
            ->where('v3.estado', 'PR')
            ->where('v4.codigo', '2')
            ->groupBy('name')
            ->get();
        return response()->json(compact('base'));
    }
    public function presupuestografica6($importacion_id)
    {
        $base = BaseIngresos::select(
            'v2.anio as name',
            //DB::raw("sum(pres_base_ingresos.pim) as y"),
            DB::raw("ROUND(100*sum(pres_base_ingresos.recaudado)/sum(pres_base_ingresos.pim),1) as y")
        )
            ->join('par_anio as v2', 'v2.id', '=', 'pres_base_ingresos.anio_id')
            ->join('par_importacion as v3', 'v3.id', '=', 'pres_base_ingresos.importacion_id')
            ->where('v3.estado', 'PR')
            ->groupBy('name')
            ->get();
        return response()->json(compact('base'));
    }

    public function presupuestotabla1($importacion_id)
    {
        $info = BaseGastos::where('pres_base_gastos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_gastos.pia) as y1'),
                DB::raw('sum(pres_base_gastos.pim) as y2'),
                DB::raw('sum(pres_base_gastos.devengado) as y3'),
            )
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        //$gobiernos = TipoGobierno::all();
        $data['categoria'] = ['GOBIERNO NACIONAL', 'GOBIERNOS REGIONALES', 'GOBIERNOS LOCALES'];
        $data['series'] = [];
        $dx1 = [];
        $dx2 = [];
        $dx3 = [];
        foreach ($info as $key => $value) {
            //$dx1[] = $value->y1; //pia
            $dx2[] = $value->y2; //pim
            $dx3[] = round($value->y3, 2); //devengado
        }
        //$data['series'][] = ['name' => 'PIA', 'color' => '#7C7D7D', 'data' => $dx1];
        $data['series'][] = ['name' => 'PIM', 'color' => '#317eeb', 'data' => $dx2];
        $data['series'][] = ['name' => 'DEVENGADO', 'color' => '#ef5350', 'data' => $dx3];

        //$data['categoria'] = ['GOB. NACIONAL', 'GOB. REGIONALES', 'GOB. LOCALES'];

        return response()->json(compact('data'));
    }

    public function presupuestotabla2($importacion_id)
    {
        $info = BaseGastos::where('pres_base_gastos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_gastos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->join('pres_producto_proyecto as v5', 'v5.id', '=', 'pres_base_gastos.productoproyecto_id')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_gastos.pia) as y1'),
                DB::raw('sum(pres_base_gastos.pim) as y2'),
                DB::raw('sum(pres_base_gastos.devengado) as y3'),
            )
            ->where('v5.codigo', '2')
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        //$gobiernos = TipoGobierno::all();
        $data['categoria'] = ['GOBIERNO NACIONAL', 'GOBIERNOS REGIONALES', 'GOBIERNOS LOCALES'];
        $data['series'] = [];
        $dx1 = [];
        $dx2 = [];
        $dx3 = [];
        foreach ($info as $key => $value) {
            $dx1[] = $value->y1; //pia
            $dx2[] = $value->y2; //pim
            $dx3[] = round($value->y3, 2); //devengado
        }
        //$data['series'][] = ['name' => 'PIA', 'color' => '#7C7D7D', 'data' => $dx1];
        $data['series'][] = ['name' => 'PIM', 'color' => '#317eeb', 'data' => $dx2];
        $data['series'][] = ['name' => 'DEVENGADO', 'color' => '#ef5350', 'data' => $dx3];
        return response()->json(compact('data'));
    }

    public function presupuestotabla3($importacion_id)
    {
        $info = BaseIngresos::where('pres_base_ingresos.importacion_id', $importacion_id)
            ->join('pres_pliego as v2', 'v2.id', '=', 'pres_base_ingresos.pliego_id')
            ->join('pres_unidadejecutora as v3', 'v3.id', '=', 'v2.unidadejecutora_id')
            ->join('pres_tipo_gobierno as v4', 'v4.id', '=', 'v3.tipogobierno')
            ->select(
                'v4.id',
                'v4.tipogobierno as name',
                DB::raw('sum(pres_base_ingresos.pia) as y1'),
                DB::raw('sum(pres_base_ingresos.pim) as y2'),
                DB::raw('sum(pres_base_ingresos.recaudado) as y3'),
            )
            ->groupBy('id', 'name')
            ->orderBy('v4.pos', 'asc')
            ->get();
        //return $info;
        //$gobiernos = TipoGobierno::all();
        $data['categoria'] = ['GOBIERNO NACIONAL', 'GOBIERNOS REGIONALES', 'GOBIERNOS LOCALES'];
        $data['series'] = [];
        $dx1 = [];
        $dx2 = [];
        $dx3 = [];
        foreach ($info as $key => $value) {
            $dx1[] = $value->y1; //pia
            $dx2[] = $value->y2; //pim
            $dx3[] = round($value->y3, 2); //devengado
        }
        //$data['series'][] = ['name' => 'PIA', 'color' => '#7C7D7D', 'data' => $dx1];
        $data['series'][] = ['name' => 'PIM', 'color' => '#317eeb', 'data' => $dx2];
        $data['series'][] = ['name' => 'RECAUDACIÓN', 'color' => '#ef5350', 'data' => $dx3];
        return response()->json(compact('data'));
    }



    public function vivienda($sistema_id)
    {
        //$imp = Importacion::select(DB::raw('max(id) as maximo'))->where('fuenteimportacion_id', '7')->where('estado', 'PR')->first();
        $importacion_id = ImportacionRepositorio::Max_porfuente('7');
        if ($importacion_id) {
            $data[] = ['name' => 'Centros Poblados', 'y' => CentroPobladoDatassRepositorio::listar_centroPoblado($importacion_id)->conteo];
            $data[] = ['name' => 'Sistema de agua', 'y' => CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 20, $importacion_id)['indicador'][0]->y];
            $data[] = ['name' => 'Disposicion Escretas', 'y' => CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 23, $importacion_id)['indicador2'][0]->y];
            $data[] = ['name' => 'Sistema Cloración', 'y' => CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 21, $importacion_id)['indicador2'][0]->y];

            $sumas = CentroPobladoDatassRepositorio::sumas_dashboard($importacion_id);
            $data2[] = ['name' => 'población', 'y' => $sumas->poblacion];/* total_poblacion */
            $data2[] = ['name' => 'Cobertura de Agua', 'y' => $sumas->con_agua];/* poblacion_con_servicio_agua */
            $data2[] = ['name' => 'viviendas', 'y' => $sumas->con_conexion];/* total_viviendas */
            $data2[] = ['name' => 'Conexion de Agua', 'y' => $sumas->con_conexion];/* viviendas_con_conexion */

            $grafica[] = CentroPobladoRepositotio::listarporprovincias($importacion_id);/* total de centro poblado por provincia */
            $grafica[] = CentroPobladoRepositotio::listarporprovinciasconsistemaagua($importacion_id);/* total de centro poblado con servicio de agua(sistema_agua) */

            $grafica2[] = CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 20, $importacion_id)['indicador'];
            $grafica2[] = CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 23, $importacion_id)['indicador2'];

            return view('home', compact('sistema_id', 'importacion_id', 'data', 'data2', 'grafica', 'grafica2'));
        } else {
            return view('home', compact('sistema_id', 'importacion_id'));
        }
    }


    public function educacion($sistema_id)
    {
        $imp = ImportacionRepositorio::Max_yearPadronWeb(); //padron web
        $imp2 = ImportacionRepositorio::Max_yearSiagieMatricula(); //siagie
        $imp3 = ImportacionRepositorio::Max_porfuente(2); //nexus

        if ($imp->count() > 0 && $imp2->count() > 0 && $imp3 != null) {
            $importacion_id = $imp->first()->id;
            $matricula_id = $imp2->first()->mat;

            $info['se'] = PadronWebRepositorio::count_institucioneducativa($imp->first()->id);
            $info['le'] = PadronWebRepositorio::count_localesescolares($imp->first()->id);
            $info['tm'] = MatriculaDetalleRepositorio::count_matriculados($imp2->first()->mat);
            $info['do'] = PlazaRepositorio::count_docente($imp3);

            $info['dt0'] = MatriculaDetalleRepositorio::listar_estudiantesMatriculadosDeEducacionBasicaPorUgel($imp2);
            $info['dt1'] = PadronWebRepositorio::listar_totalServicosLocalesSecciones($imp);
            return  view('home', compact('importacion_id', 'info', 'imp', 'matricula_id'));
        } else {
            $importacion_id = null;
            $importables['padron_web'] = $imp->count() == 0;
            $importables['siagie_matricula'] = $imp2->count() == 0;
            $importables['nexus_minedu'] = $imp3 == null;
            return  view('home', compact('importacion_id', 'importables'));
        }
    }

    public function educaciongrafica1()
    {
        $info = MatriculaDetalleRepositorio::estudiantes_matriculadosEBR_EBE_anual();
        return response()->json(compact('info'));
    }
    public function educaciongrafica2()
    {
        $info = PlazaRepositorio::docentes_conteo_anual();
        return response()->json(compact('info'));
    }
    public function educaciongrafica3()
    {
        $info = MatriculaDetalleRepositorio::estudiantes_matriculados_segungenero();
        return response()->json(compact('info'));
    }
    public function educaciongrafica4()
    {
        $info = PlazaRepositorio::docentes_segungenero_anual();
        return response()->json(compact('info'));
    }
    public function educaciongrafica5()
    {
        $info = MatriculaDetalleRepositorio::estudiantes_matriculados_segunareageografica();
        return response()->json(compact('info'));
    }
    public function educaciongrafica6()
    {
        $info =  PlazaRepositorio::docentes_segunareageograficas();
        return response()->json(compact('info'));
    }

    public function educacionx($sistema_id)
    {
        $instituciones_activas = 0;
        $instituciones_inactivas = 0;
        $instituciones_total = 0;

        $titulados_inicial = 0;
        $titulados_primaria = 0;
        $titulados_secundaria = 0;
        $titulados_sum = 0;
        $noTitulados = 0;
        $porcentajeTitulados = 0;
        $porcentajeInstituciones_activas = 0;
        $localesEducativos = 0;
        $locales_tieneInternet = 0;
        $porcentajeLocales_tieneInternet = 0;

        $data = DB::select('call edu_pa_dashboard()');

        foreach ($data as $key => $item) {
            $instituciones_activas  = $item->instituciones_activas;
            $instituciones_inactivas  = $item->instituciones_inactivas;

            $instituciones_total = $instituciones_activas + $instituciones_inactivas;

            $titulados_inicial = $item->titulados_inicial;
            $titulados_primaria = $item->titulados_primaria;
            $titulados_secundaria = $item->titulados_secundaria;
            $titulados_sum = $titulados_inicial + $titulados_primaria + $titulados_secundaria;
            $noTitulados = $item->noTitulados;

            $porcentajeTitulados = round(($titulados_sum * 100 / ($titulados_sum + $noTitulados)), 2);

            $porcentajeInstituciones_activas = round(($instituciones_activas * 100 / ($instituciones_activas + $instituciones_inactivas)), 2);

            $locales_tieneInternet = $item->locales_tieneInternet;
            $localesEducativos = $item->locales_tieneInternet + $item->locales_no_tieneInternet;
            $porcentajeLocales_tieneInternet = round(($locales_tieneInternet * 100 / $localesEducativos), 2);
        }

        $par_medidor1_max =  $instituciones_total;

        $tabletas_ultimaActualizacion = TabletaRepositorio::tabletas_ultimaActualizacion()->first();

        $fechaTableta = $tabletas_ultimaActualizacion->fechaActualizacion;

        //{{number_format($sum_cero_nivel_hombre,0)}}

        $par_medidor1_max = 100;
        $par_medidor1_data =  number_format((($tabletas_ultimaActualizacion->total_Recepcionadas * 100) / $tabletas_ultimaActualizacion->total_aDistribuir), 2);

        $par_medidor2_max = 100;
        $par_medidor2_data =  number_format((($tabletas_ultimaActualizacion->total_Asignadas * 100) / $tabletas_ultimaActualizacion->total_aDistribuir), 2);


        return view('home', compact(
            'par_medidor1_max',
            'par_medidor1_data',
            'par_medidor2_max',
            'par_medidor2_data',
            'sistema_id',
            'instituciones_activas',
            'titulados_inicial',
            'titulados_primaria',
            'titulados_secundaria',
            'titulados_sum',
            'porcentajeTitulados',
            'porcentajeInstituciones_activas',
            'localesEducativos',
            'locales_tieneInternet',
            'porcentajeLocales_tieneInternet'
        ));
    }

    public function AEI_tempo()
    {
        $data = DB::select('call edu_pa_indicadorAEI()');

        $titulados_inicial = 0;
        $total_inicial = 0;
        $porcentajeTitulados_inicial = 0;

        $bilingues = 0;

        foreach ($data as $key => $item) {
            $titulados_inicial  = $item->titulados_inicial;
            $total_inicial = $item->total_inicial;

            $porcentajeTitulados_inicial =  round($titulados_inicial * 100 / ($total_inicial), 2);

            $bilingues = $item->bilingues;
        }

        return view('homeAEI', compact('titulados_inicial', 'porcentajeTitulados_inicial', 'bilingues'));
    }
}
