<?php

use App\Http\Controllers\Administracion\EntidadController;
use App\Http\Controllers\Administracion\MenuController;
use App\Http\Controllers\Administracion\PerfilController;
use App\Http\Controllers\Administracion\SistemaController;
use App\Http\Controllers\Administracion\UsuarioController;
use App\Http\Controllers\Educacion\CensoController;
use App\Http\Controllers\Educacion\CuadroAsigPersonalController;
use App\Http\Controllers\Educacion\ImportacionController;
use App\Http\Controllers\Educacion\EceController;
use App\Http\Controllers\Educacion\IndicadorController;
use App\Http\Controllers\Educacion\InstEducativaController;
use App\Http\Controllers\Educacion\MatriculaController;
use App\Http\Controllers\Educacion\PadronEIBController;
use App\Http\Controllers\Educacion\ImporPadronWebController;
use App\Http\Controllers\Educacion\ImporMatriculaController;
use App\Http\Controllers\Educacion\ImporPadronEibController;
use App\Http\Controllers\Educacion\MatriculaDetalleController;
use App\Http\Controllers\Educacion\NivelModalidadController;
use App\Http\Controllers\Educacion\PadronWebController;
use App\Http\Controllers\Educacion\PLazaController;
use App\Http\Controllers\Educacion\TabletaController;
use App\Http\Controllers\Educacion\TextosEscolaresController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Parametro\ClasificadorController;
use App\Http\Controllers\Parametro\FuenteImportacionController;
use App\Http\Controllers\Presupuesto\ImporGastosController;
use App\Http\Controllers\Presupuesto\ImporIngresosController;
use App\Http\Controllers\Trabajo\ActividadController;
use App\Http\Controllers\Trabajo\AnuarioEstadisticoController;
use App\Http\Controllers\Trabajo\IndicadorTrabajoController;
use App\Http\Controllers\Trabajo\ProEmpleoController;
use App\Http\Controllers\Vivienda\CentroPobladoController;
use App\Http\Controllers\Vivienda\CentroPobladoDatassController;
use App\Http\Controllers\Vivienda\DatassController;
use App\Http\Controllers\Vivienda\EmapacopsaController;
use App\Http\Controllers\Vivienda\PadronEmapacopsaController;
use App\Models\Vivienda\CentroPobladoDatass;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!



|
*/
/* kjdfsdfksdfksdjkfjkdsf */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/{sistemas_id}', [HomeController::class, 'sistema_acceder'])->name('sistema_acceder');

Route::get('/AEI', [HomeController::class, 'AEI_tempo'])->name('AEI_tempo');





/**************************************** EDUCACION ************************************************/
Route::get('/Home/gra1', [HomeController::class, 'homegrafica1'])->name('graficas.home.educacion.1');
Route::get('/Home/gra2', [HomeController::class, 'homegrafica2'])->name('graficas.home.educacion.2');
Route::get('/Home/gra3', [HomeController::class, 'homegrafica3'])->name('graficas.home.educacion.3');
Route::get('/Home/gra4', [HomeController::class, 'homegrafica4'])->name('graficas.home.educacion.4');
Route::get('/Home/gra5', [HomeController::class, 'homegrafica5'])->name('graficas.home.educacion.5');
Route::get('/Home/gra6', [HomeController::class, 'homegrafica6'])->name('graficas.home.educacion.6');

Route::get('/NivelModalidad/Buscar/{tipo}', [NivelModalidadController::class, 'buscarnivelmodalidad']);

Route::get('/ImporPadronWeb/Importar', [ImporPadronWebController::class, 'importar'])->name('ImporPadronWeb.importar');
Route::post('/ImporPadronWeb/Importar', [ImporPadronWebController::class, 'guardar'])->name('ImporPadronWeb.guardar');
Route::get('/ImporPadronWeb/ListaImportada/{importacion_id}', [ImporPadronWebController::class, 'ListaImportada'])->name('ImporPadronWeb.PadronWeb_Lista');
Route::get('/ImporPadronWeb/ListaImportada_DataTable/{importacion_id}', [ImporPadronWebController::class, 'ListaImportada_DataTable'])->name('ImporPadronWeb.ListaImportada_DataTable');
Route::get('/ImporPadronWeb/Aprobar/{importacion_id}', [ImporPadronWebController::class, 'aprobar'])->name('ImporPadronWeb.aprobar');
Route::post('/ImporPadronWeb/Aprobar/procesar/{importacion_id}', [ImporPadronWebController::class, 'procesar'])->name('ImporPadronWeb.procesar');
Route::get('/ImporPadronWeb/Listar/ImportarDT', [ImporPadronWebController::class, 'ListarDTImportFuenteTodos'])->name('ImporPadronWeb.listar.importados');

Route::get('/PadronWeb/codigo_modular/{codigo_modular}', [PadronWebController::class, 'buscariiee']);

Route::get('/FuenteImportacion/cargar/{sistema_id}', [FuenteImportacionController::class, 'cargar']);

Route::get('/ImporMatricula/Importar', [ImporMatriculaController::class, 'importar'])->name('ImporMatricula.importar');
Route::post('/ImporMatricula/Importar', [ImporMatriculaController::class, 'guardar'])->name('ImporMatricula.guardar');
Route::post('/ImporMatricula/ListaImportada/{importacion_id}', [ImporMatriculaController::class, 'ListaImportada'])->name('ImporMatricula.listarimportados');
Route::get('/ImporMatricula/ListaImportada_DataTable/{importacion_id}', [ImporMatriculaController::class, 'ListaImportada_DataTable'])->name('ImporMatricula.ListaImportada_DataTable');
//Route::get('/ImporMatricula/Aprobar/{importacion_id}', [ImporMatriculaController::class, 'aprobar'])->name('ImporMatricula.aprobar');
//Route::post('/ImporMatricula/Aprobar/procesar/{importacion_id}', [ImporMatriculaController::class, 'procesar'])->name('ImporMatricula.procesar');
Route::get('/ImporMatricula/Listar/ImportarDT', [ImporMatriculaController::class, 'ListarDTImportFuenteTodos'])->name('ImporMatricula.listar.importados');
Route::get('/ImporMatricula/eliminar/{id}', [ImporMatriculaController::class, 'eliminar']);

/* Route::get('/PadronEIB/Importar', [PadronEIBController::class, 'importar'])->name('PadronEIB.importar');
Route::post('/PadronEIB/Importar', [PadronEIBController::class, 'guardar'])->name('PadronEIB.guardar');
Route::get('/PadronEIB/Listar/ImportarDT', [PadronEIBController::class, 'ListarDTImportFuenteTodos'])->name('PadronEIB.listar.importados'); */

Route::post('/PadronEIB/ajax_add_opt1/', [PadronEIBController::class, 'ajax_add_opt1'])->name('padroneib.ajax.add.opt1');
Route::get('/PadronEIB/ajax_delete_opt1/{idpadroneib}', [PadronEIBController::class, 'ajax_delete_opt1']); //->name('padroneib.ajax.delete.opt1');



Route::get('/ImporPadronEIB/Importar', [ImporPadronEibController::class, 'importar'])->name('PadronEIB.importar');
Route::post('/ImporPadronEIB/Importar', [ImporPadronEibController::class, 'guardar'])->name('imporpadroneib.guardar');
Route::get('/ImporPadronEIB/Listar/ImportarDT', [ImporPadronEibController::class, 'ListarDTImportFuenteTodos'])->name('imporpadroneib.listar.importados');
Route::post('/ImporPadronEIB/ListaImportada/{importacion_id}', [ImporPadronEibController::class, 'ListaImportada'])->name('imporpadroneib.listarimportados');
Route::get('/ImporPadronEIB/eliminar/{id}', [ImporPadronEibController::class, 'eliminar']);

