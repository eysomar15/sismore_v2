<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    use HasFactory;
    protected $table = "par_ubigeo"; 
    
    protected $fillable = [
        'codigo',
        'nombre',
        'dependencia'];
}