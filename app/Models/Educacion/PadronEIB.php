<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PadronEIB extends Model
{
    use HasFactory;

    protected $table = "edu_padron_EIB"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'importacion_id',            
                'anio_id',
                'ugel',
                'codModular',
                'anexo',
                'codLocal',
                'nombreInstEduc',
                'formaAtencion',
                'escenario',
                'nomLenguaOriginaria1',
                'nomLenguaOriginaria2',
                'nomLenguaOriginaria3',
                'fechaReg',
                'fecha_Act',
    ];
}
