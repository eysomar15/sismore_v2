@section('css')
@endsection

<div>
    <div id="container-speed" class="chart-container"></div>
</div>

<div class="content">
    <div class="container-fluid">
        @if ($importacion_id)
            <!--Widget-4 -->
            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-success rounded-circle mr-2">
                                <i class=" ion-md-home avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold">
                                        <span data-plugin="counterup">
                                            {{ number_format($info['se'], 0) }}
                                        </span>
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate">Servicios Educativos</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end card-box-->
                </div>

                <div class="col-md-3 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-info rounded-circle mr-2">
                                <i class=" ion ion-md-person avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold">
                                        <span data-plugin="counterup">
                                            {{ number_format($info['le'], 0) }}
                                        </span>
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate">Locales Escolares </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end card-box-->
                </div>

                <div class="col-md-3 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-info rounded-circle mr-2">
                                <i class=" ion ion-md-person avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold">
                                        <span data-plugin="counterup">
                                            {{ number_format($info['tm'], 0) }}
                                        </span>
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate">Estudiantes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card-box-->
                </div>

                <div class="col-md-3 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-info rounded-circle mr-2">
                                <i class=" ion ion-md-person avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold">
                                        <span data-plugin="counterup">
                                            {{ number_format($info['do'], 0) }}
                                        </span>
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate">Docentes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- grafica 1 --}}
            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body">
                            <div id="anal1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body">
                            <div id="anal2"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}

            {{-- grafica 2 --}}
            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body">
                            <div id="anal3"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body">
                            <div id="anal4"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}

            {{-- grafica 3 --}}
            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body">
                            <div id="anal5"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body">
                            <div id="anal6"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}

            {{-- grafica 5 --}}
            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body">
                            <div id="anal7"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body">
                            <div id="anal8"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}
            {{-- grafica 3 --}}
            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body">
                            <div id="anal9"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body">
                            <div id="anal10"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}

            {{-- tablaa 0 --}}
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla1" class="table table-striped table-bordered"
                                    style="font-size:11px;">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            <th>TIPO NIVEL</th>
                                            <th colspan="2">EBE</th>
                                            <th colspan="2">INICIAL</th>
                                            <th colspan="2">PRIMARIA</th>
                                            <th colspan="2">SECUNDARIA</th>
                                            <th colspan="2">TOTAL</th>
                                        </tr>
                                        <tr class="bg-primary text-white text-center">
                                            <th>PROVINCIA</th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($info['dt4']['head'] as $item)
                                            <tr>
                                                <th>{{ $item->provincia }}</th>
                                                <th class="text-center">{{ number_format($item->hebe, 0) }}</th>
                                                <th class="text-center">{{ number_format($item->mebe, 0) }}</th>
                                                <th class="text-center">{{ number_format($item->hini, 0) }}</th>
                                                <th class="text-center">{{ number_format($item->mini, 0) }}</th>
                                                <th class="text-center">{{ number_format($item->hpri, 0) }}</th>
                                                <th class="text-center">{{ number_format($item->mpri, 0) }}</th>
                                                <th class="text-center">{{ number_format($item->hsec, 0) }}</th>
                                                <th class="text-center">{{ number_format($item->msec, 0) }}</th>
                                                <th class="text-center">{{ number_format($item->htot, 0) }}</th>
                                                <th class="text-center">{{ number_format($item->mtot, 0) }}</th>
                                            </tr>
                                            @foreach ($info['dt4']['body'] as $item2)
                                                @if ($item2->provincia == $item->provincia)
                                                    <tr>
                                                        <td>{{ $item2->distrito }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item2->hebe, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item2->mebe, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item2->hini, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item2->mini, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item2->hpri, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item2->mpri, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item2->hsec, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item2->msec, 0) }}</td>
                                                        <th class="text-center">
                                                            {{ number_format($item2->htot, 0) }}</th>
                                                        <th class="text-center">
                                                            {{ number_format($item2->mtot, 0) }}</th>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt4']['foot']->hebe, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt4']['foot']->mebe, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt4']['foot']->hini, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt4']['foot']->mini, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt4']['foot']->hpri, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt4']['foot']->mpri, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt4']['foot']->hsec, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt4']['foot']->msec, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt4']['foot']->msec, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt4']['foot']->msec, 0) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}

            {{-- tablaa 1 --}}
            {{-- <div class="row">
                <div class="col-xl-12">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla1" class="table table-striped table-bordered" style="font-size:11px;">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            <th>TIPO NIVEL</th>
                                            <th colspan="2">EBA</th>
                                            <th colspan="2">EBE</th>
                                            <th colspan="2">EBR</th>
                                            <th colspan="2">ETP</th>
                                            <th colspan="2">SNU</th>
                                            <th colspan="2">Total</th>
                                        </tr>
                                        <tr class="bg-primary text-white text-center">
                                            <th>UGEL</th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                            <th><span title="HOMBRES">HOMBRES</span></th>
                                            <th><span title="MUJERES">MUJERES</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($info['dt1']['body'] as $item)
                                            <tr>
                                                <td>{{ $item->ugel }}</td>
                                                <td class="text-center">{{ number_format($item->EBAm, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->EBAf, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->EBEm, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->EBEf, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->EBRm, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->EBRf, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->ETPm, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->ETPf, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->SNUm, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->SNUf, 0) }}</td>
                                                <th class="text-center">{{ number_format($item->totalm, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($item->totalf, 0) }}
                                                </th>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->EBAm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->EBAf, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->EBEm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->EBEf, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->EBRm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->EBRf, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->ETPm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->ETPf, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->SNUm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->SNUf, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->totalm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt1']['foot']->totalf, 0) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- end  row --}}

            {{-- tabla 2 --}}
            {{-- <div class="row">
                <div class="col-xl-12">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla1" class="table table-striped table-bordered" style="font-size:11px;">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            <th>TIPO NIVEL</th>
                                            <th colspan="2">EBA</th>
                                            <th colspan="2">EBE</th>
                                            <th colspan="2">EBR</th>
                                            <th colspan="2">ETP</th>
                                            <th colspan="2">SNU</th>
                                            <th colspan="2">Total</th>
                                        </tr>
                                        <tr class="bg-primary text-white text-center">
                                            <th>UGEL</th>
                                            <th><span title="HOMBRES">DOCENTES</span></th>
                                            <th><span title="MUJERES">DIRECTORES</span></th>
                                            <th><span title="HOMBRES">DOCENTES</span></th>
                                            <th><span title="MUJERES">DIRECTORES</span></th>
                                            <th><span title="HOMBRES">DOCENTES</span></th>
                                            <th><span title="MUJERES">DIRECTORES</span></th>
                                            <th><span title="HOMBRES">DOCENTES</span></th>
                                            <th><span title="MUJERES">DIRECTORES</span></th>
                                            <th><span title="HOMBRES">DOCENTES</span></th>
                                            <th><span title="MUJERES">DIRECTORES</span></th>
                                            <th><span title="HOMBRES">DOCENTES</span></th>
                                            <th><span title="MUJERES">DIRECTORES</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($info['dt2']['body'] as $item)
                                            <tr>
                                                <td>{{ $item->ugel }}</td>
                                                <td class="text-center">{{ number_format($item->EBAm, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->EBAf, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->EBEm, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->EBEf, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->EBRm, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->EBRf, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->ETPm, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->ETPf, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->SNUm, 0) }}</td>
                                                <td class="text-center">{{ number_format($item->SNUf, 0) }}</td>
                                                <th class="text-center">{{ number_format($item->totalm, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($item->totalf, 0) }}
                                                </th>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->EBAm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->EBAf, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->EBEm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->EBEf, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->EBRm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->EBRf, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->ETPm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->ETPf, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->SNUm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->SNUf, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->totalm, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt2']['foot']->totalf, 0) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- end  row --}}

            {{-- tabla 3 --}}
            {{-- <div class="row">
                <div class="col-xl-12">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla1" class="table table-striped table-bordered" style="font-size:11px;">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            <th>TIPO GESTION</th>
                                            <th colspan="2">PRIVADA</th>
                                            <th colspan="2">PUBLICA</th>
                                            <th colspan="2">RURAL</th>
                                            <th colspan="2">URBANA</th>
                                            <th colspan="2">TOTAL</th>
                                        </tr>
                                        <tr class="bg-primary text-white text-center">
                                            <th>PROVINCIA</th>
                                            <th><span title="ESTUDIANTE">ESTUDIANTE</span></th>
                                            <th><span title="DOCENTE">DOCENTE</span></th>
                                            <th><span title="ESTUDIANTE">ESTUDIANTE</span></th>
                                            <th><span title="DOCENTE">DOCENTE</span></th>
                                            <th><span title="ESTUDIANTE">ESTUDIANTE</span></th>
                                            <th><span title="DOCENTE">DOCENTE</span></th>
                                            <th><span title="ESTUDIANTE">ESTUDIANTE</span></th>
                                            <th><span title="DOCENTE">DOCENTE</span></th>
                                            <th><span title="ESTUDIANTE">ESTUDIANTE</span></th>
                                            <th><span title="DOCENTE">DOCENTE</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($info['dt3']['head'] as $head)
                                            <tr>
                                                <th>{{ $head->provincia }}</th>
                                                <th class="text-center">{{ number_format($head->eprivada, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($head->dprivada, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($head->epublica, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($head->dpublica, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($head->eurbana, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($head->durbana, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($head->erural, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($head->drural, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($head->talumno, 0) }}
                                                </th>
                                                <th class="text-center">{{ number_format($head->tdocente, 0) }}
                                                </th>

                                            </tr>

                                            @foreach ($info['dt3']['body'] as $item)
                                                @if ($head->provincia == $item->provincia)
                                                    <tr>
                                                        <td>{{ $item->distrito }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->eprivada, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->dprivada, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->epublica, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->dpublica, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->eurbana, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->durbana, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->erural, 0) }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->drural, 0) }}</td>
                                                        <th class="text-center">
                                                            {{ number_format($item->talumno, 0) }}</th>
                                                        <th class="text-center">
                                                            {{ number_format($item->tdocente, 0) }}</th>

                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <td class="text-center">
                                                {{ number_format($info['dt3']['foot']->eprivada, 0) }}</td>
                                            <td class="text-center">
                                                {{ number_format($info['dt3']['foot']->dprivada, 0) }}</td>
                                            <td class="text-center">
                                                {{ number_format($info['dt3']['foot']->epublica, 0) }}</td>
                                            <td class="text-center">
                                                {{ number_format($info['dt3']['foot']->dpublica, 0) }}</td>
                                            <td class="text-center">
                                                {{ number_format($info['dt3']['foot']->eurbana, 0) }}</td>
                                            <td class="text-center">
                                                {{ number_format($info['dt3']['foot']->durbana, 0) }}</td>
                                            <td class="text-center">
                                                {{ number_format($info['dt3']['foot']->erural, 0) }}</td>
                                            <td class="text-center">
                                                {{ number_format($info['dt3']['foot']->drural, 0) }}</td>
                                            <th class="text-center">
                                                {{ number_format($info['dt3']['foot']->talumno, 0) }}</th>
                                            <th class="text-center">
                                                {{ number_format($info['dt3']['foot']->tdocente, 0) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- end  row --}}

            {{-- <div class="row">
                <div class="col-xl-12">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla1" class="table table-striped table-bordered" style="font-size:11px;">
                                    <thead>
                                        <tr class="bg-primary text-white text-center">
                                            <th>TIPO GESTION</th>
                                            <th colspan="4">Privada</th>
                                            <th colspan="4">Publica</th>
                                            <th colspan="4">Total</th>
                                        </tr>
                                        <tr class="bg-primary text-white text-center">
                                            <th>NIVEL MODALIDAD</th>
                                            <th><span title="HOMBRES">H</span></th>
                                            <th>%</th>
                                            <th><span title="MUJERES">M</span></th>
                                            <th>%</th>
                                            <th><span title="HOMBRES">H</span></th>
                                            <th>%</th>
                                            <th><span title="MUJERES">M</span></th>
                                            <th>%</th>
                                            <th><span title="HOMBRES">H</span></th>
                                            <th>%</th>
                                            <th><span title="MUJERES">M</span></th>
                                            <th>%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($info['dt1']['head'] as $head)
                                            <tr>
                                                <th>{{ $head->tipo }}</th>
                                                <th class="text-center">{{ number_format($head->privadom, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->privadomp }}%</th>
                                                <th class="text-center">{{ number_format($head->privadof, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->privadofp }}%</th>
                                                <th class="text-center">{{ number_format($head->publicom, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->publicomp }}%</th>
                                                <th class="text-center">{{ number_format($head->publicof, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->publicofp }}%</th>
                                                <th class="text-center">{{ number_format($head->totalm, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->totalmp }}%</th>
                                                <th class="text-center">{{ number_format($head->totalf, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->totalfp }}%</th>
                                            </tr>
                                            @foreach ($info['dt1']['body'] as $item)
                                                @if ($item->tipo == $head->tipo)
                                                    <tr>
                                                        <td>{{ $item->nivel }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->privadom, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->privadomp }}%</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->privadof, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->privadofp }}%</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->publicom, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->publicomp }}%</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->publicof, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->publicofp }}%</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->totalm, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->totalmp }}%</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->totalf, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->totalfp }}%</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th>{{ number_format($info['dt1']['foot']['privadom'], 0) }}</th>
                                            <th>100%</th>
                                            <th>{{ number_format($info['dt1']['foot']['privadof'], 0) }}</th>
                                            <th>100%</th>
                                            <th>{{ number_format($info['dt1']['foot']['publicom'], 0) }}</th>
                                            <th>100%</th>
                                            <th>{{ number_format($info['dt1']['foot']['publicof'], 0) }}</th>
                                            <th>100%</th>
                                            <th>{{ number_format($info['dt1']['foot']['totalm'], 0) }}</th>
                                            <th>100%</th>
                                            <th>{{ number_format($info['dt1']['foot']['totalf'], 0) }}</th>
                                            <th>100%</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- end  row --}}

            {{-- <div class="row">
                <div class="col-xl-12">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tabla1" class="table table-striped table-bordered" style="font-size:11px;">
                                    <thead>
                                        <thead>
                                            <tr class="bg-primary text-white text-center">
                                                <th colspan="1">AREA GEOGRAFICA</th>
                                                <th colspan="4">Rural</th>
                                                <th colspan="4">Urbana</th>
                                                <th colspan="4">Total</th>
                                            </tr>
                                            <tr class="bg-primary text-white text-center">
                                                <th>TIPO NIVEL</th>
                                                <th><span title="ESTUDIANTE">E</span></th>
                                                <th>%</th>
                                                <th><span title="DOCENTE">D</span></th>
                                                <th>%</th>
                                                <th><span title="ESTUDIANTE">E</span></th>
                                                <th>%</th>
                                                <th><span title="DOCENTE">D</span></th>
                                                <th>%</th>
                                                <th><span title="ESTUDIANTE">E</span></th>
                                                <th>%</th>
                                                <th><span title="DOCENTE">D</span></th>
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                    </thead>
                                    <tbody>
                                        @foreach ($info['dt2']['head'] as $head)
                                            <tr>
                                                <th>{{ $head->tipo }}</th>
                                                <th class="text-center">{{ number_format($head->alumnor, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->alumnorp }}%</th>
                                                <th class="text-center">{{ number_format($head->docenter, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->docenterp }}%</th>
                                                <th class="text-center">{{ number_format($head->alumnou, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->alumnoup }}%</th>
                                                <th class="text-center">{{ number_format($head->docenteu, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->docenteup }}%</th>
                                                <th class="text-center">{{ number_format($head->totala, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->totalap }}%</th>
                                                <th class="text-center">{{ number_format($head->totald, 0) }}
                                                </th>
                                                <th class="text-center">{{ $head->totaldp }}%</th>
                                            </tr>
                                            @foreach ($info['dt2']['body'] as $item)
                                                @if ($item->tipo == $head->tipo)
                                                    <tr>
                                                        <td>{{ $item->nivel }}</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->alumnor, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->alumnorp }}%</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->docenter, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->docenterp }}%</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->alumnou, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->alumnoup }}%</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->docenteu, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->docenteup }}%</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->totala, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->totalap }}%</td>
                                                        <td class="text-center">
                                                            {{ number_format($item->totald, 0) }}
                                                        </td>
                                                        <td class="text-center">{{ $item->totaldp }}%</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    </tbody>

                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th>{{ number_format($info['dt2']['foot']['alumnor'], 0) }}</th>
                                            <th>100%</th>
                                            <th>{{ number_format($info['dt2']['foot']['docenter'], 0) }}</th>
                                            <th>100%</th>
                                            <th>{{ number_format($info['dt2']['foot']['alumnou'], 0) }}</th>
                                            <th>100%</th>
                                            <th>{{ number_format($info['dt2']['foot']['docenteu'], 0) }}</th>
                                            <th>100%</th>
                                            <th>{{ number_format($info['dt2']['foot']['totala'], 0) }}</th>
                                            <th>100%</th>
                                            <th>{{ number_format($info['dt2']['foot']['totald'], 0) }}</th>
                                            <th>100%</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- end  row --}}


            {{-- fin --}}
            <div class="progress progress-sm m-0">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                    aria-valuemax="100" style="width: 100%"></div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <p class="titulo_Indicadores  mb-0"></p>
                </div>
                <div class="col-md-9 text-right">
                    <p class="texto_dfuente  mb-0"> Fuente: ESCALE - MINEDU – PADRON WEB, ultima actualizacion del
                        <span
                            id="fechaActualizacion">{{ date('d/m/Y', strtotime($imp['fechaActualizacion'])) }}</span>
                    </p>
                </div>
            </div>
            <!-- end row -->
        @else
            @if ($importables['padron_web'])
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-fill bg-danger">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title text-white">NO HAY IMPORTACION DE PADRON WEB</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($importables['siagie_matricula'])
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-fill bg-danger">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title text-white">NO HAY IMPORTACION DE SIAGIE MATRICULA</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($importables['nexus_minedu'])
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-fill bg-danger">
                            <div class="card-header bg-transparent">
                                <h3 class="card-title text-white">NO HAY IMPORTACION NEXUS MINEDU</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- end row -->
        @endif


    </div>
</div>
{{-- @php echo $info['g1']['categoriax'] @endphp, @php echo $info['g1']['datax'] @endphp --}}



@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            Highcharts.setOptions({
                colors: Highcharts.map(Highcharts.getOptions().colors, function(color) {
                    return {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.3,
                            r: 0.7
                        },
                        stops: [
                            [0, color],
                            [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
                        ]
                    };
                }),
                lang: {
                    thousandsSep: ","
                }
            });

            @if ($importacion_id)
                gSimpleColumn('anal1', <?= $info['g1'] ?>,
                    'ESTUDIANTES SEGÚN TIPO DE NIVEL EDUCATIVO', 'Fuente:SIAGIE', '');

                gSimpleColumn('anal2', <?= $info['g2'] ?>,
                    'DOCENTE SEGÚN TIPO DE NIVEL EDUCATIVO', 'Fuente:NEXUS', '');

                gPie('anal3', <?= $info['g3']['pts'] ?>,
                    'ESTUDIANTES MATRICULADOS SEGUN GENERO', 'Fuente:SIAGIE <?= $info['g3']['anio'] ?>', '');
                gPie('anal4', <?= $info['g4']['pts'] ?>,
                    'DOCENTES MATRICULADOS SEGUN GENERO', 'Fuente:NEXUS <?= $info['g4']['anio'] ?>', '');

                gPie('anal5', <?= $info['g5']['pts'] ?>,
                    'ESTUDIANTES MATRICULADOS SEGUN TIPO GESTION', 'Fuente:SIAGIE <?= $info['g5']['anio'] ?>',
                    '');
                gPie('anal6', <?= $info['g6']['pts'] ?>,
                    'DOCENTES SEGUN TIPO GESTION', 'Fuente:NEXUS <?= $info['g6']['anio'] ?>', '');

                gPie('anal7', <?= $info['g7']['pts'] ?>,
                    'ESTUDIANTES MATRICULADOS SEGUN AREA GEOGRAFICA',
                    "Fuente:SIAGIE <?= $info['g7']['anio'] ?>", '');
                gPie('anal8', <?= $info['g8']['pts'] ?>,
                    'DOCENTES SEGUN AREA GEOGRAFICA', "Fuente:NEXUS <?= $info['g8']['anio'] ?>", '');

                gSimpleColumn('anal9', <?= $info['g9']['pts'] ?>,
                    'ESTUDIANTES MATRICULADOS SEGÚN UGEL', 'Fuente:SIAGIE <?= $info['g9']['anio'] ?>', '');

                gSimpleColumn('anal10', <?= $info['g10']['pts'] ?>,
                    'DOCENTE DE GETION PUBLICA SEGÚN UGEL', 'Fuente:NEXUS <?= $info['g10']['anio'] ?>', '');
            @endif

        });

        function gSimpleColumn(div, datax, titulo, subtitulo, tituloserie) {
            Highcharts.chart(div, {
                chart: {
                    type: 'column',
                },
                title: {
                    enabled: false,
                    text: titulo,
                },
                subtitle: {
                    text: subtitulo,
                },
                xAxis: {
                    type: 'category',
                },
                yAxis: {
                    /* max: 100, */
                    title: {
                        enabled: false,
                        text: 'Porcentaje',
                    }
                },
                series: [{
                    showInLegend: tituloserie != '',
                    name: tituloserie,
                    label: {
                        enabled: false
                    },
                    colorByPoint: true,
                    data: datax,
                }],
                tooltip: {
                    pointFormat: '<span style="color:{point.color}">\u25CF</span> Hay: <b>{point.y}</b><br/>',
                    shared: true
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                        },
                    }
                },
                credits: false,
            });
        }

        function gPie(div, datos, titulo, subtitulo, tituloserie) {
            Highcharts.chart(div, {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: titulo, //'Browser market shares in January, 2018'
                },
                subtitle: {
                    text: subtitulo,
                },
                tooltip: {
                    //pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>',
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            //format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            format: '{point.conteo} ( {point.percentage:.1f}% )',
                            connectorColor: 'silver'
                        }
                    }
                },
                series: [{
                    showInLegend: true,
                    //name: 'Share',                    
                    data: datos,
                }],
                credits: false,
            });
        }

        function gBasicColumn(div, categorias, datos, titulo, subtitulo) {
            Highcharts.chart(div, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: titulo
                },
                subtitle: {
                    text: subtitulo
                },
                xAxis: {
                    categories: categorias,
                },
                yAxis: {

                    min: 0,
                    title: {
                        text: 'Rainfall (mm)',
                        enabled: false
                    }
                },

                tooltip: {
                    pointFormat: '<span style="color:{point.color}">\u25CF</span> Hay: <b>{point.y}</b><br/>',
                    shared: true
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                        },
                    }
                },
                series: datos,
                credits: false,
            });
        }
    </script>
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts-more.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>
@endsection
