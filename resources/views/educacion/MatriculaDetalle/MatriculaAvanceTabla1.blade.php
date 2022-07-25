<table id="tabla0" class="table table-striped table-bordered" style="font-size:11px;">
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
                <th class="table-active text-left"><a href="#" class="">{{ $item->tipo }}</a></th>
                <th class="table-warning">{{ number_format($item->tregA) }}</th>
                <th class="table-active">{{ number_format($anoF != 1 ? $item->ene : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 2 ? $item->feb : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 3 ? $item->mar : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 4 ? $item->abr : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 5 ? $item->may : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 6 ? $item->jun : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 7 ? $item->jul : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 8 ? $item->ago : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 9 ? $item->set : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 10 ? $item->oct : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 11 ? $item->nov : 0) }}</th>
                <th class="table-active">{{ number_format($anoF != 12 ? $item->dic : 0) }}</th>
                <th class="table-active">{{ number_format($item->treg) }}</th>
                <th class="table-success">{{ round($item->avance * 100, 2) }}%</th>
            </tr>

            @foreach ($base as $item2)
                @if ($item2->tipo == $item->tipo)
                    <tr class="text-center">
                        <td class="text-left"><a href="#" class="">{{ $item2->nivel }}</a></td>
                        <td class="table-warning">{{ number_format($item2->tregA) }}</td>
                        <td>{{ number_format($anoF != 1 ? $item2->ene : 0) }}</td>
                        <td>{{ number_format($anoF != 2 ? $item2->feb : 0) }}</td>
                        <td>{{ number_format($anoF != 3 ? $item2->mar : 0) }}</td>
                        <td>{{ number_format($anoF != 4 ? $item2->abr : 0) }}</td>
                        <td>{{ number_format($anoF != 5 ? $item2->may : 0) }}</td>
                        <td>{{ number_format($anoF != 6 ? $item2->jun : 0) }}</td>
                        <td>{{ number_format($anoF != 7 ? $item2->jul : 0) }}</td>
                        <td>{{ number_format($anoF != 8 ? $item2->ago : 0) }}</td>
                        <td>{{ number_format($anoF != 9 ? $item2->set : 0) }}</td>
                        <td>{{ number_format($anoF != 10 ? $item2->oct : 0) }}</td>
                        <td>{{ number_format($anoF != 11 ? $item2->nov : 0) }}</td>
                        <td>{{ number_format($anoF != 12 ? $item2->dic : 0) }}</td>
                        <td>{{ number_format($item2->treg) }}</td>
                        <td class="table-success">{{ round($item2->avance * 100, 2) }}%</td>
                    </tr>
                @endif
            @endforeach
        @endforeach

    </tbody>
    <tfoot>
        <tr class="text-center">
            <th class="text-left">Total</th>
            <th class="table-warning">{{ number_format($foot['meta'], 0) }}</th>
            <th>{{ number_format($anoF != 1 ? $foot['ene'] : 0) }}</th>
            <th>{{ number_format($anoF != 2 ? $foot['feb'] : 0) }}</th>
            <th>{{ number_format($anoF != 3 ? $foot['mar'] : 0) }}</th>
            <th>{{ number_format($anoF != 4 ? $foot['abr'] : 0) }}</th>
            <th>{{ number_format($anoF != 5 ? $foot['may'] : 0) }}</th>
            <th>{{ number_format($anoF != 6 ? $foot['jun'] : 0) }}</th>
            <th>{{ number_format($anoF != 7 ? $foot['jul'] : 0) }}</th>
            <th>{{ number_format($anoF != 8 ? $foot['ago'] : 0) }}</th>
            <th>{{ number_format($anoF != 9 ? $foot['set'] : 0) }}</th>
            <th>{{ number_format($anoF != 10 ? $foot['oct'] : 0) }}</th>
            <th>{{ number_format($anoF != 11 ? $foot['nov'] : 0) }}</th>
            <th>{{ number_format($anoF != 12 ? $foot['dic'] : 0) }}</th>
            <th>{{ number_format($foot['total']) }}</th>
            <th class="table-success">{{ round($foot['avance'] * 100, 2) }}%</th>
        </tr>

    </tfoot>
</table>
