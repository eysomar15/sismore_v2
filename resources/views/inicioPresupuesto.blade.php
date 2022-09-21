@extends('layouts.main', ['activePage' => 'usuarios', 'titlePage' => 'aasdasdsad'])
{{-- @extends('layouts.main', ['titlePage' => 'IMPORTAR DATOS - SISTEMA NEXUS']) --}}

@section('css')
    <script src="{{ asset('/') }}public/assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/highcharts/highcharts-more.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/highcharts/solid-gauge.js"></script>

    <script src="{{ asset('/') }}public/assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/highcharts-modules/export-data.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/highcharts-modules/accessibility.js"></script>

    {{-- <script src="https://code.highcharts.com/modules/solid-gauge.js"></script> --}}
@endsection
{{-- <div>
    <div id="container-speed" class="chart-container"></div>
</div> --}}
@section('content')
    <div class="content">
        <div class="container-fluid">
            {{-- <div class="row">
            <div class="col-lg-12">
                <div class="card card-fill bg-primary">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title text-white">Información General</h3>
                    </div>
                </div>
            </div>
        </div> --}}
            <!-- end row -->

            <div class="row">

                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-success rounded-circle mr-2">
                                <i class="ion ion-logo-usd avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold" title="{{ number_format($card1['pim'], 0) }}">
                                        <span data-plugin="counterup">
                                            {{ number_format($card1['pim'] / 1000000, 0) }}
                                        </span> M
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate" style="font-size: 14px">Presupuesto Ucayali</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="">Ejecución
                                <span class="float-right">{{ number_format($card1['eje'], 2) }}%</span>
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{ $card1['eje'] }}"
                                    aria-valuemin="0" aria-valuemax="100" style="width: {{ $card1['eje'] }}%">
                                    <span class="sr-only">{{ number_format($card1['eje'], 2) }}% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN CARD-->

                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-purple rounded-circle mr-2">
                                <i class="ion ion-logo-usd avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"
                                        title="{{ number_format($card2['pim'], 0) }}">
                                        <span data-plugin="counterup">
                                            {{ number_format($card2['pim'] / 1000000, 0) }}
                                        </span> M
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate" style="font-size: 14px">Gobierno Nacional</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="">Ejecución
                                <span class="float-right">{{ number_format($card2['eje'], 2) }}%</span>
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="{{ $card2['eje'] }}"
                                    aria-valuemin="0" aria-valuemax="100" style="width: {{ $card2['eje'] }}%">
                                    <span class="sr-only">{{ $card2['eje'] }}% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN CARD-->

                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-primary rounded-circle mr-2">
                                <i class="ion ion-logo-usd avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"
                                        title="{{ number_format($card3['pim'], 0) }}">
                                        <span data-plugin="counterup">
                                            {{ number_format($card3['pim'] / 1000000, 0) }}
                                        </span> M
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate" style="font-size: 14px">Gobierno Regional</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="">Ejecución
                                <span class="float-right">{{ number_format($card3['eje'], 2) }}%</span>
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="{{ $card3['eje'] }}"
                                    aria-valuemin="0" aria-valuemax="100" style="width: {{ $card3['eje'] }}%">
                                    <span class="sr-only">{{ $card3['eje'] }}% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN CARD-->

                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-danger rounded-circle mr-2">
                                <i class="ion ion-logo-usd avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"
                                        title="{{ number_format($card4['pim'], 0) }}">
                                        <span data-plugin="counterup">
                                            {{ number_format($card4['pim'] / 1000000, 0) }}
                                        </span> M
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate" style="font-size: 14px">Gobiernos Locales</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="">Ejecución
                                <span class="float-right">{{ number_format($card4['eje'], 2) }}%</span>
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="{{ $card4['eje'] }}"
                                    aria-valuemin="0" aria-valuemax="100" style="width: {{ $card4['eje'] }}%">
                                    <span class="sr-only">{{ $card4['eje'] }}% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN CARD-->


            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div id="anal1" style="min-width:400px;height:300px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div id="anal2g" style="min-width:400px;height:300px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}

            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div id="anal2" style="min-width:400px;height:300px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div id="con2" style="min-width:400px;height:300px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}

            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div id="anal3" style="min-width:400px;height:300px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div id="con2" style="min-width:400px;height:300px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}


        </div>
    </div>
@endsection


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
                })
            });

            $.ajax({
                url: "{{ url('/') }}/Home/Presupuesto/gra1/{{ $impG->id }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    console.log(data)
                    gPie('anal1', data.info,
                        '',
                        'Distribución del Presupuesto  de la Región Ucayali', '');
                },
                erro: function(jqXHR, textStatus, errorThrown) {
                    console.log("ERROR GRAFICA 1");
                    console.log(jqXHR);
                },
            });

            $.ajax({
                url: "{{ url('/') }}/Home/Presupuesto/gra1/{{ $impG->id }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    console.log(data)
                    gPie('anal2', data.info,
                        '',
                        'Distribución del Presupuesto en Inversiones', '');
                },
                erro: function(jqXHR, textStatus, errorThrown) {
                    console.log("ERROR GRAFICA 1");
                    console.log(jqXHR);
                },
            });

            $.ajax({
                url: "{{ url('/') }}/Home/Presupuesto/gra1/{{ $impG->id }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    console.log(data)
                    gPie('anal3', data.info,
                        '',
                        'Ingreso Presuuestal de la Region Ucayali', '');
                },
                erro: function(jqXHR, textStatus, errorThrown) {
                    console.log("ERROR GRAFICA 1");
                    console.log(jqXHR);
                },
            });


            $.ajax({
                url: "{{ url('/') }}/Home/Presupuesto/tabla1/{{ $impG->id }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    console.log(data)
                    /* gSimpleColumn('anal1', data.info, '',
                        'Estudiantes Matriculados por Años<br><span class="fuentex">Fuente:SIAGIE'+'</span>', ''); */
                },
                erro: function(jqXHR, textStatus, errorThrown) {
                    console.log("ERROR GRAFICA 1");
                    console.log(jqXHR);
                },
            });
        });
    </script>

    <script type="text/javascript">
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
                            format: '{point.yx} ( {point.percentage:.1f}% )',
                            connectorColor: 'silver'
                        }
                    }
                },
                /* plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            //format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            format: '{point.percentage:.1f}% ({point.y})',
                            connectorColor: 'silver'
                        }
                    }
                }, */
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
@endsection