Route::get('/TextosEscolares/Importar', [TextosEscolaresController::class, 'importar'])->name('TextosEscolares.importar');
Route::post('/TextosEscolares/Importar', [TextosEscolaresController::class, 'guardar'])->name('TextosEscolares.guardar');
Route::get('/TextosEscolares/Principal', [TextosEscolaresController::class, 'principal'])->name('TextosEscolares.principal');
Route::post('/TextosEscolares/Fechas/{anio_id}', [TextosEscolaresController::class, 'Fechas'])->name('TextosEscolares.Fechas');
Route::post('/TextosEscolares/ReporteUgel/{importacion_id}', [TextosEscolaresController::class, 'ReporteUgel'])->name('TextosEscolares.ReporteUgel');

Route::get('/CuadroAsigPersonal/Importar', [CuadroAsigPersonalController::class, 'importar'])->name('CuadroAsigPersonal.importar');
Route::post('/CuadroAsigPersonal/Importar', [CuadroAsigPersonalController::class, 'guardar'])->name('CuadroAsigPersonal.guardar');
Route::post('/CuadroAsigPersonal/ListaImportada/{importacion_id}', [CuadroAsigPersonalController::class, 'ListaImportada'])->name('CuadroAsigPersonal.listarimportados');
Route::get('/CuadroAsigPersonal/ListaImportada_DataTable/{importacion_id}', [CuadroAsigPersonalController::class, 'ListaImportada_DataTable'])->name('CuadroAsigPersonal.ListaImportada_DataTable');
Route::get('/CuadroAsigPersonal/Aprobar/{importacion_id}', [CuadroAsigPersonalController::class, 'aprobar'])->name('CuadroAsigPersonal.aprobar');
Route::post('/CuadroAsigPersonal/Aprobar/procesar/{importacion_id}', [CuadroAsigPersonalController::class, 'procesar'])->name('CuadroAsigPersonal.procesar');

Route::get('/CuadroAsigPersonal/Principal', [CuadroAsigPersonalController::class, 'Principal'])->name('CuadroAsigPersonal.principal');
Route::post('/CuadroAsigPersonal/ReporteUgel', [CuadroAsigPersonalController::class, 'ReporteUgel'])->name('CuadroAsigPersonal.ReporteUgel');
Route::post('/CuadroAsigPersonal/ReporteDistrito', [CuadroAsigPersonalController::class, 'ReporteDistrito'])->name('CuadroAsigPersonal.ReporteDistrito');
Route::get('/CuadroAsigPersonal/ReportePedagogico', [CuadroAsigPersonalController::class, 'ReportePedagogico'])->name('CuadroAsigPersonal.ReportePedagogico');
Route::get('/CuadroAsigPersonal/ReporteBilingues', [CuadroAsigPersonalController::class, 'ReporteBilingues'])->name('CuadroAsigPersonal.Bilingues');
Route::post('/CuadroAsigPersonal/ReporteBilingues/GraficoBarrasPrincipal/{anio_id}', [CuadroAsigPersonalController::class, 'GraficoBarrasPrincipal'])->name('CuadroAsigPersonal.BilinguesGraficoBarrasPrincipal');


Route::post('/CuadroAsigPersonal/Docentes/ReportePrincipal/{tipoTrab_id}/{importacion_id}', [CuadroAsigPersonalController::class, 'DocentesReportePrincipal'])->name('Docentes.ReportePrincipal');
Route::post('/CuadroAsigPersonal/Docentes/GraficoBarras_DocentesPrincipal/{tipoTrab_id}/{importacion_id}', [CuadroAsigPersonalController::class, 'GraficoBarras_DocentesPrincipal'])->name('Docentes.GraficoBarras_DocentesPrincipal');
Route::post('/CuadroAsigPersonal/Docentes/GraficoBarras_DocentesNivelEducativo/{tipoTrab_id}/{importacion_id}', [CuadroAsigPersonalController::class, 'GraficoBarras_DocentesNivelEducativo'])->name('Docentes.GraficoBarras_DocentesNivelEducativo');

Route::post('/CuadroAsigPersonal/Docentes/GraficoBarras_Docentes_Ugeles/{importacion_id}', [CuadroAsigPersonalController::class, 'GraficoBarras_Docentes_Ugeles'])->name('Docentes.GraficoBarras_Docentes_Ugeles');
Route::get('/CuadroAsigPersonal/Listar/ImportarDT', [CuadroAsigPersonalController::class, 'ListarDTImportFuenteTodos'])->name('cuadroasigpersonal.listar.importados');



Route::get('/Censo/Importar', [CensoController::class, 'importar'])->name('Censo.importar');
Route::post('/Censo/Importar', [CensoController::class, 'guardar'])->name('Censo.guardar');
Route::get('/Censo/ListaImportada/{importacion_id}', [CensoController::class, 'ListaImportada'])->name('Censo.Censo_Lista');
Route::get('/Censo/ListaImportada_DataTable/{importacion_id}', [CensoController::class, 'ListaImportada_DataTable'])->name('Censo.ListaImportada_DataTable');
Route::get('/Censo/Aprobar/{importacion_id}', [CensoController::class, 'aprobar'])->name('Censo.aprobar');
Route::post('/Censo/Aprobar/procesar/{importacion_id}', [CensoController::class, 'procesar'])->name('Censo.procesar');

Route::get('/Matricula/Importar', [MatriculaController::class, 'importar'])->name('Matricula.importar');
Route::post('/Matricula/Importar', [MatriculaController::class, 'guardar'])->name('Matricula.guardar');
Route::get('/Matricula/ListaImportada/{importacion_id}', [MatriculaController::class, 'ListaImportada'])->name('Matricula.Matricula_Lista');
Route::get('/Matricula/Aprobar/{importacion_id}', [MatriculaController::class, 'aprobar'])->name('Matricula.aprobar');
Route::post('/Matricula/Aprobar/procesar/{importacion_id}', [MatriculaController::class, 'procesar'])->name('Matricula.procesar');

Route::get('/Matricula/Principal', [MatriculaController::class, 'principal'])->name('Matricula.principal');
Route::post('/Matricula/inicio/{matricula_id}/{gestion}/{tipo}', [MatriculaController::class, 'inicio'])->name('Matricula.inicio');
Route::post('/Matricula/Detalle', [MatriculaController::class, 'Detalle'])->name('Matricula.Detalle');
Route::post('/Matricula/ReporteUgel/{anio_id}/{matricula_id}/{gestion}/{tipo}', [MatriculaController::class, 'ReporteUgel'])->name('Matricula.ReporteUgel');
Route::post('/Matricula/ReporteDistrito/{anio_id}/{matricula_id}/{gestion}/{tipo}', [MatriculaController::class, 'ReporteDistrito'])->name('Matricula.ReporteDistrito');
Route::post('/Matricula/ReporteInstitucion/{anio_id}/{matricula_id}/{gestion}/{tipo}', [MatriculaController::class, 'reporteInstitucion'])->name('Matricula.ReporteInstitucion');

Route::get('/Matricula/EIB', [MatriculaController::class, 'principal_EIB'])->name('Matricula.principal_EIB');

