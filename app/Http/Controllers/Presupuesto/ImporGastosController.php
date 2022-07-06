<?php

namespace App\Http\Controllers\Presupuesto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\Importacion;
use App\Models\Presupuesto\ImporGastos;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ImporGastosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {
        $mensaje = "";
        return view('presupuesto.ImporGastos.Importar', compact('mensaje'));
    }

    public function importarGuardar(Request $request)
    {
        ini_set('memory_limit', '-1');
        $this->validate($request, ['file' => 'required|mimes:xls,xlsx']);
        $archivo = $request->file('file');
        $array = (new tablaXImport)->toArray($archivo);

        $i = 0;
        $cadena = '';
        try {
            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    if (++$i > 1) break;
                    $cadena =  $cadena
                        . $row['anio'] . $row['mes'] . $row['cod_uni_eje'] . $row['unidad_ejecutora'] . $row['cod_distrito']
                        . $row['sec_func'] . $row['cod_cat_pres'] . $row['categoria_presupuestal'] . $row['tipo_prod_proy'] . $row['cod_prod_proy']
                        . $row['producto_proyecto'] . $row['tipo_act_acc_obra'] . $row['cod_act_acc_obra'] . $row['actividad_accion_obra'] . $row['cod_funcion']
                        . $row['funcion'] . $row['cod_div_fun'] . $row['division_funcional'] . $row['cod_gru_fun'] . $row['grupo_funcional']

                        . $row['cod_finalidad'] . $row['meta_nombre'] . $row['cod_fue_fin'] . $row['fuente_financiamiento'] . $row['cod_rubro']
                        . $row['rubro'] . $row['cod_tipo_rec'] . $row['tipo_recurso'] . $row['cod_categ_gasto'] . $row['categoria_gasto']
                        . $row['tipo_trans'] . $row['cod_gen'] . $row['generica'] . $row['cod_subgen'] . $row['subgenerica']
                        . $row['cod_subgen_det'] . $row['subgenerica_detalle'] . $row['cod_espe'] . $row['especifica'] . $row['cod_espe_det']

                        . $row['especifica_detalle'] . $row['monto_pia'] . $row['monto_pim'] . $row['monto_certificado'] . $row['monto_comprometido_anual']
                        . $row['monto_comprometido'] . $row['monto_devengado'] . $row['monto_girado'];
                }
            }
        } catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto y vuelva a importar";
            return view('presupuesto.ImporGastos.Importar', compact('mensaje'));
        }

        try {
            $importacion = Importacion::Create([
                'fuenteImportacion_id' => 12, // valor predeterminado
                'usuarioId_Crea' => auth()->user()->id,
                'usuarioId_Aprueba' => null,
                'fechaActualizacion' => $request['fechaActualizacion'],
                'comentario' => $request['comentario'],
                'estado' => 'PE'
            ]);

            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    $gastos = ImporGastos::Create([
                        'importacion_id' => $importacion->id,
                        'anio' => $row['anio'],
                        'mes' => $row['mes'],
                        'cod_uni_eje' => $row['cod_uni_eje'],
                        'unidad_ejecutora' => $row['unidad_ejecutora'],
                        'cod_distrito' => $row['cod_distrito'],
                        'sec_func' => $row['sec_func'],
                        'cod_cat_pres' => $row['cod_cat_pres'],
                        'categoria_presupuestal' => $row['categoria_presupuestal'],
                        'tipo_prod_proy' => $row['tipo_prod_proy'],
                        'cod_prod_proy' => $row['cod_prod_proy'],
                        'producto_proyecto' => $row['producto_proyecto'],
                        'tipo_act_acc_obra' => $row['tipo_act_acc_obra'],
                        'cod_act_acc_obra' => $row['cod_act_acc_obra'],
                        'actividad_accion_obra' => $row['actividad_accion_obra'],
                        'cod_funcion' => $row['cod_funcion'],
                        'funcion' => $row['funcion'],
                        'cod_div_fun' => $row['cod_div_fun'],
                        'division_funcional' => $row['division_funcional'],
                        'cod_gru_fun' => $row['cod_gru_fun'],
                        'grupo_funcional' => $row['grupo_funcional'],
                        'cod_finalidad' => $row['cod_finalidad'],
                        'meta_nombre' => $row['meta_nombre'],
                        'cod_fue_fin' => $row['cod_fue_fin'],
                        'fuente_financiamiento' => $row['fuente_financiamiento'],
                        'cod_rubro' => $row['cod_rubro'],
                        'rubro' => $row['rubro'],
                        'cod_tipo_rec' => $row['cod_tipo_rec'],
                        'tipo_recurso' => $row['tipo_recurso'],
                        'cod_categ_gasto' => $row['cod_categ_gasto'],
                        'categoria_gasto' => $row['categoria_gasto'],
                        'tipo_trans' => $row['tipo_trans'],
                        'cod_gen' => $row['cod_gen'],
                        'generica' => $row['generica'],
                        'cod_subgen' => $row['cod_subgen'],
                        'subgenerica' => $row['subgenerica'],
                        'cod_subgen_det' => $row['cod_subgen_det'],
                        'subgenerica_detalle' => $row['subgenerica_detalle'],
                        'cod_espe' => $row['cod_espe'],
                        'especifica' => $row['especifica'],
                        'cod_espe_det' => $row['cod_espe_det'],
                        'especifica_detalle' => $row['especifica_detalle'],
                        'monto_pia' => $row['monto_pia'],
                        'monto_pim' => $row['monto_pim'],
                        'monto_certificado' => $row['monto_certificado'],
                        'monto_comprometido_anual' => $row['monto_comprometido_anual'],
                        'monto_comprometido' => $row['monto_comprometido'],
                        'monto_devengado' => $row['monto_devengado'],
                        'monto_girado' => $row['monto_girado'],
                    ]);
                }
            }
        } catch (Exception $e) {
            ImporGastos::where('importacion_id', $importacion->id)->delete();
            DB::statement('ALTER TABLE pres_impor_gastos AUTO_INCREMENT 1');
            $importacion->delete();
            $mensaje = "Error en la carga de datos, comuniquese con el administrador del sistema \n" . $e->getMessage();
            return view('presupuesto.ImporGastos.Importar', compact('mensaje'));
        }

         $procesar = DB::select('call pres_pa_procesarImporGastos(?)', [$importacion->id]);// que sera esto :o :o :o  XDXDXD
        return view('correcto');

        //return 'todo OK'; //redirect()->route('pemapacopsa.listado', $importacion->id);
        /* $mensaje = "Proceso terminado...";
        return view('presupuesto.ImporGastos.Importar', compact('mensaje')); */
    }
    /* 
    
    public function importarListado($importacion_id)
    {
        return view('Vivienda.PadronEmapacopsa.ListaImportada', compact('importacion_id'));
    }
    public function importarListadoDT($importacion_id)
    {
        $Lista = PadronEmapacopsaRepositorio::ListarImportados($importacion_id);

        return  datatables()->of($Lista)->toJson();
    }
    public function importarAprobar($importacion_id)
    {
        $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);
        return  view('Vivienda.PadronEmapacopsa.Aprobar', compact('importacion_id', 'importacion'));
    }

    public function importarAprobarGuardar($importacion_id)
    {
        $procesar = DB::select('call viv_pa_procesarEmapacopsa(?)', [$importacion_id]);// que sera esto :o :o :o  XDXDXD
        return view('correcto');
    } */
}
