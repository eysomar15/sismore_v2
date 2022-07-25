{{-- @extends('layouts.main',['activePage'=>'usuarios','titlePage'=>'']) --}}


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection
<div>

    <div id="container-speed" class="chart-container"></div>

</div>

<div class="content">
    <div class="container-fluid">
        @if ($importacion_id)
            <div class="row">
                @php
                    $color = ['info', 'purple', 'success', 'primary', 'pink', 'dark', 'warning', 'secondary'];
                    $img = [' mdi mdi-home-group', ' mdi mdi-water-outline', ' mdi mdi-water', ' mdi mdi-spray-bottle'];
                @endphp
                @foreach ($data as $pos => $dato)
                    <div class="col-md-6 col-xl-3">
                        <div class="card-box">
                            <div class="media">
                                <div class="avatar-md bg-{{ $color[$pos] }} rounded-circle mr-2">
                                    <i class="{{ $img[$pos] }} avatar-title font-26 text-white"></i>
                                    {{-- <i class="ion-logo-usd avatar-title font-26 text-white"></i> --}}
                                </div>
                                <div class="media-body align-self-center">
                                    <div class="text-right">
                                        <h4 class="font-20 my-0 font-weight-bold"><span
                                                data-plugin="counterup">{{ number_format($dato['y']) }}</span>
                                        </h4>
                                        <p class="mb-0 mt-1 text-truncate">{{ $dato['name'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <!--span class="float-right">60%</span-->
                            <!-- <div class="mt-4">
                            <h6 class="text-uppercase">{{ $dato['name'] }}
                                
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-{{ $color[$pos] }}" role="progressbar" aria-valuenow="60"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">60% Complete</span>
                                </div>
                            </div>
                        </div> -->
                        </div>
                        <!-- end card-box-->
                    </div>
                @endforeach

                {{-- @foreach ($sistemas as $pos => $sis)
                <div class="col-md-6 col-xl-3">
                    <div class="card-box">
                        <div class="media">
                            <div class="avatar-md bg-{{ $color[$pos] }} rounded-circle mr-2">
                                <i class="{{ $sis->icono }} avatar-title font-26 text-white"></i>
                                <i class="ion-logo-usd avatar-title font-26 text-white"></i>
                            </div>
                            <div class="media-body align-self-center">
                                <div class="text-right">
                                    <h4 class="font-20 my-0 font-weight-bold"><span
                                            data-plugin="counterup">{{ $sis->nrousuario }}</span>
                                    </h4>
                                    <p class="mb-0 mt-1 text-truncate">Accesos de Usuario</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="text-uppercase">Sistema {{ $sis->nombre }}
                                <!--span class="float-right">60%</span-->
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-{{ $color[$pos] }}" role="progressbar" aria-valuenow="60"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">60% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card-box-->
                </div>
            @endforeach --}}
            </div>
            <!-- end row -->
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
                @foreach ($data2 as $pos => $dato)
                    <div class="col-md-6 col-xl-3">
                        <div class="card-box">
                            <div class="media">
                                <div class="avatar-md bg-{{ $color[$pos] }} rounded-circle mr-2">
                                    <i class="{{ $img[0] }} avatar-title font-26 text-white"></i>
                                    {{-- <i class="ion-logo-usd avatar-title font-26 text-white"></i> --}}
                                </div>
                                <div class="media-body align-self-center">
                                    <div class="text-right">
                                        <h4 class="font-20 my-0 font-weight-bold"><span
                                                data-plugin="counterup">{{ number_format($dato['y']) }}</span>
                                        </h4>
                                        <p class="mb-0 mt-1 text-truncate">{{ $dato['name'] }}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="mt-4">
                            <h6 class="text-uppercase">{{ $dato['name'] }}
                                <!--span class="float-right">60%</span-->
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-{{ $color[$pos] }}" role="progressbar" aria-valuenow="60"
                                    aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">60% Complete</span>
                                </div>
                            </div>
                        </div> --}}
                        </div>
                        <!-- end card-box-->
                    </div>
                @endforeach
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
                            <div id="anal2" style="min-width:400px;height:300px;margin:0 auto;"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}

            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-body">
                            <div id="con1" style="min-width:400px;height:300px;margin:0 auto;"></div>
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
                <div class="col-xl-12">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent pb-0">
                            <h3 class="card-title text-primary"></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="table-responsive">
                                        <table id="datatable1" class="table table-striped table-bordered"
                                            style="width:100%;font-size: 12px">
                                            <thead class="cabecera-dataTable">
                                                <tr bgcolor="#317eeb">
                                                    <th style="color:white">#</th>
                                                    <th style="color:white">DISTRITO</th>
                                                    <th style="color:white">CENTRO POBLADO</th>
                                                    <th style="color:white">POBLACION</th>
                                                    <th style="color:white">SISTEMA DE AGUA</th>
                                                    <th style="color:white">SISTEMA DE CLORACION</th>
                                                    <th style="color:white">DISPOSICION DE EXCRETAS</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End row -->
        @else
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-fill bg-danger">
                        <div class="card-header bg-transparent">
                            <h3 class="card-title text-white">NO HAY IMPORTACION SUBIDA HASTA EL MOMENTO</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        @endif

    </div>
