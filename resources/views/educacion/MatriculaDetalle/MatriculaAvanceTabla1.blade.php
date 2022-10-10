<table id="tabla0" class="table table-striped table-bordered tablex" style="font-size:11px;">
    <thead>
        <tr class="bg-primary text-white text-center">
            <th>Nivel Modalidad</th>
            <th>Meta</th>
            <th>ene</th>
            <th>feb</th>
            <th>mar</th>
            <th>abr</th>
            <th>may</th>
            <th>jun</th>
            <th>jul</th>
            <th>ago</th>
            <th>set</th>
            <th>oct</th>
            <th>nov</th>
            <th>dic</th>
            <th>Total</th>
            <th>%Avance</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($head as $item)
            <tr class="text-center">
                <th class="table-warning text-left"><a href="#" class="">{{ $item->tipo }}</a></th>
                <th class="table-warning">{{ number_format($item->tregA) }}</th>
                <th class="table-warning">{!! bajas($anoF == 1, $item->ene, $anoF - 1, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 2, $item->feb, $anoF - 2, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 3, $item->mar, $anoF - 3, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 4, $item->abr, $anoF - 4, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 5, $item->may, $anoF - 5, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 6, $item->jun, $anoF - 6, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 7, $item->jul, $anoF - 7, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 8, $item->ago, $anoF - 8, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 9, $item->set, $anoF - 9, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 10, $item->oct, $anoF - 10, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 11, $item->nov, $anoF - 11, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! bajas($anoF == 12, $item->dic, $anoF - 12, 13, 0, $anos) !!}</th>
                <th class="table-warning">{!! number_format($item->treg) !!}</th>
                <td class="table-warning">{!! avance($item->avance * 100) !!}</td>
            </tr>

            @foreach ($base as $item2)
                @if ($item2->tipo == $item->tipo)
                    <tr class="text-center">
                        <td class="text-left"><a href="#"
                                class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $item2->nivel }}</a></td>
                        <th>{{ number_format($item2->tregA) }}</th>
                        <td>{!! bajas($anoF == 1, $item2->ene, $anoF - 1, 1, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 2, $item2->feb, $anoF - 2, 2, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 3, $item2->mar, $anoF - 3, 3, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 4, $item2->abr, $anoF - 4, 4, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 5, $item2->may, $anoF - 5, 5, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 6, $item2->jun, $anoF - 6, 6, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 7, $item2->jul, $anoF - 7, 7, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 8, $item2->ago, $anoF - 8, 8, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 9, $item2->set, $anoF - 9, 9, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 10, $item2->oct, $anoF - 10, 10, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 11, $item2->nov, $anoF - 11, 11, $item2->id, $anos) !!}</td>
                        <td>{!! bajas($anoF == 12, $item2->dic, $anoF - 12, 12, $item2->id, $anos) !!}</td>
                        <th>{!! number_format($item2->treg) !!}</th>
                        <td>{!! avance($item2->avance * 100) !!}</td>
                    </tr>
                @endif
            @endforeach
        @endforeach

    </tbody>
    <tfoot>
        <tr class="text-center bg-primary text-white">
            <th class="text-left">Total</th>
            <th>{{ number_format($foot['meta'], 0) }}</th>
            <th>{!! bajas($anoF == 1, $foot['ene'], $anoF - 1, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 2, $foot['feb'], $anoF - 2, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 3, $foot['mar'], $anoF - 3, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 4, $foot['abr'], $anoF - 4, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 5, $foot['may'], $anoF - 5, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 6, $foot['jun'], $anoF - 6, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 7, $foot['jul'], $anoF - 7, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 8, $foot['ago'], $anoF - 8, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 9, $foot['set'], $anoF - 9, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 10, $foot['oct'], $anoF - 10, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 11, $foot['nov'], $anoF - 11, 13, 0, $anos) !!}</th>
            <th>{!! bajas($anoF == 12, $foot['dic'], $anoF - 12, 13, 0, $anos) !!}</th>
            <th>{!! number_format($foot['total']) !!}</th>
            <th>{!! avance($foot['avance'] * 100) !!}</th>
        </tr>

    </tfoot>
</table>

@php
function avance($monto)
{
    if ($monto < 51) {
        return '<span class="badge badge-pill badge-danger" style="font-size:85%;">' . round($monto, 1) . '%</span>';
    } elseif ($monto < 100) {
        return '<span class="badge badge-pill badge-warning" style="font-size:85%;background-color:#eb960d;">' . round($monto, 1) . '%</span>';
    } else {
        return '<span class="badge badge-pill badge-success" style="font-size:85%;">' . round($monto, 1) . '%</span>';
    }
}
function bajas($anoF, $monto, $paint, $mes, $nivel, $ano)
{
    if (!$anoF) {
        if ($paint > 0) {
            if ($monto < 0) {
                return '<a href="javascript:void(0)" onclick="openrojos(' . $mes . ',' . $nivel . ',' . $ano . ')"><span class="badge badge-pill badge-danger" style="font-size:85%;">' . round($monto, 0) . '</span></a>';
            } else {
                return '<a href="javascript:void(0)" onclick="openrojos(' . $mes . ',' . $nivel . ',' . $ano . ')">' . round($monto, 0) . '</a>';
                //return number_format($monto);
            }
        } else {
            return '';
        }
    } else {
        return '';
    }
}
/* function bajas($monto)
{
    if ($monto < 0) {
        return '<span class="badge badge-pill badge-danger" style="font-size:85%;">' . round($monto, 0) . '</span>';
    } else {
        return number_format($monto);
    }
} */
@endphp
