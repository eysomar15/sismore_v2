<?php

namespace App\Http\Controllers;

use App\Models\Administracion\Sistema;
use App\Models\Administracion\UsuarioPerfil;
use App\Models\Educacion\CentroPoblado;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\Matricula;
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
        $imp = Importacion::where('fuenteimportacion_id', '7')->select(DB::raw('max(id) as maximo'))->first();
        $data[] = ['name' => 'Centro Poblado', 'y' => CentroPobladoDatassRepositorio::listar_centroPoblado($imp->maximo)->conteo];
        $data[] = ['name' => 'con sistema de agua', 'y' => CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 20, $imp->maximo)['indicador'][0]->y];
        $data[] = ['name' => 'con disposición de excretas', 'y' => CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 23, $imp->maximo)['indicador2'][0]->y];
        $data[] = ['name' => 'con sistema de cloración', 'y' => CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 21, $imp->maximo)['indicador2'][0]->y];

        $query = CentroPobladoDatass::where('importacion_id', $imp->maximo)->select(
            DB::raw('sum(total_poblacion) as poblacion'),
            DB::raw('sum(poblacion_servicio_agua) as con_agua'),
            DB::raw('sum(total_viviendas) as viviendas'),
            DB::raw('sum(viviendas_conexion) as con_conexion')
        )->first();
        $data2[] = ['name' => 'población', 'y' => $query->poblacion];/* total_poblacion */
        $data2[] = ['name' => 'Cobertura de Agua', 'y' => $query->con_agua];/* poblacion_con_servicio_agua */
        $data2[] = ['name' => 'viviendas', 'y' => $query->con_conexion];/* total_viviendas */
        $data2[] = ['name' => 'viviendas con conexion', 'y' => $query->con_conexion];/* viviendas_con_conexion */

        $grafica[] = CentroPobladoRepositotio::listarporprovincias($imp->maximo);/* total de centro poblado por provincia */
        $grafica[] = CentroPobladoRepositotio::listarporprovinciasconsistemaagua($imp->maximo);/* total de centro poblado con servicio de agua(sistema_agua) */

        $grafica2[] = CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 20, $imp->maximo)['indicador'];
        $grafica2[] = CentroPobladoRepositotio::ListarSINO_porIndicador(0, 0, 23, $imp->maximo)['indicador2'];
        /* return $grafica2; */
        return view('home', compact('sistema_id', 'data', 'data2', 'grafica', 'grafica2'));
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
        $imp = ImportacionRepositorio::Max_yearPadronWeb();
        $imp2 = ImportacionRepositorio::Max_porfuente(8);
        $imp3 = ImportacionRepositorio::Max_porfuente(2);
        $mat = Matricula::where('importacion_id', $imp2)->first();
        //return MatriculaDetalleRepositorio::estudiantes_matriculadosEBR_EBE();
        if (count($imp) > 0) {
            $importacion_id = $imp['id'];

            $info['se'] = PadronWebRepositorio::count_institucioneducativa($imp['id']);
            $info['le'] = PadronWebRepositorio::count_localesescolares($imp['id']);
            $info['tm'] = MatriculaDetalleRepositorio::count_matriculados($mat->id);
            $info['do'] = PlazaRepositorio::count_docente($imp3);

            $info['g1'] = MatriculaDetalleRepositorio::estudiantes_matriculadosEBR_EBE_anual();
            $info['g2'] = PlazaRepositorio::docentes_conteo_anual();

            $info['g3'] = MatriculaDetalleRepositorio::estudiantes_matriculados_segungenero();
            $info['g4'] = PlazaRepositorio::docentes_segungenero_anual();

            $info['g5'] = MatriculaDetalleRepositorio::estudiantes_matriculados_seguntipogestion();
            $info['g6'] = PlazaRepositorio::docentes_seguntipogestion();

            $info['g7'] = MatriculaDetalleRepositorio::estudiantes_matriculados_segunareageografica();
            $info['g8'] = PlazaRepositorio::docentes_segunareageograficas();

            $info['g9'] = MatriculaDetalleRepositorio::estudiantes_matriculados_segunaugel();
            $info['g10'] = PlazaRepositorio::docentes_segunugel();

            /* $info['dt1'] = PadronWebRepositorio::listar_nivelmodalidadvsugelhombremujer($imp['id']);
            $info['dt2'] = PadronWebRepositorio::listar_nivelmodalidadvsugeldocentedirectores($imp['id']);
            $info['dt3'] = PadronWebRepositorio::listar_tipogestionvsprovinciaestudiantesdocente($imp['id']); */
            $info['dt4'] = MatriculaDetalleRepositorio::listar_estudiantesNivelProvinciaDistrito();
            //return $info['dt4'];
            return  view('home', compact('importacion_id', 'info', 'imp'));
        } else {
            $importacion_id = null;
            return  view('home', compact('importacion_id'));
        }
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
