<?php

namespace App\Models\Presupuesto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImporGastos extends Model
{
    use HasFactory;
    protected $table = 'pres_impor_gastos';
    public $timestamps = false;

    protected $fillable = [
        'importacion_id', 'anio', 'mes', 'cod_uni_eje', 'unidad_ejecutora',
        'cod_distrito', 'sec_func', 'cod_cat_pres', 'categoria_presupuestal', 'tipo_prod_proy',
        'cod_prod_proy', 'producto_proyecto', 'tipo_act_acc_obra', 'cod_act_acc_obra', 'actividad_accion_obra',
        'cod_funcion', 'funcion', 'cod_div_fun', 'division_funcional', 'cod_gru_fun',
        'grupo_funcional', 'cod_finalidad', 'meta_nombre', 'cod_fue_fin', 'fuente_financiamiento',
        'cod_rubro', 'rubro', 'cod_tipo_rec', 'tipo_recurso', 'cod_categ_gasto',
        'categoria_gasto', 'tipo_trans', 'cod_gen', 'generica',
        'cod_subgen', 'subgenerica', 'cod_subgen_det', 'subgenerica_detalle', 'cod_espe',
        'especifica', 'cod_espe_det', 'especifica_detalle', 'monto_pia',
        'monto_pim', 'monto_certificado', 'monto_comprometido_anual', 'monto_comprometido',
        'monto_devengado', 'monto_girado', 'avance',
    ];
}
