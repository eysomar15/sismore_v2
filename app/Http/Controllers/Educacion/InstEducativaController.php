<?php

namespace App\Http\Controllers\Educacion;

use App\Http\Controllers\Controller;
use App\Repositories\Educacion\InstEducativaRepositorio;
use App\Utilities\Utilitario;
use Illuminate\Database\Eloquent\Collection;

class InstEducativaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function principal()
    {
        $importaciones_padronweb = InstEducativaRepositorio::importaciones_padronweb();
        //return $importaciones_padronweb;

        $fecha_version = Utilitario::fecha_formato_texto_completo($importaciones_padronweb->first()->fechaActualizacion);
        //return $fecha_version;

        $total_tipoGestion = InstEducativaRepositorio::total_tipoGestion();
        //return $total_tipoGestion;

        $privadas = $total_tipoGestion->first()->privada;
        $publicas = $total_tipoGestion->first()->publica;


        return view('educacion.InstEducativa.Principal', compact('fecha_version', 'privadas', 'publicas'));
    }

    public function reporteDistrito()

    {
        $lista_resumen_porDistrito = InstEducativaRepositorio::resumen_porDistrito_tipoGestion();
        $lista_resumen_porProvincia = InstEducativaRepositorio::resumen_porProvincia_tipoGestion();
        // $sumatoria_Provincia = $this->sumatoria_Provincia($lista_resumen_porDistrito);
        $lista_resumen_porRegion = InstEducativaRepositorio::resumen_porRegion();

        return view('educacion.InstEducativa.ReporteDistrito', compact('lista_resumen_porDistrito', 'lista_resumen_porRegion', 'lista_resumen_porProvincia'));
    }

    public function sumatoria_Provincia($lista_resumen_porDistrito)
    {
        $lista_provincias = $lista_resumen_porDistrito->unique('provincia');

        $sumatoria_Provincia = [];

        foreach ($lista_provincias as $key => $item) {
            $suma_activas = 0;
            $suma_inactivas = 0;

            foreach ($lista_resumen_porDistrito as $key => $item2) {
                if ($item->provincia == $item2->provincia) {
                    $suma_activas += $item2->activas;
                    $suma_inactivas += $item2->inactivas;
                }
            }

            $sumatoria_Provincia[] = (['provincia' => $item->provincia, 'suma_activas' =>  $suma_activas, 'suma_inactivas' =>  $suma_inactivas]);
        }

        return $sumatoria_Provincia;
    }

    public function GraficoBarras_Instituciones_Distrito()
    {
        $lista_resumen_porProvincia = InstEducativaRepositorio::resumen_porProvincia();

        /************* GRAFICO BARRAS*******************/
        $categoria_nombres = [];
        $recorre = 1;

        // array_merge concatena los valores del arreglo, mientras recorre el foreach
        foreach ($lista_resumen_porProvincia as $key => $lista) {

            $data = [];
            $data = array_merge($data, [intval($lista->activas)]);
            $puntos[] = ['name' => $lista->provincia, 'data' =>  $data];
        }

        $categoria_nombres[] = 'UGEL';

        $nombreGraficoBarra = 'GraficoBarras_Instituciones_Distrito'; // este nombre va de la mano con el nombre del DIV en la vista
        $titulo = 'INSTITUCIONES EDUCATIVAS POR DISTRITOS';
        $subTitulo = 'Fuente: PADRON WEB - ESCALE';
        $titulo_y = 'Numero de Instituciones Educativas';

        return view(
            'graficos.Barra',
            ["data" => json_encode($puntos), "categoria_nombres" => json_encode($categoria_nombres)],
            compact('titulo_y', 'titulo', 'subTitulo', 'nombreGraficoBarra')
        );
    }
}