Route::post('/Matricula/GraficoBarras_MatriculaUgel/{importacion_id}', [MatriculaController::class, 'GraficoBarras_MatriculaUgel'])->name('Matricula.GraficoBarras_MatriculaUgel');
Route::post('/Matricula/GraficoBarras_MatriculaTipoGestion/{importacion_id}', [MatriculaController::class, 'GraficoBarras_MatriculaTipoGestion'])->name('Matricula.GraficoBarras_MatriculaTipoGestion');

Route::get('/Matricula/EBE', [MatriculaController::class, 'principal_EBE'])->name('Matricula.principal_EBE');

/*  */
Route::get('/Matricula/Institucion_DataTable/{matricula_id}/{nivel}/{gestion}/{tipo}', [MatriculaController::class, 'Institucion_DataTable'])->name('Matricula.Institucion_DataTable');

Route::post('/Matricula/Fechas/{anio_id}', [MatriculaController::class, 'Fechas'])->name('Matricula.Fechas');
Route::post('/Matricula/GraficoBarrasPrincipal/{anio_id}/{gestion}/{tipo}', [MatriculaController::class, 'GraficoBarrasPrincipal'])->name('Matricula.GraficoBarrasPrincipal');

Route::get('/Matricula/importarconsolidadoAnual', [MatriculaController::class, 'importarConsolidadoAnual'])->name('Matricula.importarConsolidadoAnual');
Route::post('/Matricula/importarconsolidadoAnual', [MatriculaController::class, 'guardarConsolidadoAnual'])->name('Matricula.guardarConsolidadoAnual');
Route::get('/Matricula/ListaImportadaConsolidadoAnual/{importacion_id}', [MatriculaController::class, 'ListaImportada_ConsolidadoAnual'])->name('Matricula.Matricula_Lista_ConsolidadoAnual');

Route::get('/Matricula/AprobarConsolidadoAnual/{importacion_id}', [MatriculaController::class, 'aprobarConsolidadoAnual'])->name('Matricula.aprobarConsolidadoAnual');
Route::post('/Matricula/AprobarConsolidadoAnual/procesarConsolidadoAnual/{importacion_id}', [MatriculaController::class, 'procesarConsolidadoAnual'])->name('Matricula.procesarConsolidadoAnual');

Route::get('/Matricula/consolidadoAnual/', [MatriculaController::class, 'principalConsolidadoAnual'])->name('Matricula.consolidadoAnual');
Route::post('/Matricula/ReporteUgelConsolidadoAnual/{anio_id}/{gestion}/{nivel}', [MatriculaController::class, 'ReporteUgelConsolidadoAnual'])->name('Matricula.ReporteUgelConsolidadoAnual');

Route::get('/InstEducativa/Principal', [InstEducativaController::class, 'principal'])->name('InstEducativa.principal');
Route::post('/InstEducativa/ReporteDistrito', [InstEducativaController::class, 'ReporteDistrito'])->name('InstEducativa.ReporteDistrito');
Route::post('/InstEducativa/GraficoBarras_Instituciones_Distrito', [InstEducativaController::class, 'GraficoBarras_Instituciones_Distrito'])->name('InstEducativa.GraficoBarras_Instituciones_Distrito');
/*  */
Route::get('/MatriculaDetalle/avance/', [MatriculaDetalleController::class, 'avance'])->name('matriculadetalle.avance');
Route::post('/MatriculaDetalle/avance/tabla0', [MatriculaDetalleController::class, 'cargartabla0'])->name('matriculadetalle.avance.tabla0');
Route::post('/MatriculaDetalle/avance/tabla1', [MatriculaDetalleController::class, 'cargartabla1'])->name('matriculadetalle.avance.tabla1');
Route::post('/MatriculaDetalle/avance/grafica1', [MatriculaDetalleController::class, 'cargargrafica1'])->name('matriculadetalle.avance.grafica1');
Route::get('/MatriculaDetalle/rojos/{mes}/{nivel}/{ano}', [MatriculaDetalleController::class, 'rojos']);

Route::get('/MatriculaDetalle/EBR/', [MatriculaDetalleController::class, 'basicaregular'])->name('matriculadetalle.basicaregular');
Route::post('/MatriculaDetalle/EBR/grafica1', [MatriculaDetalleController::class, 'cargarEBRgrafica1'])->name('matriculadetalle.ebr.grafica1');
Route::post('/MatriculaDetalle/EBR/grafica2', [MatriculaDetalleController::class, 'cargarEBRgrafica2'])->name('matriculadetalle.ebr.grafica2');
Route::post('/MatriculaDetalle/EBR/grafica3', [MatriculaDetalleController::class, 'cargarEBRgrafica3'])->name('matriculadetalle.ebr.grafica3');
Route::post('/MatriculaDetalle/EBR/grafica4', [MatriculaDetalleController::class, 'cargarEBRgrafica4'])->name('matriculadetalle.ebr.grafica4');
Route::post('/MatriculaDetalle/EBR/grafica5', [MatriculaDetalleController::class, 'cargarEBRgrafica5'])->name('matriculadetalle.ebr.grafica5');
Route::post('/MatriculaDetalle/EBR/grafica6', [MatriculaDetalleController::class, 'cargarEBRgrafica6'])->name('matriculadetalle.ebr.grafica6');
Route::post('/MatriculaDetalle/EBR/grafica7', [MatriculaDetalleController::class, 'cargarEBRgrafica7'])->name('matriculadetalle.ebr.grafica7');
Route::post('/MatriculaDetalle/EBR/tabla1', [MatriculaDetalleController::class, 'cargarEBRtabla1'])->name('matriculadetalle.ebr.tabla1');
Route::post('/MatriculaDetalle/EBR/tabla2', [MatriculaDetalleController::class, 'cargarEBRtabla2'])->name('matriculadetalle.ebr.tabla2');
Route::post('/MatriculaDetalle/EBR/tabla3', [MatriculaDetalleController::class, 'cargarEBRtabla3'])->name('matriculadetalle.ebr.tabla3');
Route::post('/MatriculaDetalle/EBR/tabla3_1', [MatriculaDetalleController::class, 'cargarEBRtabla3_1'])->name('matriculadetalle.ebr.tabla3_1');
Route::post('/MatriculaDetalle/EBR/tabla3_2', [MatriculaDetalleController::class, 'cargarEBRtabla3_2'])->name('matriculadetalle.ebr.tabla3_2');
Route::post('/MatriculaDetalle/EBR/tabla3_3', [MatriculaDetalleController::class, 'cargarEBRtabla3_3'])->name('matriculadetalle.ebr.tabla3_3');
Route::post('/MatriculaDetalle/EBR/tabla4', [MatriculaDetalleController::class, 'cargarEBRtabla4'])->name('matriculadetalle.ebr.tabla4');
Route::post('/MatriculaDetalle/EBR/tabla4_1', [MatriculaDetalleController::class, 'cargarEBRtabla4_1'])->name('matriculadetalle.ebr.tabla4_1');
Route::post('/MatriculaDetalle/EBR/tabla4_2', [MatriculaDetalleController::class, 'cargarEBRtabla4_2'])->name('matriculadetalle.ebr.tabla4_2');
//Route::post('/MatriculaDetalle/EBR/tabla4_3', [MatriculaDetalleController::class, 'cargarEBRtabla4_3'])->name('matriculadetalle.ebr.tabla4_3');
Route::post('/MatriculaDetalle/EBR/tabla5', [MatriculaDetalleController::class, 'cargarEBRtabla5'])->name('matriculadetalle.ebr.tabla5');
Route::post('/MatriculaDetalle/EBR/tabla5_1', [MatriculaDetalleController::class, 'cargarEBRtabla5_1'])->name('matriculadetalle.ebr.tabla5_1');
Route::post('/MatriculaDetalle/EBR/tabla5_2', [MatriculaDetalleController::class, 'cargarEBRtabla5_2'])->name('matriculadetalle.ebr.tabla5_2');
//Route::post('/MatriculaDetalle/EBR/tabla5_3', [MatriculaDetalleController::class, 'cargarEBRtabla5_3'])->name('matriculadetalle.ebr.tabla5_3');
Route::post('/MatriculaDetalle/EBR/tabla6', [MatriculaDetalleController::class, 'cargarEBRtabla6'])->name('matriculadetalle.ebr.tabla6');

