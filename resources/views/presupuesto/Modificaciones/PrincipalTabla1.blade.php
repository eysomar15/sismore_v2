<table id="tabla1" class="table table-striped table-bordered tablex" style="font-size:11px;">
    <thead>
        <tr class="bg-primary text-white text-center">
            <th>Unidad Ejecutora</th>
            <th>Documento</th>
            <th>Fecha Aprobacion</th>
            <th>Justificacion</th>
            <th>Actividades</th>
            <th>fuente de Financiamiento</th>
            <th>Categoria Presupuestal</th>
            <th>Producto/Proyecto</th>
            <th>Anulacion</th>
            <th>Credito</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($body as $pos => $item)
            <tr class="text-right">
                <td class="text-center">{{ $item->unidad_ejecutora }}</td>
                <td>{{ $item->documento }}</td>
                <td>{{ $item->fecha_aprobacion }}</td>
                <td>{{ $item->justificacion }}</td>
                <td>{{ $item->fuente_financiamiento }}</td>
                <td>{{ $item->categoria_presupuestal }}</td>
                <td>{{ $item->producto_proyecto }}</td>
                <td>{{ $item->anulacion }}</td>
                <td>{{ $item->credito }}</td>
            </tr>
        @endforeach
    </tbody>
    {{-- <tfoot>
        <tr class="text-right bg-primary text-white">
            <th class="text-left" colspan="2">TOTAL</th>
        </tr>
    </tfoot> --}}
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
