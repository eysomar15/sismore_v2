<?php

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoGestion extends Model
{
    use HasFactory;
    protected $table = "edu_tipoGestion"; 
    
    protected $fillable = [
        'codigo',
        'nombre',
        'dependencia'];
}