Route::get('/MatriculaDetalle/EBE/', [MatriculaDetalleController::class, 'basicaespecial'])->name('matriculadetalle.basicaespecial');
Route::post('/MatriculaDetalle/EBE/grafica1', [MatriculaDetalleController::class, 'cargarEBEgrafica1'])->name('matriculadetalle.ebe.grafica1');
Route::post('/MatriculaDetalle/EBE/grafica2', [MatriculaDetalleController::class, 'cargarEBEgrafica2'])->name('matriculadetalle.ebe.grafica2');
Route::post('/MatriculaDetalle/EBE/grafica3', [MatriculaDetalleController::class, 'cargarEBEgrafica3'])->name('matriculadetalle.ebe.grafica3');
Route::post('/MatriculaDetalle/EBE/grafica4', [MatriculaDetalleController::class, 'cargarEBEgrafica4'])->name('matriculadetalle.ebe.grafica4');
Route::post('/MatriculaDetalle/EBE/tabla1', [MatriculaDetalleController::class, 'cargarEBEtabla1'])->name('matriculadetalle.ebe.tabla1');
Route::post('/MatriculaDetalle/EBE/tabla2', [MatriculaDetalleController::class, 'cargarEBEtabla2'])->name('matriculadetalle.ebe.tabla2');

Route::get('/MatriculaDetalle/EIB/', [MatriculaDetalleController::class, 'interculturalbilingue'])->name('matriculadetalle.interculturalbilingue');
Route::post('/MatriculaDetalle/EIB/grafica1', [MatriculaDetalleController::class, 'cargarEIBgrafica1'])->name('matriculadetalle.eib.grafica1');
Route::post('/MatriculaDetalle/EIB/grafica2', [MatriculaDetalleController::class, 'cargarEIBgrafica2'])->name('matriculadetalle.eib.grafica2');
Route::post('/MatriculaDetalle/EIB/grafica3', [MatriculaDetalleController::class, 'cargarEIBgrafica3'])->name('matriculadetalle.eib.grafica3');
Route::post('/MatriculaDetalle/EIB/grafica4', [MatriculaDetalleController::class, 'cargarEIBgrafica4'])->name('matriculadetalle.eib.grafica4');
Route::post('/MatriculaDetalle/EIB/tabla1', [MatriculaDetalleController::class, 'cargarEIBtabla1'])->name('matriculadetalle.eib.tabla1');
Route::post('/MatriculaDetalle/EIB/tabla2', [MatriculaDetalleController::class, 'cargarEIBtabla2'])->name('matriculadetalle.eib.tabla2');



Route::get('/Tableta/Importar', [TabletaController::class, 'importar'])->name('Tableta.importar');
Route::post('/Tableta/Importar', [TabletaController::class, 'guardar'])->name('Tableta.guardar');
Route::get('/Tableta/Aprobar/{importacion_id}', [TabletaController::class, 'aprobar'])->name('Tableta.aprobar');
Route::post('/Tableta/Aprobar/procesar/{importacion_id}', [TabletaController::class, 'procesar'])->name('Tableta.procesar');

Route::get('/Tableta/Principal', [TabletaController::class, 'principal'])->name('Tableta.principal');
Route::post('/Tableta/Fechas/{anio_id}', [TabletaController::class, 'Fechas'])->name('Tableta.Fechas');
Route::post('/Tableta/ReporteUgel/{anio_id}/{tableta_id}', [TabletaController::class, 'ReporteUgel'])->name('Tableta.ReporteUgel');

Route::post('/Tableta/GraficoBarrasPrincipal/{anio_id}', [TabletaController::class, 'GraficoBarrasPrincipal'])->name('Tableta.GraficoBarrasPrincipal');


Route::get('/Importacion', [ImportacionController::class, 'inicio'])->name('importacion.inicio');
Route::get('/Importacion/importaciones_DataTable/', [ImportacionController::class, 'importacionesLista_DataTable'])->name('importacion.importacionesLista_DataTable');
Route::get('/Importacion/Eliminar/{id}', [ImportacionController::class, 'eliminar'])->name('importacion.Eliminar');
Route::get('/Importacion/GetEliminar/{id}', [ImportacionController::class, 'setEliminar']);
//Route::get('/Importac-ion/Impo-rtados/dt/{fuenteimp-ortacion_id}', [Importacio-nController::class, 'ListarIm-portadosDT'])->name('import-acion.listar.importados');
Route::post('/Importacion/Importados/', [ImportacionController::class, 'ListarDTImportFuenteTodos'])->name('importacion.listar.importados');

Route::get('/ECE/Importar', [EceController::class, 'importar'])->name('ece.importar');
Route::get('/ECE/Importar/Aprobar/{importacion_id}', [EceController::class, 'importarAprobar'])->name('ece.importar.aprobar');
Route::get('/ECE/Importar/Aprobar/Guardar/{importacion}', [EceController::class, 'importarAprobarGuardar'])->name('ece.importar.aprobar.guardar');
Route::post('/ECE/ImportarGuardar', [EceController::class, 'importarGuardar'])->name('ece.importar.store');
Route::get('/ECE/listadoDT/{importacion_id}', [EceController::class, 'importarListadoDT'])->name('ece.importar.listadoDT');
Route::get('/ECE/Listado/{importacion_id}', [EceController::class, 'importarListado'])->name('ece.importar.listado');
Route::get('/ECE/Listar/ImportarDT', [EceController::class, 'ListarEceImportadosDT'])->name('ece.listar.importados');
Route::get('/ECE/Eliminar/ImportarDT/{id}', [EceController::class, 'EliminarImportados']);
Route::post('/ECE/CargarGrados', [EceController::class, 'cargargrados'])->name('ece.ajax.cargargrados');
Route::get('/INDICADOR/Menu/{clasificador}', [IndicadorController::class, 'indicadorEducacionMenu'])->name('indicador.menu');
Route::get('/Clasificador/{clase_codigo}', [ClasificadorController::class, 'menu_porClase'])->name('Clasificador.menu');

Route::get('/INDICADOR/ece/{indicador}', [IndicadorController::class, 'indicadorEducacion'])->name('indicador.01');
Route::get('/INDICADOR/drvcs/{indicador}', [IndicadorController::class, 'indicadorDRVCS'])->name('indicador.02');
Route::get('/INDICADOR/pdrc/{indicador}', [IndicadorController::class, 'indicadorPDRC'])->name('indicador.04');
Route::get('/INDICADOR/obj/{indicador}', [IndicadorController::class, 'indicadorOEI'])->name('indicador.05');