</div>
@section('js')
    <script type="text/javascript">
        var table_principal = '';
        $(document).ready(function() {
            //prueba();
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
            @if ($importacion_id)
                graficar('con1', <?= $grafica[0] ?>, '', 'TOTAL DE CENTRO POBLADOS', '');
                graficar2('con2', <?= $grafica[1] ?>, '', 'TOTAL DE CENTRO POBLADOS CON SERVICIO DE AGUA', '');
                //graficaPie1('anal1', <?= $grafica2[1] ?>, '', 'CENTROS POBLADOS CON SISTEMA DE AGUA', '');
                graficaxxx('anal1', <?= $grafica2[0] ?>, '', 'CENTROS POBLADOS CON SISTEMA DE AGUA', '');
                graficaxxx('anal2', <?= $grafica2[1] ?>, '', 'CENTROS POBLADOS CON SISTEMA DE DISPOSICION DE EXCRETAS',
                '');
                cargardatatable1();
            @endif


        });

        function prueba() {
            $.ajax({
                url: "{{ route('centropobladodatass.listarDT') }}",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error("El registro no se pudo crear verifique las validaciones.", 'Mensaje');
                }
            });
        };

        function cargardatatable1() {
            table_principal = $('#datatable1').DataTable({
                "ajax": "{{ route('centropobladodatass.listarDT') }}",
                "columns": [{
                        data: 'distrito'
                    },
                    {
                        data: 'distrito'
                    },
                    {
                        data: 'centropoblado'
                    },
                    {
                        data: 'total_poblacion'
                    },
                    {
                        data: 'sistema_agua'
                    },
                    {
                        data: 'sistema_cloracion'
                    },
                    {
                        data: 'sistema_disposicion_excretas'
                    },
                ],
                "responsive": false,
                "autoWidth": true,
                "order": false,
                "destroy": true,
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                /* "order": [[ 1, 'asc' ]] */
                "language": table_language,
            });
            table_principal.on('order.dt search.dt', function() {
                table_principal.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        }

        function graficar(div, datax, titulo, subtitulo, tituloserie) {
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
                    //headerFormat: '<span style="font-size: 10px">{point.key}</span><br/>',
                    pointFormat: '<span style="color:{point.color}">\u25CF</span> Hay: <b>{point.y}</b><br/>',
                    //pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.conteo}</b><br/>',
                    shared: true
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            /* format: '{point.y:.1f}%', */
                        },
                    }
                },
                credits: false,
            });
        }

        function graficar2(div, datax, titulo, subtitulo, tituloserie) {
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
                    //headerFormat: '<span style="font-size: 10px">{point.key}</span><br/>',
                    pointFormat: '<span style="color:{point.color}">\u25CF</span> Hay: <b>{point.conteo}</b><br/>',
                    //pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.conteo}</b><br/>',
                    shared: true
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}%',
                        },
                    }
                },
                credits: false,
            });
        }

        function graficaPie1(div, datos, titulo, subtitulo, tituloserie) {
            Highcharts.chart(div, {
                chart: {
                    type: 'pie',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                },
                title: {
                    enabled: false,
                    text: titulo,
                },
                subtitle: {
                    text: subtitulo,
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
                    showInLegend: tituloserie != '',
                    name: tituloserie,
                    colorByPoint: true,
                    data: datos,
                }],
                credits: false,

            });
        }

        function graficaxxx(div, datos, titulo, subtitulo, tituloserie) {

            // Build the chart
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
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            connectorColor: 'silver'
                        }
                    }
                },
                series: [{
                    name: 'Share',
                    data: datos,
                    /* [{
                                                name: 'Chrome',
                                                y: 61.41
                                            },
                                            {
                                                name: 'Internet Explorer',
                                                y: 11.84
                                            },
                                            {
                                                name: 'Firefox',
                                                y: 10.85
                                            },
                                            {
                                                name: 'Edge',
                                                y: 4.67
                                            },
                                            {
                                                name: 'Safari',
                                                y: 4.18
                                            },
                                            {
                                                name: 'Other',
                                                y: 7.05
                                            }
                                        ]*/
                }],
                credits: false,
            });
        }
    </script>

    <script src="{{ asset('/') }}public/assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/highcharts/highcharts-more.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/highcharts/solid-gauge.js"></script>

    <script src="{{ asset('/') }}public/assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/highcharts-modules/export-data.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/highcharts-modules/accessibility.js"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
@endsection
