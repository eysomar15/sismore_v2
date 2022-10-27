<?php

namespace App\Exports;

use App\Repositories\Presupuesto\BaseGastosRepositorio;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

class BaseGastosExport implements FromView, ShouldAutoSize
{
    public $importacion_id;

    public function __construct($importacion_id)
    {
        $this->importacion_id = $importacion_id;
    }

    public function view(): View
    {
        $body = BaseGastosRepositorio::pim_ejecutado_noejecutado_tipogobierno();
        $foot = ['gnp' => 0, 'gnd' => 0, 'gnne' => 0, 'glp' => 0, 'gld' => 0, 'glne' => 0, 'grp' => 0, 'grd' => 0, 'grne' => 0, 'ttp' => 0, 'ttd' => 0, 'ttne' => 0];
        foreach ($body as $key => $value) {
            $foot['gnp'] += $value->gnp;
            $foot['gnd'] += $value->gnd;
            $foot['gnne'] += $value->gnne;
            $foot['glp'] += $value->glp;
            $foot['gld'] += $value->gld;
            $foot['glne'] += $value->glne;
            $foot['grp'] += $value->grp;
            $foot['grd'] += $value->grd;
            $foot['grne'] += $value->grne;
            $foot['ttp'] += $value->ttp;
            $foot['ttd'] += $value->ttd;
            $foot['ttne'] += $value->ttne;
        }
        return view("presupuesto.inicioPresupuestohometabla1excel", compact('body', 'foot'));
    }


}