Route::get('/INDICADOR/dece/{indicador_id}/{grado}/{tipo}/{materia}', [IndicadorController::class, 'indDetEdu'])->name('ind.det.edu');
Route::get('/INDICADOR/rece/{indicador_id}/{grado}/{tipo}/{materia}', [IndicadorController::class, 'indResEdu'])->name('ind.res.edu');

Route::post('/INDICADOR/Satisfactorio', [IndicadorController::class, 'reporteSatisfactorioMateria'])->name('ind.ajax.satisfactorio');
Route::post('/INDICADOR/ReporteUbigeoAjax', [IndicadorController::class, 'reporteUbigeoAjax'])->name('ind.ajax.reporteubigeo');
Route::get('/INDICADOR/ReporteGestionAreaDT/{anio}/{grado}/{tipo}/{materia}/{gestion}/{area}', [IndicadorController::class, 'reporteGestionAreaDT']);
Route::get('/INDICADOR/ReporteCPVivDT/{provincia}/{distrito}/{importacion_id}/{indicador_id}', [IndicadorController::class, 'ReporteCPVivDT']);
Route::post('/INDICADOR/Distritos/{provincia}', [IndicadorController::class, 'cargardistritos'])->name('ind.ajax.cargardistritos');
Route::post('/INDICADOR/PNSR1/{provincia}/{distrito}/{indicador_id}/{fecha}', [IndicadorController::class, 'indicadorvivpnsrcab'])->name('ind.ajax.pnsr1');
Route::post('/INDICADOR/PNSR2/{provincia}/{distrito}/{indicador_id}/{fecha}', [IndicadorController::class, 'indicadorviv2pnsrcab'])->name('ind.ajax.pnsr2');
Route::post('/INDICADOR/ece5/{provincia}/{distrito}/{indicador_id}/{anio_id}', [IndicadorController::class, 'ajaxEdu5v1'])->name('ind.ajax.edu5.1');
Route::post('/INDICADOR/ece6/{provincia}/{distrito}/{indicador_id}/{anio_id}', [IndicadorController::class, 'ajaxEdu6v1'])->name('ind.ajax.edu6.1');

Route::post('/INDICADOR/ece/plaza', [PLazaController::class, 'datoIndicadorPLaza'])->name('ind01.plaza.dato');

Route::get('/Plaza/Docentes/Principal', [PLazaController::class, 'DocentesPrincipal'])->name('Docentes.principal');
Route::get('/Plaza/Distritos/{provincia}', [PLazaController::class, 'cargardistritos'])->name('plaza.cargardistritos');
Route::get('/Plaza/Mes/{anio}', [PLazaController::class, 'cargarmes']);
Route::get('/Plaza/UltimoImportado/{anio}/{mes}', [PLazaController::class, 'cargarultimoimportado']);
//Route::get('/Plaza/Docentes/{importacion_id}/{anio}', [PLazaController::class, 'menuDocentes']);
Route::post('/Plaza/Docentes/DocentePrincial', [PLazaController::class, 'DocentesPrincipalHead'])->name('nexus.contratacion.head');
Route::post('/Plaza/Docentes/DocentePrincial/gra1', [PLazaController::class, 'DocentesPrincipalgra1'])->name('nexus.contratacion.gra1');
Route::post('/Plaza/Docentes/DocentePrincial/gra2', [PLazaController::class, 'DocentesPrincipalgra2'])->name('nexus.contratacion.gra2');
Route::post('/Plaza/Docentes/DocentePrincial/gra3', [PLazaController::class, 'DocentesPrincipalgra3'])->name('nexus.contratacion.gra3');
Route::post('/Plaza/Docentes/DocentePrincial/gra4', [PLazaController::class, 'DocentesPrincipalgra4'])->name('nexus.contratacion.gra4');
Route::post('/Plaza/Docentes/DocentePrincial/gra5', [PLazaController::class, 'DocentesPrincipalgra5'])->name('nexus.contratacion.gra5');
Route::post('/Plaza/Docentes/DocentePrincial/gra6', [PLazaController::class, 'DocentesPrincipalgra6'])->name('nexus.contratacion.gra6');
Route::post('/Plaza/Docentes/DocentePrincial/gra7', [PLazaController::class, 'DocentesPrincipalgra7'])->name('nexus.contratacion.gra7');
Route::post('/Plaza/Docentes/DocentePrincial/gra8', [PLazaController::class, 'DocentesPrincipalgra8'])->name('nexus.contratacion.gra8');
Route::post('/Plaza/Docentes/DocentePrincial/gra9', [PLazaController::class, 'DocentesPrincipalgra9'])->name('nexus.contratacion.gra9');
Route::post('/Plaza/Docentes/DocentePrincial/gra10', [PLazaController::class, 'DocentesPrincipalgra10'])->name('nexus.contratacion.gra10');
Route::post('/Plaza/Docentes/DocentePrincial/DT1', [PLazaController::class, 'DocentesPrincipalDT1'])->name('nexus.contratacion.dt1');
Route::post('/Plaza/Docentes/DocentePrincial/DT2', [PLazaController::class, 'DocentesPrincipalDT2'])->name('nexus.contratacion.dt2');
Route::post('/Plaza/Docentes/DocentePrincial/DT3', [PLazaController::class, 'DocentesPrincipalDT3'])->name('nexus.contratacion.dt3');
Route::post('/Plaza/Docentes/DocentePrincial/DT4', [PLazaController::class, 'DocentesPrincipalDT4'])->name('nexus.contratacion.dt4');

Route::get('/Plaza/Docentes/CoberturaDePlaza', [PLazaController::class, 'coberturaplaza'])->name('nexus.cobertura.head');
Route::post('/Plaza/Plazas/tabla1', [PLazaController::class, 'cargarcoberturaplazatabla1'])->name('nexus.cobertura.tabla1');
Route::post('/Plaza/Plazas/tabla2', [PLazaController::class, 'cargarcoberturaplazatabla2'])->name('nexus.cobertura.tabla2');
Route::post('/Plaza/Plazas/grafica1', [PLazaController::class, 'cargarcoberturaplazagrafica1'])->name('nexus.cobertura.grafica1');

Route::get('/INDICADOR/SINRUTA', function () {
    //return 'Ruta no definida';
    return view('paginavacio');
})->name('sinruta');
/**************************************** FIN EDUCACION ************************************************/

/**************************************** VIVIENDA ************************************************/
Route::get('/Datass/Importar', [DatassController::class, 'importar'])->name('Datass.importar');
Route::post('/Datass/Importar', [DatassController::class, 'guardar'])->name('Datass.guardar');
Route::get('/Datass/ListaImportada/{importacion_id}', [DatassController::class, 'ListaImportada'])->name('Datass.Datass_Lista');
Route::get('/Datass/ListaImportada_DataTable/{importacion_id}', [DatassController::class, 'ListaImportada_DataTable'])->name('Datass.ListaImportada_DataTable');
Route::get('/Datass/Aprobar/{importacion_id}', [DatassController::class, 'aprobar'])->name('Datass.aprobar');
Route::post('/Datass/Aprobar/procesar/{importacion_id}', [DatassController::class, 'procesar'])->name('Datass.procesar');

