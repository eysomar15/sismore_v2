<table id="tabla1" class="table table-striped table-bordered tablex" style="font-size:11px;">
    <thead>
        <tr class="bg-primary text-white text-center">
            <th>Código</th>
            <th>Unidades Ejecutoras</th>
            <th>PIA</th>
            <th>PIM</th>
            <th>CERTIFICADO</th>
            <th>DEVENGADO</th>
            <th>% ejecución</th>
            <th>Saldo CERT.</th>
            <th>Saldo DEV.</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($body as $item)
            <tr class="text-right">
                {{-- <td class="text-left">{{ $item->cod.' '.$item->ff }}</td> --}}
                <td class="text-left">{{ $item->codigo }}</td>
                <td class="text-left">{{ $item->ue }}</td>
                <td>{{ number_format($item->pia, 0) }}</td>
                <td>{{ number_format($item->pim, 0) }}</td>
                <td>{{ number_format($item->cert, 0) }}</td>
                <td>{{ number_format($item->dev, 0) }}</td>
                <th class="text-center">{!! avance($item->eje) !!}</th>
                <td>{{ number_format($item->saldo1, 0) }}</td>
                <td>{{ number_format($item->saldo2, 0) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="text-center bg-primary text-white">
            <th class="text-left" colspan="2">TOTAL</th>
            <th>{{ number_format($foot['pia'], 0) }}</th>
            <th>{{ number_format($foot['pim'], 0) }}</th>
            <th>{{ number_format($foot['cert'], 0) }}</th>
            <th>{{ number_format($foot['dev'], 0) }}</th>
            <th class="text-center">{!! avance($foot['eje']) !!}</th>
            <th>{{ number_format($foot['saldo1'], 0) }}</th>
            <th>{{ number_format($foot['saldo2'], 0) }}</th>
        </tr>
    </tfoot>
</table>



@php
    function avance($monto)
    {
        if ($monto < 51) {
            return '<span class="badge badge-pill badge-danger" style="font-size:85%;">' . round($monto, 1) . '%</span>';
        } elseif ($monto < 75) {
            return '<span class="badge badge-pill badge-warning" style="font-size:85%;background-color:#eb960d;">' . round($monto, 1) . '%</span>';
        } else {
            return '<span class="badge badge-pill badge-success" style="font-size:85%;">' . round($monto, 1) . '%</span>';
        }
    }
@endphp
