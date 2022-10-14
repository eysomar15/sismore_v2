<?php

namespace App\Http\Controllers\Educacion;

use App\Exports\ImporPadronNexusExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\CuadroAsigPersonal;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\Indicador;
use App\Repositories\Educacion\CuadroAsigPersonalRepositorio;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Repositories\Educacion\PlazaRepositorio;
use App\Utilities\Utilitario;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CuadroAsigPersonalController extends Controller
{
    public $fuente = 2;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {
        $mensaje = "";
        return view('educacion.CuadroAsigPersonal.Importar', compact('mensaje'));
    }

    public function exportar()
    {
        $imp = Importacion::where(['fuenteimportacion_id' => $this->fuente, 'estado' => 'PR'])->orderBy('fechaActualizacion', 'desc')->first();
        $mensaje = "";
        return view('educacion.CuadroAsigPersonal.Exportar', compact('mensaje', 'imp'));
    }

    function json_output($status = 200, $msg = 'OK!!', $data = null)
    {
        header('Content-Type:application/json');
        echo json_encode([
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ]);
        die;
    }

    public function guardar(Request $request)
    {
        $existeMismaFecha = ImportacionRepositorio::Importacion_PE($request->fechaActualizacion, 2);
        if ($existeMismaFecha != null) {
            $mensaje = "Error, Ya existe archivos prendientes de aprobar para la fecha de versión ingresada";
            $this->json_output(400, $mensaje);
        }

        $existeMismaFecha = ImportacionRepositorio::Importacion_PR($request->fechaActualizacion, 2);
        if ($existeMismaFecha != null) {
            $mensaje = "Error, Ya existe archivos procesados para la fecha de versión ingresada";
            $this->json_output(400, $mensaje);
        }

        $this->validate($request, ['file' => 'required|mimes:xls,xlsx']);
        $archivo = $request->file('file');
        $array = (new tablaXImport)->toArray($archivo);

        //$this->json_output(200, 'aqui tamos', $array);

        if (count($array) != 1) {
            $this->json_output(400, 'Error de Hojas, Solo debe tener una HOJA, el LIBRO EXCEL');
        }

        try {
            foreach ($array as $value) {
                foreach ($value as $celda => $row) {
                    if ($celda > 0) break;
                    $cadena =
                        $row['unidad_ejecutora'] .
                        $row['ugel'] .
                        $row['provincia'] .
                        $row['distrito'] .
                        $row['tipo_ie'] . //

                        $row['gestion'] .
                        $row['zona'] .
                        $row['codmod_ie'] .
                        $row['codigo_local'] .
                        $row['clave8'] .

                        $row['nivel_educativo'] .
                        $row['institucion_educativa'] .
                        $row['codigo_plaza'] .
                        $row['tipo_trabajador'] .
                        $row['sub_tipo_trabajador'] .

                        $row['cargo'] .
                        $row['situacion_laboral'] .
                        $row['motivo_vacante'] .
                        $row['documento'] .
                        $row['sexo'] .

                        $row['codmod_docente'] .
                        $row['apellido_paterno'] .
                        $row['apellido_materno'] .
                        $row['nombres'] .
                        $row['fecha_ingreso'] .

                        $row['categoria_remunerativa'] .
                        $row['jornada_laboral'] .
                        $row['estado'] .
                        $row['fecha_nacimiento'] .
                        $row['fecha_inicio'] .

                        $row['fecha_termino'] .
                        $row['tipo_registro'] .
                        $row['ley'] .
                        $row['preventiva'] .
                        $row['especialidad'] .

                        $row['tipo_estudios'] .
                        $row['estado_estudios'] .
                        $row['grado'] .
                        $row['mencion'] .
                        $row['especialidad_profesional'] .

                        $row['fecha_resolucion'] .
                        $row['numero_resolucion'] .
                        $row['centro_estudios'] .
                        $row['celular'] .
                        $row['email'] .

                        $row['desc_superior'];
                }
            }
        } catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar.<br>" . $e;
            $this->json_output(403, $mensaje);
        }

        try {
            $importacion = Importacion::Create([
                'fuenteImportacion_id' => 2, // valor predeterminado
                'usuarioId_Crea' => auth()->user()->id,
                'usuarioId_Aprueba' => null,
                'fechaActualizacion' => $request->fechaActualizacion,
                'comentario' => $request->comentario,
                'estado' => 'PE'
            ]);

            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    if ($row['unidad_ejecutora'] != NULL) {
                        $CuadroAsigPersonal = CuadroAsigPersonal::Create([
                            'importacion_id' => $importacion->id, //'region' => 'UCAYALI',
                            'unidad_ejecutora' => $row['unidad_ejecutora'],
                            'organo_intermedio' => $row['ugel'], // se va cambiar de nombre
                            'provincia' => $row['provincia'],
                            'distrito' => $row['distrito'],
                            'tipo_ie' => $row['tipo_ie'],
                            'gestion' => $row['gestion'],
                            'zona' => $row['zona'],
                            'codmod_ie' => $row['codmod_ie'],
                            'codigo_local' => $row['codigo_local'],
                            'clave8' => $row['clave8'],
                            'nivel_educativo' => $row['nivel_educativo'],
                            'institucion_educativa' => $row['institucion_educativa'],
                            'codigo_plaza' => $row['codigo_plaza'],
                            'tipo_trabajador' => $row['tipo_trabajador'],
                            'sub_tipo_trabajador' => $row['sub_tipo_trabajador'],
                            'cargo' => $row['cargo'],
                            'situacion_laboral' => $row['situacion_laboral'],
                            'motivo_vacante' => $row['motivo_vacante'],
                            'documento_identidad' => $row['documento'],
                            'sexo' => $row['sexo'],
                            'codigo_modular' => $row['codmod_docente'],
                            'apellido_paterno' => $row['apellido_paterno'],
                            'apellido_materno' => $row['apellido_materno'],
                            'nombres' => $row['nombres'],
                            'fecha_ingreso' => $row['fecha_ingreso'],
                            'categoria_remunerativa' => $row['categoria_remunerativa'],
                            'jornada_laboral' => $row['jornada_laboral'],
                            'estado' => $row['estado'],
                            'fecha_nacimiento' => $row['fecha_nacimiento'],
                            'fecha_inicio' => $row['fecha_inicio'],
                            'fecha_termino' => $row['fecha_termino'],
                            'tipo_registro' => $row['tipo_registro'],
                            'ley' => $row['ley'],
                            'preventiva' => $row['preventiva'], // 'referencia_preventiva'=>$row['referencia_preventiva'],
                            'especialidad' => $row['especialidad'],
                            'tipo_estudios' => $row['tipo_estudios'],
                            'estado_estudios' => $row['estado_estudios'],
                            'grado' => $row['grado'],
                            'mencion' => '' . trim($row['mencion']),
                            'especialidad_profesional' => $row['especialidad_profesional'],
                            'fecha_resolucion' => $row['fecha_resolucion'],
                            'numero_resolucion' => $row['numero_resolucion'],
                            'centro_estudios' => $row['centro_estudios'],
                            'celular' => $row['celular'],
                            'email' => $row['email'],
                            'desc_superior' => $row['desc_superior'],

                        ]);
                    }
                }
            }
        } catch (Exception $e) {
            $importacion->estado = 'EL';
            $importacion->save();

            $mensaje = "Error en la carga de datos, verifique los datos de su archivo y/o comuniquese con el administrador del sistema .<br>" . $e;
            $this->json_output(400, $mensaje);
        }

        try {
            $procesar = DB::select('call edu_pa_procesarCuadroAsigPersonal(?,?)', [$importacion->id, auth()->user()->id]);
        } catch (Exception $e) {
            $importacion->estado = 'EL';
            $importacion->save();

            $mensaje = "Error al procesar la normalizacion de datos.<br>" . $e;
            $this->json_output(400, $mensaje);
        }
        $mensaje = "Archivo excel subido y Procesado correctamente .";
        $this->json_output(200, $mensaje, '');
    }

    public function ListarDTImportFuenteTodos(Request $rq)
    {
        $draw = intval($rq->draw);
        $start = intval($rq->start);
        $length = intval($rq->length);

        $query = ImportacionRepositorio::Listar_FuenteTodos('2');
        $data = [];
        foreach ($query as $key => $value) {
            $nom = '';
            if (strlen($value->cnombre) > 0) {
                $xx = explode(' ', $value->cnombre);
                $nom = $xx[0];
            }
            $ape = '';
            if (strlen($value->capellidos) > 0) {
                $xx = explode(' ', $value->capellidos);
                $ape = $xx[0];
            }

            if (date('Y-m-d', strtotime($value->created_at)) == date('Y-m-d') || session('perfil_id') == 3 || session('perfil_id') == 8 || session('perfil_id') == 9 || session('perfil_id') == 10 || session('perfil_id') == 11)
                $boton = '<button type="button" onclick="geteliminar(' . $value->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>';
            else
                $boton = '';
            $boton2 = '<button type="button" onclick="monitor(' . $value->id . ')" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> </button>';
            $data[] = array(
                $key + 1,
                date("d/m/Y", strtotime($value->fechaActualizacion)),
                $value->fuente,
                $nom . ' ' . $ape,
                date("d/m/Y", strtotime($value->created_at)),
                $value->comentario,
                $value->estado == "PR" ? "PROCESADO" : ($value->estado == "PE" ? "PENDIENTE" : "ELIMINADO"),
                $boton /* . '&nbsp;' . $boton2, */
            );
        }
        $result = array(
            "draw" => $draw,
            "recordsTotal" => $start,
            "recordsFiltered" => $length,
            "data" => $data
        );
        return response()->json($result);
    }

    public function ListarDTImportFuenteTodosx()
    {
        $data = ImportacionRepositorio::Listar_FuenteTodos('2');
        return datatables()
            ->of($data)
            ->editColumn('fechaActualizacion', '{{date("d/m/Y",strtotime($fechaActualizacion))}}')
            ->editColumn('created_at', '{{date("d/m/Y",strtotime($created_at))}}')
            ->editColumn('estado', function ($query) {
                return $query->estado == "PR" ? "PROCESADO" : ($query->estado == "PE" ? "PENDIENTE" : "ELIMINADO");
            })
            ->addColumn('accion', function ($oo) {
                if (date('Y-m-d', strtotime($oo->created_at)) == date('Y-m-d') || session('perfil_id') == 3 || session('perfil_id') == 8 || session('perfil_id') == 9 || session('perfil_id') == 10 || session('perfil_id') == 11)
                    $msn = '<button type="button" onclick="geteliminar(' . $oo->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>';
                else
                    $msn = '';
                return $msn;
            })
            ->addColumn('nombrecompleto', function ($oo) {
                $nom = '';
                if (strlen($oo->cnombre) > 0) {
                    $xx = explode(' ', $oo->cnombre);
                    $nom = $xx[0];
                }
                $ape = '';
                if (strlen($oo->capellidos) > 0) {
                    $xx = explode(' ', $oo->capellidos);
                    $ape = $xx[0];
                }
                return $nom . ' ' . $ape;
            })
            ->rawColumns(['fechaActualizacion', 'estado', 'accion', 'nombrecompleto'])
            ->toJson();
    }

    public function ListaImportada(Request $rq)
    {
        $id = $rq->importacion_id;
        $data = PlazaRepositorio::listaImportada($id);
        return DataTables::of($data)->make(true);
    }

    public function ListaImportada_DataTable($importacion_id)
    {
        $Lista = CuadroAsigPersonalRepositorio::Listar_Por_Importacion_id($importacion_id);

        return  datatables()->of($Lista)->toJson();;
    }

    public function aprobar($importacion_id)
    {
        $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);

        return view('educacion.CuadroAsigPersonal.Aprobar', compact('importacion_id', 'importacion'));
    }

    public function procesar($importacion_id)
    {
        $procesar = DB::select('call edu_pa_procesarCuadroAsigPersonal(?,?)', [$importacion_id, auth()->user()->id]);
        return view('correcto');
    }
    public function download()
    {
        $name = 'NEXUS ' . date('Y-m-d') . '.xlsx';
        return Excel::download(new ImporPadronNexusExport, $name);
    }

    //**************************************************************************************** */
    public function Principal()
    {

        return view('educacion.CuadroAsigPersonal.Principal');
    }

    public function reporteUgel()
    {
        $lista_principal = CuadroAsigPersonalRepositorio::cuadro_ugel();
        $lista_ugel_nivel = CuadroAsigPersonalRepositorio::cuadro_ugel_nivel();
        $lista_ugel_tipoTrab = CuadroAsigPersonalRepositorio::cuadro_ugel_tipoTrab();


        return view('educacion.CuadroAsigPersonal.ReporteUgel', compact('lista_principal', 'lista_ugel_nivel', 'lista_ugel_tipoTrab'));
    }

    public function reporteDistrito()
    {
    }

    public function reportePedagogico()
    {
        $indicador = Indicador::find(35);
        $title = $indicador->nombre;
        $importacion_id = 0;
        $ultima_Plaza = CuadroAsigPersonalRepositorio::ultima_importacion_dePlaza();

        if ($ultima_Plaza->first() != null) {
            $fecha_texto = Utilitario::fecha_formato_texto_completo($ultima_Plaza->first()->fechaActualizacion);
            $importacion_id = $ultima_Plaza->first()->importacion_id;
        }


        $fecha_version = 'Ultima actualización: ' . $fecha_texto;

        $Lista = CuadroAsigPersonalRepositorio::docentes_pedagogico('Primaria', $importacion_id);

        $sumaPedagogico = 0;
        $sumaTotal = 0;
        $puntos = [];

        //->sortByDesc('hombres') solo para dar una variacion a los colores del grafico
        foreach ($Lista as $key => $item) {
            $sumaPedagogico += $item->pedagogico;
            $sumaTotal += $item->total;
        }

        $puntos[] = ['name' => 'Pedagógico', 'y' => floatval($sumaPedagogico * 100 / $sumaTotal)];
        $puntos[] = ['name' => 'No Pedagógico', 'y' => floatval(($sumaTotal - $sumaPedagogico) * 100 / $sumaTotal)];

        $contenedor = 'resumen_por_ugel'; //nombre del contenedor para el grafico
        $titulo_grafico = 'Docentes Título Pedagógico - Nivel Primaria';

        return  view(
            'educacion.CuadroAsigPersonal.ReportePedagogico',
            ["dataCircular" => json_encode($puntos)],
            compact('Lista', 'title', 'contenedor', 'titulo_grafico', 'fecha_version')
        );
    }

    public function reporteBilingues()
    {

        $indicador = Indicador::find(37);
        $title = $indicador->nombre;
        $ultima_Plaza = CuadroAsigPersonalRepositorio::ultima_importacion_dePlaza();

        $importacion_id = 0;
        if ($ultima_Plaza->first() != null) {
            $fecha_texto = Utilitario::fecha_formato_texto_completo($ultima_Plaza->first()->fechaActualizacion);
            $importacion_id = $ultima_Plaza->first()->importacion_id;
        }


        $dataCabecera = CuadroAsigPersonalRepositorio::docentes_bilingues($importacion_id);
        $lista = CuadroAsigPersonalRepositorio::docentes_bilingues_ugel($importacion_id);


        $fecha_version = 'Ultima actualización: ' . $fecha_texto;

        /************* GRAFICO TORTA*******************/
        $sumaBilingue = 0;
        $sumaTotal = 0;
        $puntos = [];

        //->sortByDesc('hombres') solo para dar una variacion a los colores del grafico
        foreach ($lista as $key => $item) {
            $sumaBilingue += $item->Bilingue;
            $sumaTotal += $item->total;
        }

        $puntos[] = ['name' => 'Bilingue', 'y' => floatval($sumaBilingue * 100 / $sumaTotal)];
        $puntos[] = ['name' => 'No Bilingue', 'y' => floatval(($sumaTotal - $sumaBilingue) * 100 / $sumaTotal)];

        $contenedor = 'resumen_bilingue'; //nombre del contenedor para el grafico
        $titulo_grafico = 'Docentes Bilingues';


        return  view(
            'educacion.CuadroAsigPersonal.ReporteBilingues',
            ["dataCircular" => json_encode($puntos)],
            compact('lista', 'dataCabecera', 'title', 'contenedor', 'titulo_grafico', 'fecha_version', 'importacion_id')
        );
    }

    public function GraficoBarrasPrincipal($importacion_id)
    {
        $docentes_bilingues_nivel = CuadroAsigPersonalRepositorio::docentes_bilingues_nivel($importacion_id);

        /************* GRAFICO BARRAS*******************/
        $categoria_nombres = [];
        $recorre = 1;

        // array_merge concatena los valores del arreglo, mientras recorre el foreach
        foreach ($docentes_bilingues_nivel as $key => $lista) {

            $data = [];
            $data = array_merge($data, [intval($lista->Bilingue)]);
            $puntos[] = ['name' => $lista->nivel_educativo, 'data' =>  $data];
        }

        $categoria_nombres[] = 'Niveles';

        $titulo = 'Total Docentes Bilingues por Niveles Educativos';
        $subTitulo = 'Fuente - NEXUS';
        $titulo_y = 'Numero de Docentes Bilingues';

        $nombreGraficoBarra = 'barra1'; // este nombre va de la mano con el nombre del DIV en la vista

        return view(
            'graficos.Barra',
            ["data" => json_encode($puntos), "categoria_nombres" => json_encode($categoria_nombres)],
            compact('titulo_y', 'titulo', 'subTitulo', 'nombreGraficoBarra')
        );
    }


    public function filtro_gestion($gestion)
    {
        $filtro = "";

        if ($gestion == 1)
            $filtro = "NOT( tipo_ie LIKE '%xyz%')"; //este filtro hace que la consulta traiga los datos de publicas y privadas
        else {
            if ($gestion == 2)
                $filtro = "NOT( tipo_ie LIKE '%particular%' or tipo_ie LIKE '%privada%')";
            else
                $filtro = "( tipo_ie LIKE '%particular%' or tipo_ie LIKE '%privada%')";
        }

        return  $filtro;
    }

    /*********************** DOCENTES ******************************** */
    public function DocentesPrincipal()
    {
        //return PlazaRepositorio::listar_anios();
        //return PlazaRepositorio::listar_meses(2022);
        //return PlazaRepositorio::listar_importados(2022,2);
        //$fechas = null;
        //return PlazaRepositorio::listar_docentes_ugel(373);
        $anios = PlazaRepositorio::listar_anios(); // CuadroAsigPersonalRepositorio::plazas_anio();
        /*  if ($anios->first() != null) {
            $fechas =  CuadroAsigPersonalRepositorio::plazas_fechas($anios->first()->anio);
        } */
        return view('educacion.CuadroAsigPersonal.DocentesPrincipal', compact('anios'));/* , 'fechas' */
    }

    public function DocentesReportePrincipal($tipoTrab_id, $importacion_id)
    {
        $plazas_porTipoTrab = CuadroAsigPersonalRepositorio::docentes_porUgel($importacion_id);
        // $plazas_Titulados = CuadroAsigPersonalRepositorio::plazas_docentes_Titulados($importacion_id);

        return view('educacion.CuadroAsigPersonal.DocentesReportePrincipal', compact('plazas_porTipoTrab'));
    }

    public function GraficoBarras_DocentesPrincipal($tipoTrab_id, $importacion_id)
    {
        $plazas_Titulados = CuadroAsigPersonalRepositorio::plazas_docentes_Titulados($importacion_id);

        /************* GRAFICO BARRAS*******************/
        $categoria_nombres = [];
        $recorre = 1;

        // array_merge concatena los valores del arreglo, mientras recorre el foreach
        foreach ($plazas_Titulados as $key => $lista) {

            $data = [];
            $data = array_merge($data, [intval($lista->Titulados)]);
            $data = array_merge($data, [intval($lista->noTitulados)]);

            $puntos[] = ['name' => $lista->ugel, 'data' =>  $data];
        }

        $categoria_nombres[] = 'TITULADOS';
        $categoria_nombres[] = 'NO TITULADOS';

        $nombreGraficoBarra = 'barra1'; // este nombre va de la mano con el nombre del DIV en la vista
        $titulo = 'Docentes Titulados vs No Titulados';
        $subTitulo = 'Fuente - NEXUS';
        $titulo_y = 'Numero de Docentes';

        return view(
            'graficos.Barra',
            ["data" => json_encode($puntos), "categoria_nombres" => json_encode($categoria_nombres)],
            compact('titulo_y', 'titulo', 'subTitulo', 'nombreGraficoBarra')
        );
    }

    public function GraficoBarras_DocentesNivelEducativo($tipoTrab_id, $importacion_id)
    {
        $plazas_nivelEducativo = CuadroAsigPersonalRepositorio::plazas_docentes_nivelEducativo($importacion_id);
        /************* GRAFICO BARRAS*******************/
        $categoria_nombres = [];
        $recorre = 1;

        // array_merge concatena los valores del arreglo, mientras recorre el foreach
        foreach ($plazas_nivelEducativo as $key => $lista) {

            $data = [];
            $data = array_merge($data, [intval($lista->cantidad)]);
            $puntos[] = ['name' => $lista->nivel_educativo, 'data' =>  $data];
        }

        $categoria_nombres[] = 'NIVELES';

        $nombreGraficoBarra = 'barra2'; // este nombre va de la mano con el nombre del DIV en la vista
        $titulo = 'Docentes por Niveles Educativos';
        $subTitulo = 'Fuente: NEXUS';
        $titulo_y = 'Numero de Docentes';

        return view(
            'graficos.Barra',
            ["data" => json_encode($puntos), "categoria_nombres" => json_encode($categoria_nombres)],
            compact('titulo_y', 'titulo', 'subTitulo', 'nombreGraficoBarra')
        );
    }

    public function GraficoBarras_Docentes_Ugeles($importacion_id)
    {
        $plazas_porTipoTrab = CuadroAsigPersonalRepositorio::docentes_porUgel($importacion_id);
        /************* GRAFICO BARRAS*******************/
        $categoria_nombres = [];
        $recorre = 1;

        // array_merge concatena los valores del arreglo, mientras recorre el foreach
        foreach ($plazas_porTipoTrab as $key => $lista) {

            $data = [];
            $data = array_merge($data, [intval($lista->cantidad)]);
            $puntos[] = ['name' => $lista->ugel, 'data' =>  $data];
        }

        $categoria_nombres[] = 'UGEL';

        $nombreGraficoBarra = 'GraficoBarras_Docentes_Ugeles'; // este nombre va de la mano con el nombre del DIV en la vista
        $titulo = 'DOCENTES POR UGEL';
        $subTitulo = 'Fuente: NEXUS';
        $titulo_y = 'Numero de Docentes';

        return view(
            'graficos.Barra',
            ["data" => json_encode($puntos), "categoria_nombres" => json_encode($categoria_nombres)],
            compact('titulo_y', 'titulo', 'subTitulo', 'nombreGraficoBarra')
        );
    }
}