Route::get('/PEmapacopsa/Importar', [PadronEmapacopsaController::class, 'importar'])->name('pemapacopsa.importar');
Route::post('/PEmapacopsa/Importar', [PadronEmapacopsaController::class, 'importarGuardar'])->name('pemapacopsa.guardar');
Route::get('/PEmapacopsa/Listado/{importacion_id}', [PadronEmapacopsaController::class, 'importarListado'])->name('pemapacopsa.listado');
Route::get('/PEmapacopsa/listadoDT/{importacion_id}', [PadronEmapacopsaController::class, 'importarListadoDT'])->name('pemapacopsa.listadoDT');
Route::get('/PEmapacopsa/Aprobar/{importacion_id}', [PadronEmapacopsaController::class, 'importarAprobar'])->name('pemapacopsa.aprobar');
Route::post('/PEmapacopsa/Aprobar/procesar/{importacion_id}', [PadronEmapacopsaController::class, 'importarAprobarGuardar'])->name('pemapacopsa.procesar');
Route::post('/PEmapacopsa/Distritos/{provincia}', [EmapacopsaController::class, 'cargardistritos'])->name('emapacopsa.ajax.cargardistritos');

Route::get('/CentroPobladoDatass/Saneamiento', [CentroPobladoDatassController::class, 'saneamiento'])->name('centropobladodatass.saneamiento');
Route::get('/CentroPobladoDatass/Distritos/{provincia}', [CentroPobladoDatassController::class, 'cargardistrito'])->name('centropobladodatass.cargardistritos');
Route::post('/CentroPobladoDatass/Saneamiento/datos', [CentroPobladoDatassController::class, 'datosSaneamiento'])->name('centropobladodatass.saneamiento.info');
Route::get('/CentroPobladoDatass/Saneamiento/DT/{provincia}/{distrito}/{importacion_id}', [CentroPobladoDatassController::class, 'DTsaneamiento']);

Route::get('/CentroPobladoDatass/infraestructurasanitaria', [CentroPobladoDatassController::class, 'infraestructurasanitaria'])->name('centropobladodatass.infraestructurasanitaria');
Route::post('/CentroPobladoDatass/infraestructurasanitaria/datos', [CentroPobladoDatassController::class, 'datoInfraestructuraSanitaria'])->name('centropobladodatass.infraestructurasanitaria.info');

Route::get('/CentroPobladoDatass/prestadorservicio', [CentroPobladoDatassController::class, 'prestadorservicio'])->name('centropobladodatass.prestadorservicio');
Route::post('/CentroPobladoDatass/prestadorservicio/datos', [CentroPobladoDatassController::class, 'datoPrestadorServicio'])->name('centropobladodatass.prestadorservicio.info');

Route::get('/CentroPobladoDatass/calidadservicio', [CentroPobladoDatassController::class, 'calidadservicio'])->name('centropobladodatass.calidadservicio');
Route::post('/CentroPobladoDatass/calidadservicio/datos', [CentroPobladoDatassController::class, 'datoCalidadServicio'])->name('centropobladodatass.calidadservicio.info');

Route::get('/CentroPobladoDatass/listarDT', [CentroPobladoDatassController::class, 'listarDT'])->name('centropobladodatass.listarDT');

/**************************************** FIN VIVIENDA ************************************************/

/**************************************** ADMINISTRADOR ************************************************/
Route::get('/Usuario/Principal', [UsuarioController::class, 'principal'])->name('Usuario.principal');
Route::get('/Usuario/Usuario_DataTable/', [UsuarioController::class, 'Lista_DataTable'])->name('Usuario.Lista_DataTable');

/*Route::get('/Usuario/Registrar', [UsuarioController::class, 'registrar'])->name('Usuario.registrar');
Route::post('/Usuario/Registrar', [UsuarioController::class, 'guardar'])->name('Usuario.guardar');
Route::get('/Usuario/Editar/{usuario}', [UsuarioController::class, 'editar'])->name('Usuario.Editar');
Route::post('/Usuario/Editar/{id}', [UsuarioController::class, 'actualizar'])->name('Usuario.Actualizar');*/
Route::get('/Usuario/Eliminar/{id}', [UsuarioController::class, 'eliminar'])->name('Usuario.Eliminar');

//Route::get('/Usuario/Principal', [UsuarioController::class, 'principal'])->name('Usuario.principal');
//Route::get('/Usuario/listarDT', [UsuarioController::class, 'listarDT'])->name('usuario.listarDT');
Route::get('/Usuario/ajax_edit/{usuario_id}', [UsuarioController::class, 'ajax_edit']);
Route::get('/Usuario/ajax_edit_basico/{usuario_id}', [UsuarioController::class, 'ajax_edit_basico']);
Route::post('/Usuario/ajax_add/', [UsuarioController::class, 'ajax_add']);
Route::post('/Usuario/ajax_update/', [UsuarioController::class, 'ajax_update']);
Route::post('/Usuario/ajax_updateaux/', [UsuarioController::class, 'ajax_updateaux'])->name('usuario.updatedperfil');
Route::post('/Usuario/ajax_update_password/', [UsuarioController::class, 'ajax_updatepassword'])->name('usuario.updatedpassword');
Route::get('/Usuario/ajax_estadousuario/{usuario_id}', [UsuarioController::class, 'ajax_estadoUsuario']);
Route::get('/Usuario/ajax_delete/{usuario_id}', [UsuarioController::class, 'ajax_delete']);
Route::get('/Usuario/DTSistemasAsignados/{usuario_id}', [UsuarioController::class, 'listarSistemasAsignados']);

Route::get('/Usuario/CargarPerfil/{sistema_id}/{usuario_id}', [UsuarioController::class, 'cargarPerfil']);
Route::post('/Usuario/ajax_add_perfil/', [UsuarioController::class, 'ajax_add_perfil']);
Route::get('/Usuario/ajax_delete_perfil/{usuario_id}/{perfil_id}', [UsuarioController::class, 'ajax_delete_perfil']);

Route::get('/Usuario/CargarEntidad/{tipogobierno_id}', [UsuarioController::class, 'cargarEntidad']);
Route::post('/Usuario/ajax_add_entidad/', [UsuarioController::class, 'ajax_add_entidad'])->name('usuario.ajax.addentidad');

Route::get('/Usuario/CargarGerencia/{entidad_id}', [UsuarioController::class, 'cargarGerencia']);
Route::post('/Usuario/ajax_add_gerencia/', [UsuarioController::class, 'ajax_add_gerencia'])->name('usuario.ajax.addgerencia');

Route::get('/Usuario/CargarOficina/{entidad_id}', [UsuarioController::class, 'cargarOficina']);
Route::post('/Usuario/ajax_add_oficina/', [UsuarioController::class, 'ajax_add_oficina'])->name('usuario.ajax.addoficina');


Route::get('/Sistema/Principal', [SistemaController::class, 'principal'])->name('sistema.principal');
Route::get('/Sistema/listarDT', [SistemaController::class, 'listarDT'])->name('sistema.listarDT');
Route::get('/Sistema/ajax_edit/{sistema_id}', [SistemaController::class, 'ajax_edit']);
Route::post('/Sistema/ajax_add', [SistemaController::class, 'ajax_add']);
Route::post('/Sistema/ajax_update', [SistemaController::class, 'ajax_update']);
Route::get('/Sistema/ajax_delete/{sistema_id}', [SistemaController::class, 'ajax_delete']);
Route::get('/Sistema/ajax_estado/{sistema_id}', [SistemaController::class, 'ajax_estado']);

