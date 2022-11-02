<?php

namespace App\Models\Presupuesto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseSiafWeb extends Model
{
    use HasFactory;
    protected $table = 'pres_base_siafweb';
    public $timestamps = false;

    protected $fillable = [
        'importacion_id',
        'anio_id',
        'meses_id',
        'unidadejecutora_id',
        'meta_id',
        'categoriapresupuestal_id',
        'productoproyecto_id',
        'productos_id',
        'proyectos_id',
        'act_acc_obr_id',
        'obra_id',
        'actividades_id',
        'accion_id',
        'grupofuncional_id',
        'meta',
        'finalidad_id',
        'unidad_medida',
        'valor',
        'rubro_id',
        'categoriagasto_id',
        'especificadetalle_id',
        'pia',
        'pim',
        'certificado',
        'compromiso_anual',
        'devengado',

    ];
}
