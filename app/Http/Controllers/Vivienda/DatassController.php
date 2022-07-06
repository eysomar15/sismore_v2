<?php

namespace App\Http\Controllers\Vivienda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\Importacion;
use App\Models\Vivienda\Datass;
use App\Repositories\Educacion\ImportacionRepositorio;
use App\Repositories\Vivienda\DatassRepositorio;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DatassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {
        $mensaje = "";
        return view('Vivienda.Datass.Importar', compact('mensaje'));
    }

    public function guardar(Request $request)
    {
        $this->validate($request, ['file' => 'required|mimes:xls,xlsx']);
        $archivo = $request->file('file');
        $array = (new tablaXImport)->toArray($archivo);

        $i = 0;
        $cadena = '';

        try {
            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    if (++$i > 1) break;
                    $cadena =  $cadena .
                        $row['departamento'] .
                        $row['provincia'] .
                        $row['distrito'] .
                        $row['ubigeo_cp'] .
                        $row['centro_poblado']                        .
                        $row['zona_utm_wgs84']                        .
                        $row['coordenadas_este']                        .
                        $row['coordenadas_norte']                        .
                        $row['altitud']                        .
                        $row['total_viviendas'] .
                        $row['viviendas_habitadas'] .
                        $row['total_poblacion']                        .
                        $row['lengua_predominante'] .
                        $row['energia_electrica'] .
                        $row['internet']                        .
                        $row['establecimiento_salud'] .
                        $row['pronoei'] .
                        $row['primaria'] .
                        $row['secundaria']                        .
                        $row['establecimiento_salud_agua']                        .
                        $row['pronoei_agua']                        .
                        $row['primaria_agua']                        .
                        $row['secundaria_agua']                        .
                        $row['funciona_establecimiento_salud']                        .
                        $row['funciona_pronoei']                        .
                        $row['funciona_primaria']                        .
                        $row['funciona_secundaria']                        .
                        $row['establecimiento_salud_banios']                        .
                        $row['pronoei_banios']                        .
                        $row['primaria_banios']                        .
                        $row['secundaria_banios']                        .
                        $row['sistema_agua']                        .
                        $row['viviendas_conexion']                        .
                        $row['poblacion_servicio_agua']                        .
                        $row['sistema_disposicion_excretas'] .
                        $row['codigo_ps'] .
                        $row['prestador_servicio'] .
                        $row['tipo_organizacion_comunal'] .
                        $row['total_asociados'] .
                        $row['cuota_familiar'] .
                        $row['tipo_cobro'] .
                        $row['codigo_fuente'] .
                        $row['fuente_principal'] .
                        $row['tipo_fuente'] .
                        $row['servicio_agua_continuo'] .
                        $row['sistema_cloracion'] .
                        $row['realiza_cloracion'] .
                        $row['tipo_sistema_agua'] .
                        $row['tipo_sistema_cloracion'];
                }
            }
        } catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";
            return view('Vivienda.Datass.Importar', compact('mensaje'));
        }

        try {
            $importacion = Importacion::Create([
                'fuenteImportacion_id' => 7, // valor predeterminado
                'usuarioId_Crea' => auth()->user()->id,
                'usuarioId_Aprueba' => null,
                'fechaActualizacion' => $request['fechaActualizacion'],
                'comentario' => $request['comentario'],
                'estado' => 'PE'
            ]);

            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    // echo $row['cen_edu'].'<br>';
                    $Datass = Datass::Create([
                        'importacion_id' => $importacion->id,
                        'departamento' => $row['departamento'],
                        'provincia' => $row['provincia'],
                        'distrito' => $row['distrito'],
                        'ubigeo_cp' => $row['ubigeo_cp'],
                        'centro_poblado' => $row['centro_poblado'],
                        'zona_utm_wgs84' => $row['zona_utm_wgs84'],
                        'coordenadas_este' => $row['coordenadas_este'],
                        'coordenadas_norte' => $row['coordenadas_norte'],
                        'altitud' => $row['altitud'],
                        'total_viviendas' => $row['total_viviendas'],
                        'viviendas_habitadas' => $row['viviendas_habitadas'],
                        'total_poblacion' => $row['total_poblacion'],
                        'predomina_primera_lengua' => $row['lengua_predominante'],
                        'tiene_energia_electrica' => $row['energia_electrica'],
                        'tiene_internet' => $row['internet'],
                        'tiene_establecimiento_salud' => $row['establecimiento_salud'],
                        'pronoei' => $row['pronoei'],
                        'primaria' => $row['primaria'],
                        'secundaria' => $row['secundaria'],
                        'establecimiento_salud_agua' => $row['establecimiento_salud_agua'],
                        'pronoei_agua' => $row['pronoei_agua'],
                        'primaria_agua' => $row['primaria_agua'],
                        'secundaria_agua' => $row['secundaria_agua'],
                        'funciona_establecimiento_salud' => $row['funciona_establecimiento_salud'],
                        'funciona_pronoei' => $row['funciona_pronoei'],
                        'funciona_primaria' => $row['funciona_primaria'],
                        'funciona_secundaria' => $row['funciona_secundaria'],
                        'establecimiento_salud_banios' => $row['establecimiento_salud_banios'],
                        'pronoei_banios' => $row['pronoei_banios'],
                        'primaria_banios' => $row['primaria_banios'],
                        'secundaria_banios' => $row['secundaria_banios'],
                        'sistema_agua' => $row['sistema_agua'],
                        'viviendas_conexion' => $row['viviendas_conexion'],
                        'poblacion_servicio_agua' => $row['poblacion_servicio_agua'],
                        'sistema_disposicion_excretas' => $row['sistema_disposicion_excretas'],
                        'prestador_codigo' => $row['codigo_ps'],
                        'prestador_de_servicio_agua' => $row['prestador_servicio'],
                        'tipo_organizacion_comunal' => $row['tipo_organizacion_comunal'],
                        'total_asociados' => $row['total_asociados'],
                        'cuota_familiar' => $row['cuota_familiar'],
                        'tipo_cobro' => $row['tipo_cobro'],
                        'codigo_fuente' => $row['codigo_fuente'],
                        'fuente_principal' => $row['fuente_principal'],
                        'tipo_fuente' => $row['tipo_fuente'],
                        'servicio_agua_continuo' => $row['servicio_agua_continuo'],
                        'sistema_cloracion' => $row['sistema_cloracion'],
                        'realiza_cloracion_agua' => $row['realiza_cloracion'],
                        'tipo_sistema_agua' => $row['tipo_sistema_agua'],
                        'tipo_sistema_cloracion' => $row['tipo_sistema_cloracion'],
                    ]);
                }
            }
        } catch (Exception $e) {
            //$importacion->delete(); // elimina la importacion creada
            $importacion->estado = 'EL';
            $importacion->save();
            $mensaje = "Error en la carga de datos, comuniquese con el administrador del sistema";
            return view('Vivienda.Datass.Importar', compact('mensaje'));
        }

        //return 'ok';
        return redirect()->route('Datass.Datass_Lista', $importacion->id);
    }

    public function ListaImportada($importacion_id)
    {
        return view('Vivienda.Datass.ListaImportada', compact('importacion_id'));
    }

    public function ListaImportada_DataTable($importacion_id)
    {
        $Lista = DatassRepositorio::Listar_Por_Importacion_id($importacion_id);

        return  datatables()->of($Lista)->toJson();;
    }

    public function aprobar($importacion_id)
    {
        $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);

        return  view('Vivienda.Datass.Aprobar', compact('importacion_id', 'importacion'));
    }

    public function procesar($importacion_id)
    {
        $procesar = DB::select('call viv_pa_procesarDatass(?,?)', [$importacion_id, auth()->user()->id]);
        return view('correcto');
    }
}
