<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Imports\tablaXImport;
use App\Models\Educacion\ImporMatricula;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\Matricula;
use App\Models\Parametro\Anio;
use App\Repositories\Educacion\ImporMatriculaRepositorio;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Utilities\Utilitario;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class ImporMatriculaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {
        /* $matricula = Matricula::where('importacion_id', 416)->first();
        return $matricula; */
        $mensaje = "";
        $anios = Anio::orderBy('anio', 'desc')->get();
        return view('educacion.ImporMatricula.Importar', compact('mensaje', 'anios'));
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
        $existeMismaFecha = ImportacionRepositorio::Importacion_PE($request->fechaActualizacion, 1);
        if ($existeMismaFecha != null) {
            $mensaje = "Error, Ya existe archivos prendientes de aprobar para la fecha de versión ingresada";
            $this->json_output(400, $mensaje);
        }

        $existeMismaFecha = ImportacionRepositorio::Importacion_PR($request->fechaActualizacion, 1);
        if ($existeMismaFecha != null) {
            $mensaje = "Error, Ya existe archivos procesados para la fecha de versión ingresada";
            $this->json_output(400, $mensaje);
        }

        $this->validate($request, ['file' => 'required|mimes:xls,xlsx']);
        $archivo = $request->file('file');
        $array = (new tablaXImport)->toArray($archivo);

        if (count($array) != 1) {
            $this->json_output(400, 'Error de Hojas, Solo debe tener una HOJA, el LIBRO EXCEL');
        }

        try {
            foreach ($array as $value) {
                foreach ($value as $celda => $row) {
                    if ($celda > 0) break;
                    $cadena =
                        $row['ugel'] . $row['departamento'] . $row['provincia'] . $row['distrito'] . $row['centro_poblado'] . $row['cod_mod'] . $row['institucion_educativa'] . $row['cod_nivelmod'] . $row['nivel_modalidad'] . $row['cod_ges_dep'] . $row['gestion_dependencia'] . $row['total_estudiantes'] . $row['matricula_definitiva'] . $row['matricula_proceso'] . $row['dni_validado'] . $row['dni_sin_validar'] . $row['registrado_sin_dni'] . $row['total_grados'] . $row['total_secciones'] . $row['nominas_generadas'] . $row['nominas_aprobadas'] . $row['nominas_por_rectificar'] . $row['tres_anios_hombre'] . $row['tres_anios_mujer'] . $row['cuatro_anios_hombre'] . $row['cuatro_anios_mujer'] . $row['cinco_anios_hombre'] . $row['cinco_anios_mujer'] . $row['primero_hombre'] . $row['primero_mujer'] . $row['segundo_hombre'] . $row['segundo_mujer'] . $row['tercero_hombre'] . $row['tercero_mujer'] . $row['cuarto_hombre'] . $row['cuarto_mujer'] . $row['quinto_hombre'] . $row['quinto_mujer'] . $row['sexto_hombre'] . $row['sexto_mujer'] . $row['cero_anios_hombre'] . $row['cero_anios_mujer'] . $row['un_anio_hombre'] . $row['un_anio_mujer'] . $row['dos_anios_hombre'] . $row['dos_anios_mujer'] . $row['mas_cinco_anios_hombre'] . $row['mas_cinco_anios_mujer'];
                }
            }
        } catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto";
            $this->json_output(403, $mensaje);
        }
        /* $mensaje = "Archivo excel subido y Procesado correctamente .";
        $this->json_output(200, $mensaje, $array ); */
        try {
            $importacion = Importacion::Create([
                'fuenteImportacion_id' => 8, // valor predeterminado
                'usuarioId_Crea' => auth()->user()->id,
                'usuarioId_Aprueba' => null,
                'fechaActualizacion' => $request['fechaActualizacion'],
                'comentario' => $request['comentario'],
                'estado' => 'PE'
            ]);

            $matricula = Matricula::Create([
                'importacion_id' => $importacion->id,
                'anio_id' => $request['anio'],
                'estado' => 'PE'
            ]);

            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    $padronWeb = ImporMatricula::Create([
                        'matricula_id' => $matricula->id,
                        'ugel' => $row['ugel'],
                        'departamento' => $row['departamento'],
                        'provincia' => $row['provincia'],
                        'distrito' => $row['distrito'],
                        'centro_poblado' => $row['centro_poblado'],
                        'cod_mod' => $row['cod_mod'],
                        'institucion_educativa' => $row['institucion_educativa'],
                        'cod_nivelmod' => $row['cod_nivelmod'],
                        'nivel_modalidad' => $row['nivel_modalidad'],
                        'cod_ges_dep' => $row['cod_ges_dep'],
                        'gestion_dependencia' => $row['gestion_dependencia'],
                        'total_estudiantes' => $row['total_estudiantes'],
                        'matricula_definitiva' => $row['matricula_definitiva'],
                        'matricula_proceso' => $row['matricula_proceso'],
                        'dni_validado' => $row['dni_validado'],
                        'dni_sin_validar' => $row['dni_sin_validar'],
                        'registrado_sin_dni' => $row['registrado_sin_dni'],
                        'total_grados' => $row['total_grados'],
                        'total_secciones' => $row['total_secciones'],
                        'nominas_generadas' => $row['nominas_generadas'],
                        'nominas_aprobadas' => $row['nominas_aprobadas'],
                        'nominas_por_rectificar' => $row['nominas_por_rectificar'],
                        'tres_anios_hombre' => $row['tres_anios_hombre'],
                        'tres_anios_mujer' => $row['tres_anios_mujer'],
                        'cuatro_anios_hombre' => $row['cuatro_anios_hombre'],
                        'cuatro_anios_mujer' => $row['cuatro_anios_mujer'],
                        'cinco_anios_hombre' => $row['cinco_anios_hombre'],
                        'cinco_anios_mujer' => $row['cinco_anios_mujer'],
                        'primero_hombre' => $row['primero_hombre'],
                        'primero_mujer' => $row['primero_mujer'],
                        'segundo_hombre' => $row['segundo_hombre'],
                        'segundo_mujer' => $row['segundo_mujer'],
                        'tercero_hombre' => $row['tercero_hombre'],
                        'tercero_mujer' => $row['tercero_mujer'],
                        'cuarto_hombre' => $row['cuarto_hombre'],
                        'cuarto_mujer' => $row['cuarto_mujer'],
                        'quinto_hombre' => $row['quinto_hombre'],
                        'quinto_mujer' => $row['quinto_mujer'],
                        'sexto_hombre' => $row['sexto_hombre'],
                        'sexto_mujer' => $row['sexto_mujer'],
                        'cero_anios_hombre' => $row['cero_anios_hombre'],
                        'cero_anios_mujer' => $row['cero_anios_mujer'],
                        'un_anio_hombre' => $row['un_anio_hombre'],
                        'un_anio_mujer' => $row['un_anio_mujer'],
                        'dos_anios_hombre' => $row['dos_anios_hombre'],
                        'dos_anios_mujer' => $row['dos_anios_mujer'],
                        'mas_cinco_anios_hombre' => $row['mas_cinco_anios_hombre'],
                        'mas_cinco_anios_mujer' => $row['mas_cinco_anios_mujer'],
                    ]);
                }
            }
        } catch (Exception $e) {
            $matricula->estado = 'EL';
            $matricula->save();

            $importacion->estado = 'EL';
            $importacion->save();

            $mensaje = "Error en la carga de datos, verifique los datos de su archivo y/o comuniquese con el administrador del sistema" . $e->getMessage();
            $this->json_output(400, $mensaje);
        }

        try {
            $procesar = DB::select('call edu_pa_procesarImporMatricula(?,?)', [$matricula->id, $importacion->usuarioId_Crea]);
        } catch (Exception $e) {
            $matricula->estado = 'EL';
            $matricula->save();

            $importacion->estado = 'EL';
            $importacion->save();

            $mensaje = "Error al procesar la normalizacion de datos." . $e;
            $tipo = 'danger';
            $this->json_output(400, $mensaje);
        }
        $mensaje = "Archivo excel subido y Procesado correctamente .";
        $this->json_output(200, $mensaje, '');
    }

    public function ListarDTImportFuenteTodos()
    {
        $data = ImportacionRepositorio::Listar_FuenteTodos('8');
        return datatables()
            ->of($data)
            ->editColumn('fechaActualizacion', '{{date("d-m-Y",strtotime($fechaActualizacion))}}')
            ->editColumn('estado', function ($query) {
                return $query->estado == "PR" ? "PROCESADO" : ($query->estado == "PE" ? "PENDIENTE" : "ELIMINADO");
            })
            ->addColumn('accion', function ($oo) {
                return '<button type="button" onclick="geteliminar(' . $oo->id . ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </button>';
            })
            ->rawColumns(['fechaActualizacion', 'estado', 'accion'])
            ->toJson();
    }

    public function ListaImportada($importacion_id)
    {
        //$padronWebLista = PadronWeb::all();                
        //return view('ImportarEducacion.PadronWebList',compact('padronWebLista'));

        return view('Educacion.ImporMatricula.ListaImportada', compact('importacion_id'));
    }

    public function ListaImportada_DataTable($importacion_id)
    {
        $padronWebLista = ImporMatriculaRepositorio::Listar_Por_Importacion_id($importacion_id);

        return  datatables()->of($padronWebLista)->toJson();;
    }

    public function aprobar($importacion_id)
    {
        $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);
        //Importacion::where('id',$importacion_id)->first();  

        return view('educacion.ImporMatricula.Aprobar', compact('importacion_id', 'importacion'));
    }

    public function procesar($importacion_id)
    {
        $procesar = DB::select('call edu_pa_procesarPadronWeb(?)', [$importacion_id]);
        return view('correcto');
    }

    public function eliminar($id)
    {
        $entidad = Importacion::find($id);
        $entidad->estado = 'EL';
        $entidad->save();

        $matricula = Matricula::where('importacion_id', $entidad->id)->first();
        $matricula->estado = 'EL';
        $matricula->save();

        return response()->json(array('status' => true));
    }
}
