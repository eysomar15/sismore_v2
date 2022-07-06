<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImporPadronWeb extends Model
{
    use HasFactory;

    protected $table = "edu_impor_padronweb";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'importacion_id',
        'institucioneducativa_id',
        'localidad',
        'd_Fte_Dato',
        'total_alumno_m',
        'total_alumno_f',
        'total_alumno',
        'total_docente',
        'total_seccion',
        'fecha_actual',
    ];
}
