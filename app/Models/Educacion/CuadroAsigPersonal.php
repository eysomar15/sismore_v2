<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuadroAsigPersonal extends Model
{
    use HasFactory;

    protected $table = "edu_cuadroasigpersonal";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable,
     *
     * @var array
     */
    protected $fillable = [
        'importacion_id',
        'region',
        'unidad_ejecutora',
        'organo_intermedio',
        'provincia',
        'distrito',
        'tipo_ie',
        'gestion',
        'zona',
        'codmod_ie',
        'codigo_local',
        'clave8',
        'nivel_educativo',
        'institucion_educativa',
        'codigo_plaza',
        'tipo_trabajador',
        'sub_tipo_trabajador',
        'cargo',
        'situacion_laboral',
        'motivo_vacante',
        'documento_identidad',
        'codigo_modular',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'fecha_ingreso',
        'categoria_remunerativa',
        'jornada_laboral',
        'estado',
        'fecha_nacimiento',
        'fecha_inicio',
        'fecha_termino',
        'tipo_registro',
        'ley',
        'preventiva',
        //'referencia_preventiva',
        'especialidad',
        'tipo_estudios',
        'estado_estudios',
        'grado',
        'mencion',
        'especialidad_profesional',
        'fecha_resolucion',
        'numero_resolucion',
        'centro_estudios',
        'celular',
        'email',
        'sexo',
        'desc_superior',

    ];
}
