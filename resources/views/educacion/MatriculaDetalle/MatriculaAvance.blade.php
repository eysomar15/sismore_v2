@extends('layouts.main', ['titlePage' => ''])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fill bg-primary  mb-0">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title text-white text-center">AVANCE MATRICULA SEGÚN SIAGIE- MINEDO ACTUALIZADO AL
                            18/07/2022</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="form_opciones" name="form_opciones" action="POST">
                            @csrf
                            <div class="form-group row mb-0">
                                <label class="col-md-1 col-form-label">Año</label>
                                <div class="col-md-2">
                                    <select id="ano" name="ano" class="form-control" onchange="cargartabla0()">
                                        @foreach ($anios as $item)
                                            <option value="{{ $item->id }}">{{ $item->anio }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-1 col-form-label">Gestion</label>
                                <div class="col-md-3">
                                    <select id="gestion" name="gestion" class="form-control" onchange="cargartabla0()">
                                        <option value="0">Todos</option>
                                        @foreach ($gestions as $prov)
                                            <option value="{{ $prov['id'] }}">{{ $prov['nombre'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label class="col-md-2 col-form-label">Área Geografica</label>
                                <div class="col-md-3">
                                    <select id="area" name="area" class="form-control" onchange="cargartabla0()">
                                        <option value="0">Todos</option>
                                        @foreach ($areas as $prov)
                                            <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        {{-- tablaa 0 --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0 mb-0">
                        <h3 class="card-title">Avance de la matricula de gestion educativa local</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="vista0">
                        </div>
                        {{-- <p class="text-muted font-13 m-0 p-0 text-right">
                            Fuente: ESCALE - MINEDU – PADRON WEB, ultima actualizacion del 12/07/2022
                        </p> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- end  row --}}

        {{-- tablaa 1 --}}
        <div class="row">
            <div class="col-xl-12">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0 mb-0">
                        <h3 class="card-title">Avance de la matricula según nivel y modalidad educativa local</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="vista1">
                        </div>
                        {{-- <p class="text-muted font-13 m-0 p-0 text-right">
                            Fuente: ESCALE - MINEDU – PADRON WEB, ultima actualizacion del 12/07/2022
                        </p> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- end  row --}}

    </div>
@endsection

@section('js')
    <!-- flot chart -->
    <script src="{{ asset('/') }}public/assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/highcharts-modules/export-data.js"></script>
    {{-- <script src="{{ asset('/') }}public/assets/libs/highcharts-modules/accessibility.js"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            cargartabla0();
        });

        function cargartabla0() {
            $.ajax({
                url: "{{ route('matriculadetalle.avance.tabla0') }}",
                type: "POST",
                data: $('#form_opciones').serialize(),
                success: function(data) {
                    $('#vista0').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });

            $.ajax({
                url: "{{ route('matriculadetalle.avance.tabla1') }}",
                type: "POST",
                data: $('#form_opciones').serialize(),
                success: function(data) {
                    $('#vista1').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }


        function cargardistritos() {
            $('#distrito').val('0');
            $.ajax({
                url: "{{ url('/') }}/Plaza/Distritos/" + $('#provincia').val(),
                dataType: 'JSON',
                success: function(data) {
                    $("#distrito option").remove();
                    var options = '<option value="0">TODOS</option>';
                    $.each(data.distritos, function(index, value) {
                        options += "<option value='" + value.id + "'>" + value.nombre + "</option>"
                    });
                    $("#distrito").append(options);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }

        function historial() {
            $.ajax({
                url: "{{ route('ind01.plaza.dato') }}",
                type: 'post',
                data: $('#form_opciones').serialize(),
                dataType: 'JSON',
                success: function(data) {
                    console.log(data);
                    graficaPie(data.dato.tt);
                    graficarBar(data.dato.tu);
                    /* TABLAS DIVERSAS */
                    /* ---> */
                    piet = '';
                    conteo = 0;
                    total = 0;
                    data.dato.tt.forEach(element => {
                        total += element.y
                    });
                    data.dato.tt.forEach((val, index) => {
                        por = val.y * 100 / total;
                        piet += '<tr><td align=center>' + val.name + '</td><td align=center>' + val.y +
                            '</td><td align=center>' + por.toFixed(1) + '%</td></tr>';
                        conteo += val.y;
                    });
                    piet += '<tr><td align=center><b>TOTAL</b></td><td align=center><b>' + conteo +
                        '</b></td><td align=center><b>100%</b></td></tr>';
                    $('#con1t').html(piet);
                    /* --> */
                    piet = '';
                    conteo = 0;
                    total = 0;
                    data.dato.tu.forEach(element => {
                        total += element.y
                    });
                    data.dato.tu.forEach((val, index) => {
                        por = val.y * 100 / total;
                        piet += '<tr><td align=left>' + val.name + '</td><td align=center>' + val.y +
                            '</td><td align=center>' + por.toFixed(1) + '%</td></tr>';
                        conteo += val.y;
                    });
                    piet += '<tr><td align=left><b>TOTAL</b></td><td align=center><b>' + conteo +
                        '</b></td><td align=center><b>100%</b></td></tr>';
                    $('#con2t').html(piet);
                    /* --> */
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }

        function graficarBar(datax) {
            Highcharts.chart('con2', {
                chart: {
                    type: 'column',
                },
                title: {
                    text: '',
                },
                xAxis: {
                    type: 'category',
                },
                yAxis: {
                    title: {
                        enabled: false,
                        text: 'Porcentaje',
                    }
                },
                series: [{
                    name: 'UGEL',
                    colorByPoint: true,
                    data: datax,
                    showInLegend: false,
                }],
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}',
                        },
                    }
                },
                credits: false,
            });
        }

        function graficaPie(datos) {
            Highcharts.chart('con1', {
                chart: {
                    type: 'pie',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '<b>{series.name}:</b>{point.y}',
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}: {point.percentage:.2f}%</b>'
                        },
                    }
                },
                series: [{
                    name: 'Cantidad',
                    colorByPoint: true,
                    data: datos,
                }],
                credits: false,

            });
        }
    </script>
@endsection