Route::get('/Menu/Principal', [MenuController::class, 'principal'])->name('menu.principal');
Route::get('/Menu/listarDT/{sistema_id}', [MenuController::class, 'listarDT'])->name('menu.listarDT');
Route::get('/Menu/cargarGrupo/{sistema_id}', [MenuController::class, 'cargarGrupo']);
Route::get('/Menu/ajax_edit/{menu_id}', [MenuController::class, 'ajax_edit']);
Route::post('/Menu/ajax_add', [MenuController::class, 'ajax_add']);
Route::post('/Menu/ajax_update', [MenuController::class, 'ajax_update']);
Route::get('/Menu/ajax_delete/{menu_id}', [MenuController::class, 'ajax_delete']);
Route::get('/Menu/ajax_estado/{menu_id}', [MenuController::class, 'ajax_estado']);

Route::get('/Perfil/Principal', [PerfilController::class, 'principal'])->name('perfil.principal');
Route::get('/Perfil/listarDT/{sistema_id}', [PerfilController::class, 'listarDT'])->name('perfil.listarDT');
Route::get('/Perfil/ajax_edit/{perfil_id}', [PerfilController::class, 'ajax_edit']);
Route::post('/Perfil/ajax_add', [PerfilController::class, 'ajax_add']);
Route::post('/Perfil/ajax_update', [PerfilController::class, 'ajax_update']);
Route::get('/Perfil/ajax_delete/{perfil_id}', [PerfilController::class, 'ajax_delete']);
Route::get('/Perfil/ajax_estado/{perfil_id}', [PerfilController::class, 'ajax_estado']);

Route::get('/Perfil/listarmenu/{perfil_id}/{sistema_id}', [PerfilController::class, 'listarmenu']);
Route::post('/Perfil/ajax_add_menu', [PerfilController::class, 'ajax_add_menu']);

Route::get('/Perfil/listarsistema/{perfil_id}/{sistema_id}', [PerfilController::class, 'listarsistema']);
Route::post('/Perfil/ajax_add_sistema', [PerfilController::class, 'ajax_add_sistema']);

Route::get('/Entidad/Principal', [EntidadController::class, 'principal'])->name('entidad.principal');
Route::get('/Entidad/listar/{tipogobierno_id}', [EntidadController::class, 'listarDTentidad']);
Route::post('/Entidad/ajax_add_entidad/', [EntidadController::class, 'ajax_add_entidad'])->name('entidad.ajax.addentidad');
Route::get('/Entidad/ajax_edit_entidad/{entidad}', [EntidadController::class, 'ajax_edit_entidad']);
Route::post('/Entidad/ajax_update_entidad/', [EntidadController::class, 'ajax_update_entidad'])->name('entidad.ajax.updateentidad');
Route::get('/Entidad/ajax_delete/{perfil_id}', [EntidadController::class, 'ajax_delete_entidad']);
//Route::get('/Entidad/listar/{unidadejecutora_id}/{dependencia}', [EntidadController::class, 'listarDT']);

Route::get('/Entidad/CargarEntidad/{tipogobierno_id}', [EntidadController::class, 'cargarEntidad']);

Route::get('/Entidad/Gerencia', [EntidadController::class, 'gerencia'])->name('entidad.gerencia');
Route::get('/Entidad/CargarGerencia/{entidad_id}', [EntidadController::class, 'cargarGerencia']);
Route::post('/Entidad/ajax_add_gerencia/', [EntidadController::class, 'ajax_add_gerencia'])->name('entidad.ajax.addgerencia');
Route::post('/Entidad/ajax_update_gerencia/', [EntidadController::class, 'ajax_update_gerencia'])->name('entidad.ajax.updategerencia');
Route::get('/Entidad/ajax_delete_gerencia/{gerencia_id}', [EntidadController::class, 'ajax_delete_gerencia']);
Route::get('/Entidad/ajax_edit_gerencia/{gerencia_id}', [EntidadController::class, 'ajax_edit_gerencia']);
Route::get('/Entidad/listarGerencia/{entidad_id}', [EntidadController::class, 'listarDTgerencia']);

Route::get('/Entidad/Oficina', [EntidadController::class, 'oficina'])->name('entidad.oficina');
Route::get('/Entidad/CargarOficina/{gerencia_id}', [EntidadController::class, 'cargarOficina']);
Route::post('/Entidad/ajax_add_oficina/', [EntidadController::class, 'ajax_add_oficina'])->name('entidad.ajax.addoficina');
Route::post('/Entidad/ajax_update_oficina/', [EntidadController::class, 'ajax_update_oficina'])->name('entidad.ajax.updateoficina');
Route::get('/Entidad/ajax_delete_oficina/{oficina_id}', [EntidadController::class, 'ajax_delete_oficina']);
Route::get('/Entidad/ajax_edit_oficina/{oficina_id}', [EntidadController::class, 'ajax_edit_oficina']);
Route::get('/Entidad/listarOficina/{gerencia_id}', [EntidadController::class, 'listarDToficina']);

Route::get('/Importado/resumen', [ImportacionController::class, 'resumenimportados'])->name('importar.importados');
/**************************************** FIN ADMINISTRADOR ************************************************/

/**************************************** PRESUPUESTO ************************************************/
Route::get('/Home/Presupuesto/gra1/{importacion_id}', [HomeController::class, 'presupuestografica1'])->name('graficas.home.presupuesto.1');
Route::get('/Home/Presupuesto/gra2', [HomeController::class, 'presupuestografica2'])->name('graficas.home.presupuesto.2');
Route::get('/Home/Presupuesto/gra3', [HomeController::class, 'presupuestografica3'])->name('graficas.home.presupuesto.3');

Route::get('/Home/Presupuesto/tabla1/{importacion_id}', [HomeController::class, 'presupuestotabla1'])->name('tabla.home.presupuesto.1');

Route::get('/IMPORGASTOS/Gastos/Importar', [ImporGastosController::class, 'importar'])->name('pres.gastos.importar');
Route::post('/IMPORGASTOS/Gastos/Importar', [ImporGastosController::class, 'importarGuardar'])->name('imporgastos.gastos.guardar');
Route::get('/IMPORGASTOS/Listar/ImportarDT', [ImporGastosController::class, 'ListarDTImportFuenteTodos'])->name('imporgastos.listar.importados');
Route::get('/IMPORGASTOS/eliminar/{id}', [ImporGastosController::class, 'eliminar']);
Route::post('/IMPORGASTOS/ListaImportada/{importacion_id}', [ImporGastosController::class, 'ListaImportada'])->name('imporgastos.listarimportados');

Route::get('/IMPORINGRESO/ingresos/Importar', [ImporIngresosController::class, 'importar'])->name('pres.ingresos.importar');
Route::post('/IMPORINGRESO/ingresos/Importar', [ImporIngresosController::class, 'guardar'])->name('imporingresos.guardar');
Route::get('/IMPORINGRESO/Listar/ImportarDT', [ImporIngresosController::class, 'ListarDTImportFuenteTodos'])->name('imporingresos.listar.importados');
Route::get('/IMPORINGRESO/eliminar/{id}', [ImporIngresosController::class, 'eliminar']);
Route::post('/IMPORINGRESO/ListaImportada/{importacion_id}', [ImporIngresosController::class, 'ListaImportada'])->name('imporingresos.listarimportados');

Route::get('/PRES/Covid/Importar', [ImporGastosController::class, 'importar'])->name('pres.covid.importar');
Route::get('/PRES/Regiones/Importar', [ImporGastosController::class, 'importar'])->name('pres.regiones.importar');


Route::get('/presupuesto/Principal', [MatriculaDetalleController::class, 'cargarpresupuestoxxx'])->name('educacion.xxx');

