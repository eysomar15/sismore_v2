<?php

namespace App\Models\Presupuesto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseIngresos extends Model
{
    use HasFactory;
    protected $table = 'pres_base_ingresos';
    public $timestamps = false;

    protected $fillable = [
        'importacion_id',
        'anio_id',
        'meses_id',
        'pliego_id',
        'ubigeo_id',
        'sector_id',
        'recursosingreso_id',
        'especificadetalle_id',
        'pia',
        'pim',
        'recaudado',
    ];
}