/**************************************** FIN PRESUPUESTO ***************************************************/


/**************************************** TRABAJO DESDE GAMB ************************************************/
Route::get('/ProEmpleo/Principal', [ProEmpleoController::class, 'Principal'])->name('ProEmpleo.Principal');


Route::get('/ProEmpleo/Importar', [ProEmpleoController::class, 'importar'])->name('ProEmpleo.importar');
Route::post('/ProEmpleo/Importar', [ProEmpleoController::class, 'guardar'])->name('ProEmpleo.guardar');

Route::get('/IndicadorTrabajo/Importar', [IndicadorTrabajoController::class, 'importar'])->name('trabajo.indicador');
Route::post('/IndicadorTrabajo/Grafico_PEA/{id}', [IndicadorTrabajoController::class, 'Grafico_PEA'])->name('trabajo.Grafico_PEA');
Route::post('/IndicadorTrabajo/Grafico_PEA_IPM/{id}', [IndicadorTrabajoController::class, 'Grafico_PEA_IPM'])->name('trabajo.Grafico_PEA_IPM');

Route::get('/ProEmpleo/Aprobar/{importacion_id}', [ProEmpleoController::class, 'aprobar'])->name('ProEmpleo.aprobar');
Route::post('/ProEmpleo/Aprobar/procesar/{importacion_id}', [ProEmpleoController::class, 'procesar'])->name('ProEmpleo.procesar');
Route::get('/ProEmpleo/ListaImportada_DataTable/{importacion_id}', [ProEmpleoController::class, 'ListaImportada_DataTable'])->name('ProEmpleo.ListaImportada_DataTable');

Route::post('/ProEmpleo/Grafico_oferta_demanda_colocados/{id}', [ProEmpleoController::class, 'Grafico_oferta_demanda_colocados'])->name('ProEmpleo.Grafico_oferta_demanda_colocados');
Route::post('/ProEmpleo/Grafico_Colocados_Hombres_Vs_Mujeres/{id}', [ProEmpleoController::class, 'Grafico_Colocados_Hombres_Vs_Mujeres'])->name('ProEmpleo.Grafico_Colocados_Hombres_Vs_Mujeres');
Route::post('/ProEmpleo/Grafico_Colocados_per_Con_Discapacidad/{id}', [ProEmpleoController::class, 'Grafico_Colocados_per_Con_Discapacidad'])->name('ProEmpleo.Grafico_Colocados_per_Con_Discapacidad');
Route::post('/ProEmpleo/VariablesMercado/{id}', [ProEmpleoController::class, 'VariablesMercado'])->name('ProEmpleo.VariablesMercado');

Route::get('/AnuarioEstadistico/Importar', [AnuarioEstadisticoController::class, 'importar'])->name('AnuarioEstadistico.importar');
Route::post('/AnuarioEstadistico/Importar', [AnuarioEstadisticoController::class, 'guardar'])->name('AnuarioEstadistico.guardar');


Route::get('/AnuarioEstadistico/Aprobar/{importacion_id}', [AnuarioEstadisticoController::class, 'aprobar'])->name('AnuarioEstadistico.aprobar');
Route::post('/AnuarioEstadistico/Aprobar/procesar/{importacion_id}', [AnuarioEstadisticoController::class, 'procesar'])->name('AnuarioEstadistico.procesar');
Route::get('/AnuarioEstadistico/ListaImportada_DataTable/{importacion_id}', [AnuarioEstadisticoController::class, 'ListaImportada_DataTable'])->name('AnuarioEstadistico.ListaImportada_DataTable');

Route::post('/AnuarioEstadistico/Grafico_Promedio_Remuneracion/{id}', [AnuarioEstadisticoController::class, 'Grafico_Promedio_Remuneracion']);
Route::post('/AnuarioEstadistico/Grafico_Promedio_Trabajadores/{id}', [AnuarioEstadisticoController::class, 'Grafico_Promedio_Trabajadores']);
Route::post('/AnuarioEstadistico/Grafico_Prestadores_Servicio4ta_Publico/{id}', [AnuarioEstadisticoController::class, 'Grafico_Prestadores_Servicio4ta_Publico']);
Route::post('/AnuarioEstadistico/Grafico_Prestadores_Servicio4ta_Privado/{id}', [AnuarioEstadisticoController::class, 'Grafico_Prestadores_Servicio4ta_Privado']);

Route::get('/AnuarioEstadistico/rptRemunTrabSectorPrivado/', [AnuarioEstadisticoController::class, 'rptRemunTrabSectorPrivado'])->name('AnuarioEstadistico.rptRemunTrabSectorPrivado');
Route::get('/AnuarioEstadistico/rptRemunTrabSectorPrivado_DataTable/{id}', [AnuarioEstadisticoController::class, 'rptAnuarioEstadistico_DataTable'])->name('AnuarioEstadistico.rptAnuarioEstadistico_DataTable');
Route::post('/AnuarioEstadistico/Grafico_Promedio_Remuneracion_porAnio/{id}', [AnuarioEstadisticoController::class, 'Grafico_Promedio_Remuneracion_porAnio'])->name('AnuarioEstadistico.Grafico_Promedio_Remuneracion_porAnio');
Route::post('/AnuarioEstadistico/Grafico_ranking_promedio_remuneracion_regiones/{id}', [AnuarioEstadisticoController::class, 'Grafico_ranking_promedio_remuneracion_regiones'])->name('AnuarioEstadistico.Grafico_ranking_promedio_remuneracion_regiones');


Route::get('/AnuarioEstadistico/rptTrabajadoresSectorPrivado/', [AnuarioEstadisticoController::class, 'rptTrabajadoresSectorPrivado'])->name('AnuarioEstadistico.rptTrabajadoresSectorPrivado');
Route::get('/AnuarioEstadistico/rptEmpresasSectorPrivado/', [AnuarioEstadisticoController::class, 'rptEmpresasSectorPrivado'])->name('AnuarioEstadistico.rptEmpresasSectorPrivado');

Route::get('/AnuarioEstadistico/rptPrestadoresServ4taCategoria/', [AnuarioEstadisticoController::class, 'rptPrestadoresServ4taCategoria'])->name('AnuarioEstadistico.rptPrestadoresServ4taCategoria');
Route::post('/AnuarioEstadistico/Grafico_ranking_promedio_prestadores_servicio4ta/{id}', [AnuarioEstadisticoController::class, 'Grafico_ranking_promedio_prestadores_servicio4ta'])->name('AnuarioEstadistico.Grafico_ranking_promedio_prestadores_servicio4ta');
Route::post('/AnuarioEstadistico/Grafico_ranking_empresas_regiones/{id}', [AnuarioEstadisticoController::class, 'Grafico_ranking_empresas_regiones'])->name('AnuarioEstadistico.Grafico_ranking_empresas_regiones');
Route::post('/AnuarioEstadistico/Grafico_promedio_Empresas_sectorPrivado/{id}', [AnuarioEstadisticoController::class, 'Grafico_promedio_Empresas_sectorPrivado'])->name('AnuarioEstadistico.Grafico_promedio_Empresas_sectorPrivado');

Route::get('/Actividades/Principal', [ActividadController::class, 'Principal'])->name('Actividades.Principal');

// Route::get('/AnuarioEstadistico/rptPrestadoresServ4taPrivado/', [AnuarioEstadisticoController::class, 'rptPrestadoresServ4taPrivado'])->name('AnuarioEstadistico.rptPrestadoresServ4taPrivado');
