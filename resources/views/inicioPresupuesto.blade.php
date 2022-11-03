@section('css')
    <!-- Table datatable css -->
    <link href="{{ asset('/') }}public/assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/') }}public/assets/libs/datatables/buttons.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/') }}public/assets/libs/datatables/fixedHeader.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/') }}public/assets/libs/datatables/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('/') }}public/assets/libs/datatables/scroller.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <style>
        .tablex thead th {
            padding: 4px;
            text-align: center;
        }

        .tablex thead td {
            padding: 4px;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
        }

        .tablex tbody td,
        .tablex tbody th,
        .tablex tfoot td,
        .tablex tfoot th {
            padding: 4px;
        }

        .fuentex {
            font-size: 10px;
            font-weight: bold;
        }

        /* .highcharts-figure,
                                                                                                                            .highcharts-data-table table {
                                                                                                                                min-width: 310px;
                                                                                                                                max-width: 800px;
                                                                                                                                margin: 1em auto;
                                                                                                                            }

                                                                                                                            #anal7 {
                                                                                                                                height: 400px;
                                                                                                                            }

                                                                                                                            .highcharts-data-table table {
                                                                                                                                font-family: Verdana, sans-serif;
                                                                                                                                border-collapse: collapse;
                                                                                                                                border: 1px solid #ebebeb;
                                                                                                                                margin: 10px auto;
                                                                                                                                text-align: center;
                                                                                                                                width: 100%;
                                                                                                                                max-width: 500px;
                                                                                                                            }

                                                                                                                            .highcharts-data-table caption {
                                                                                                                                padding: 1em 0;
                                                                                                                                font-size: 1.2em;
                                                                                                                                color: #555;
                                                                                                                            }

                                                                                                                            .highcharts-data-table th {
                                                                                                                                font-weight: 600;
                                                                                                                                padding: 0.5em;
                                                                                                                            }

                                                                                                                            .highcharts-data-table td,
                                                                                                                            .highcharts-data-table th,
                                                                                                                            .highcharts-data-table caption {
                                                                                                                                padding: 0.5em;
                                                                                                                            }

                                                                                                                            .highcharts-data-table thead tr,
                                                                                                                            .highcharts-data-table tr:nth-child(even) {
                                                                                                                                background: #f8f8f8;
                                                                                                                            }

                                                                                                                            .highcharts-data-table tr:hover {
                                                                                                                                background: #f1f7ff;
                                                                                                                            } */
    </style>
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
                                    <p class="mb-0 mt-1 text-truncate" style="font-size: 14px">PIA {{ $anio }}</p>
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
                                    <p class="mb-0 mt-1 text-truncate" style="font-size: 14px">PIM {{ $anio }}</p>
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
                                    <p class="mb-0 mt-1 text-truncate" style="font-size: 14px">CERTIFICADO
                                        {{ $anio }}</p>
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
                                    <p class="mb-0 mt-1 text-truncate" style="font-size: 14px">DEVENGADO
                                        {{ $anio }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h6 class="">Ejecución
                                <span class="float-right">{{ number_format($card4['eje'], 2) }}%</span>
                            </h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    aria-valuenow="{{ $card4['eje'] }}" aria-valuemin="0" aria-valuemax="100"
                                    style="width: {{ $card4['eje'] }}%">
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
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body p-0">
                            <div id="anal1" style="min-width:100%;height:600px;margin:0 auto;"></div>
                            {{--  style="min-width:400px;height:300px;margin:0 auto;" --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body p-0">
                            <div id="anal2" style="min-width:100%;height:600px;margin:0 auto;"></div>
                            {{--  style="min-width:400px;height:300px;margin:0 auto;" --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}

            <div class="row">
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body p-0">
                            <div id="anal3"></div>
                            {{--  style="min-width:400px;height:300px;margin:0 auto;" --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card card-border card-primary">
                        <div class="card-header border-primary bg-transparent p-0">
                            <h3 class="card-title text-primary "></h3>
                        </div>
                        <div class="card-body p-0">
                            <div id="anal4"></div>
                            {{--  style="min-width:400px;height:300px;margin:0 auto;" --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- end  row --}}

        </div>
    </div>
@endsection


@section('js')
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/mapdata/countries/pe/pe-all.js"></script>
    {{-- highcharts --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    {{-- <script src="https://code.highcharts.com/modules/drilldown.js"></script> --}}
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>



    <!-- third party js -->
    {{-- <script src="{{ asset('/') }}public/assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/datatables/dataTables.bootstrap4.min.js"></script>

    <script src="{{ asset('/') }}public/assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="{{ asset('/') }}public/assets/libs/datatables/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/datatables/buttons.bootstrap4.min.js"></script>

    <script src="{{ asset('/') }}public/assets/libs/jszip/jszip.min.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/pdfmake/vfs_fonts.js"></script>

    <script src="{{ asset('/') }}public/assets/libs/datatables/buttons.html5.min.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/datatables/buttons.print.min.js"></script>

    <script src="{{ asset('/') }}public/assets/libs/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/datatables/dataTables.keyTable.min.js"></script>
    <script src="{{ asset('/') }}public/assets/libs/datatables/dataTables.scroller.min.js"></script>
 --}}




    <script type="text/javascript">
        $(document).ready(function() {
            Highcharts.setOptions({
                colors: Highcharts.map(paleta_colores, function(color) {
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

            /*
             *AJAX PARA LA PRESENTACION DE LA PRIMERA GRAFICA 1
             */
            $.ajax({
                url: "{{ url('/') }}/Home/Presupuesto/gra2/{{ $baseAP->id }}",
                type: "GET",
                dataType: "JSON",
                beforeSend: function() {
                    $('#anal2').html('<span><i class="fa fa-spinner fa-spin"></i></span>');
                },
                success: function(data) {
                    console.log(data)
                    maps01('anal1',
                        data.data,
                        '',
                        'Rankin de la ejecución de gastos por gobiernos regionales');
                    gbar('anal2', [],
                        data.info,
                        '',
                        'Porcentaje de ejecución de gastos por gobiernos regionales',
                    );
                },
                erro: function(jqXHR, textStatus, errorThrown) {
                    console.log("ERROR GRAFICA 1");
                    console.log(jqXHR);
                },
            });



        });
    </script>

    <script type="text/javascript">
        function gColumnDrilldown(div, data1, data2, titulo, subtitulo, tituloserie) {
            Highcharts.chart(div, {
                chart: {
                    type: 'column',
                },
                title: {
                    enabled: false,
                    text: titulo,
                    //align:'left',
                },
                subtitle: {
                    //align:'left',
                    text: subtitulo,
                },
                accessibility: {
                    announceNewData: {
                        enabled: true,
                    }
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
                legend: {
                    enabled: false,
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}%',
                        },
                    },
                    drilldown: {
                        series: {
                            //borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y}',
                            },
                            format: '{point.y}',
                        },
                    }
                    /* series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            //format: '{point.y:,.0f}',
                            //format: '{point.y:.1f}%',
                            formatter: function() {
                                if (this.y > 1000000) {
                                    return Highcharts.numberFormat(this.y / 1000000, 0) + "M";
                                } else if (this.y > 1000) {
                                    return Highcharts.numberFormat(this.y / 1000, 0) + "K";
                                } else {
                                    return this.y;
                                }
                            },
                        },
                    } */
                },
                tooltip: {
                    pointFormat: '<span style="color:{point.color}">\u25CF</span> Hay: <b>{point.y}%</b><br/>',
                    shared: true,
                    /* headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>' */
                },
                series: [{
                    showInLegend: tituloserie != '',
                    name: tituloserie,
                    label: {
                        enabled: false
                    },
                    colorByPoint: false,
                    data: data1,

                }],
                drilldown: {
                    breadcrumbs: {
                        position: {
                            align: 'right',
                        }
                    },
                    series: data2,
                },
                credits: false,
            });
        }

        function gColumnDrilldown2(div, categoria, serie1, data2, titulo, subtitulo, tituloserie) {
            Highcharts.chart(div, {
                chart: {
                    type: 'column',
                },
                title: {
                    enabled: false,
                    text: titulo,
                    //align:'left',
                },
                subtitle: {
                    //align:'left',
                    text: subtitulo,
                },
                accessibility: {
                    announceNewData: {
                        enabled: true,
                    }
                },
                xAxis: {
                    //type: 'category',
                    categories: categoria
                },
                yAxis: {
                    /* max: 100, */
                    title: {
                        enabled: false,
                        text: 'Porcentaje',
                    }
                },
                legend: {
                    enabled: false,
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}%',
                        },
                    },
                    drilldown: {
                        series: {
                            //borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y}',
                            },
                            format: '{point.y}',
                        },
                    }
                    /* series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            //format: '{point.y:,.0f}',
                            //format: '{point.y:.1f}%',
                            formatter: function() {
                                if (this.y > 1000000) {
                                    return Highcharts.numberFormat(this.y / 1000000, 0) + "M";
                                } else if (this.y > 1000) {
                                    return Highcharts.numberFormat(this.y / 1000, 0) + "K";
                                } else {
                                    return this.y;
                                }
                            },
                        },
                    } */
                },
                tooltip: {
                    pointFormat: '<span style="color:{point.color}">\u25CF</span> Hay: <b>{point.y}%</b><br/>',
                    shared: true,
                    /* headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>' */
                },
                series: serie1
                    /* [{
                                        showInLegend: tituloserie != '',
                                        name: tituloserie,
                                        label: {
                                            enabled: false
                                        },
                                        colorByPoint: false,
                                        data: data1,

                                    }] */
                    ,
                drilldown: {
                    breadcrumbs: {
                        position: {
                            align: 'right',
                        }
                    },
                    series: data2,
                },
                credits: false,
            });
        }

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
                    colorByPoint: false,
                    data: datax,

                }],
                tooltip: {
                    pointFormat: '<span style="color:{point.color}">\u25CF</span> Hay: <b>{point.y}%</b><br/>',
                    shared: true
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}%',
                        },
                        point: {
                            cursor: 'pointer',
                            events: {
                                click: function() {
                                    //alert('Category: ' + this.category + ', value: ' + this.y);
                                    alert(this.options);
                                    //location.href = 'https://en.wikipedia.org/wiki/' +this.options.key;
                                    //alert('hola ronald');
                                },
                            },
                        },


                    }
                    /* series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            //format: '{point.y:,.0f}',
                            //format: '{point.y:.1f}%',
                            formatter: function() {
                                if (this.y > 1000000) {
                                    return Highcharts.numberFormat(this.y / 1000000, 0) + "M";
                                } else if (this.y > 1000) {
                                    return Highcharts.numberFormat(this.y / 1000, 0) + "K";
                                } else {
                                    return this.y;
                                }
                            },
                        },
                    } */
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
                    pointFormat: '{series.name}: <b>{point.y:,.0f} ({point.percentage:.1f}%)</b>',
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
                            format: '{point.y:,.0f} ({point.percentage:.1f}%)',
                            //format: '{point.percentage:.1f}%',
                            connectorColor: 'silver',
                            style: {
                                fontWeight: 'normal',
                            }
                        }
                    },
                    series: {
                        //allowPointSelect: true
                        style: {
                            fontSize: '10pt'
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
                legend: {
                    //align: 'center', //right//left//center
                    //verticalAlign: 'bottom', //top//middle//bottom
                    //layout: 'horizontal', //horizontal//vertical//proximate
                    itemStyle: {
                        "color": "#333333",
                        "cursor": "pointer",
                        "fontSize": "10px",
                        "fontWeight": "normal",
                        "textOverflow": "ellipsis"
                    },
                },
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

        function gAnidadaColumn(div, categoria, series, titulo, subtitulo) {
            Highcharts.chart(div, {
                chart: {
                    type: 'column',
                },
                title: {
                    text: titulo, //'Browser market shares in January, 2018'
                },
                subtitle: {
                    text: subtitulo,
                },
                xAxis: {
                    categories: categoria
                },
                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        enabled: false,
                        text: 'Porcentaje',
                    }
                },
                series: series,
                plotOptions: {
                    columns: {
                        stacking: 'normal'
                    },
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            //format: '{point.y:,.0f}',
                            //format: '{point.y:.1f}%',
                            formatter: function() {
                                if (this.y > 1000000) {
                                    return Highcharts.numberFormat(this.y / 1000000, 0) + "M";
                                } else if (this.y > 1000) {
                                    return Highcharts.numberFormat(this.y / 1000, 0) + "K";
                                } else {
                                    return this.y;
                                }
                            },
                            style: {
                                fontWeight: 'normal',
                            }
                        },
                        /* label:{
                            style:{
                                fontWeight:'normal',
                            }
                        } */
                    }
                },
                legend: {
                    //align: 'center', //right//left//center
                    //verticalAlign: 'bottom', //top//middle//bottom
                    //layout: 'horizontal', //horizontal//vertical//proximate
                    itemStyle: {
                        "color": "#333333",
                        "cursor": "pointer",
                        "fontSize": "10px",
                        "fontWeight": "normal",
                        "textOverflow": "ellipsis"
                    },
                },
                credits: false,
            });
        }

        function barra(div) {
            Highcharts.chart(div, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Major trophies for some English teams',
                    align: 'left'
                },
                xAxis: {
                    categories: ['Arsenal', 'Chelsea', 'Liverpool', 'Manchester United']
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Count trophies'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: ( // theme
                                Highcharts.defaultOptions.title.style &&
                                Highcharts.defaultOptions.title.style.color
                            ) || 'gray',
                            textOutline: 'none'
                        }
                    }
                },
                legend: {
                    align: 'left',
                    x: 70,
                    verticalAlign: 'top',
                    y: 70,
                    floating: true,
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    headerFormat: '<b>{point.x}</b><br/>',
                    pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                series: [{
                    name: 'BPL',
                    data: [3, 5, 1, 13]
                }, {
                    name: 'FA Cup',
                    data: [14, 8, 8, 12]
                }, {
                    name: 'CL',
                    data: [0, 2, 6, 3]
                }]
            });
        }

        function glineal(div, categoria, series, titulo, subtitulo) {
            Highcharts.chart(div, {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: titulo, //'Browser market shares in January, 2018'
                },
                subtitle: {
                    text: subtitulo,
                },
                xAxis: {
                    categories: categoria
                    /* accessibility: {
                        rangeDescription: 'Range: 2015 to 2025'
                    } */
                },
                yAxis: {
                    title: {
                        enabled: false,
                        text: 'Number of Employees'
                    }
                    /* allowDecimals: false,
                    min: 0,
                    title: {
                        enabled: false,
                        text: 'Porcentaje',
                    } */
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },

                plotOptions: {
                    /* series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            //format: '{point.y:,.0f}',
                            //format: '{point.y:.1f}%',
                            formatter: function() {
                                if (this.y > 1000000) {
                                    return Highcharts.numberFormat(this.y / 1000000, 0) + "M";
                                } else if (this.y > 1000) {
                                    return Highcharts.numberFormat(this.y / 1000, 0) + "K";
                                } else {
                                    return this.y;
                                }
                            },
                        },
                    } */
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            //format: '{point.y:,.0f}',
                            formatter: function() {
                                if (this.y > 1000000) {
                                    return Highcharts.numberFormat(this.y / 1000000, 0) + "M";
                                } else if (this.y > 1000) {
                                    return Highcharts.numberFormat(this.y / 1000, 0) + "K";
                                } else {
                                    return this.y;
                                }
                            },
                            style: {
                                fontWeight: 'normal',
                            }
                        },
                        /*  point: {
                             cursor: 'pointer',
                             events: {
                                 click: function() {
                                     //alert('Category: ' + this.category + ', value: ' + this.y);
                                     alert(this.options);
                                     //location.href = 'https://en.wikipedia.org/wiki/' +this.options.key;
                                     //alert('hola ronald');
                                 },
                             },
                         }, */


                    }
                    /* spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#666666',
                            lineWidth: 1
                        }
                    } */
                },
                /*  plotOptions: {
                     series: {
                         label: {
                             connectorAllowed: false
                         },
                         pointStart: 2010
                     }
                 }, */

                series: series,
                legend: {
                    align: 'center', //right//left//center
                    verticalAlign: 'bottom', //top//middle//bottom
                    layout: 'horizontal', //horizontal//vertical//proximate
                    itemStyle: {
                        "color": "#333333",
                        "cursor": "pointer",
                        "fontSize": "10px",
                        "fontWeight": "normal", //bold
                        "textOverflow": "ellipsis"
                    },
                },
                /* responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'vertical', //horizontal
                                align: 'right', //center//right//left
                                verticalAlign: 'top'//bottom//middle
                            }
                        }
                    }]
                }, */
                credits: false,

            });
        }

        function gbar(div, categoria, series, titulo, subtitulo) {
            Highcharts.chart(div, {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: titulo, // 'Historic World Population by Region'
                },
                subtitle: {
                    text: subtitulo,
                    /*  'Source: <a ' +
                                            'href="https://en.wikipedia.org/wiki/List_of_continents_and_continental_subregions_by_population"' +
                                            'target="_blank">Wikipedia.org</a>' */
                },
                xAxis: {
                    //categories:categoria,// ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
                    type: "category",
                    title: {
                        text:'',// null
                    },
                    enabled: false,
                },
                yAxis: {
                    min: 0,
                    title: {
                        text:'',// 'Population (millions)',
                        align: 'high'
                    },
                    /* labels: {
                        overflow: 'justify'
                    } */
                },
                tooltip: {
                    valueSuffix: ' millions'
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    enabled: false, //
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -40,
                    y: 80,
                    floating: true,
                    borderWidth: 1,
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                    shadow: true
                },

                //series: series,
                /*  [{
                                    name: 'Year 1990',
                                    data: [631, 727, 3202, 721, 26]
                                }, {
                                    name: 'Year 2000',
                                    data: [814, 841, 3714, 726, 31]
                                }, {
                                    name: 'Year 2010',
                                    data: [1044, 944, 4170, 735, 40]
                                }, {
                                    name: 'Year 2018',
                                    data: [1276, 1007, 4561, 746, 42]
                                }] */
                /* showInLegend: tituloserie != '',
                        name: tituloserie,
                        label: {
                            enabled: false
                        },
                        colorByPoint: false, */
                series: [{

                    name: 'departamentos',
                    showInLegend: false,
                    label: {
                        enabled: false
                    },
                    data: series,
                    /* [{
                                                name: "Chrome",
                                                y: 63.06,
                                            },
                                            {
                                                name: "Safari",
                                                y: 19.84,
                                            },
                                            {
                                                name: "Firefox",
                                                y: 4.18,
                                            },
                                            {
                                                name: "Edge",
                                                y: 4.12,
                                            },
                                            {
                                                name: "Opera",
                                                y: 2.33,
                                            },
                                            {
                                                name: "Internet Explorer",
                                                y: 0.45,
                                            },
                                            {
                                                name: "Other",
                                                y: 1.582,
                                            }
                                        ] */
                }],
                credits: {
                    enabled: false
                },
            });
        }
    </script>

    <script>
        function maps01(div, data, titulo, subtitulo) {
            Highcharts.mapChart(div, {
                chart: {
                    map: 'countries/pe/pe-all'
                },

                title: {
                    text: titulo, //'Reportes de Mapa'
                },

                subtitle: {
                    text: subtitulo, //'Un descripción de reportes'
                },

                mapNavigation: {
                    enabled: true,
                    buttonOptions: {
                        verticalAlign: 'top'
                    }
                },

                colorAxis: {
                    min: 0
                },

                series: [{
                    data: data,
                    name: 'Puesto', //Población
                    states: {
                        hover: {
                            color: '#BADA55'
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        format: '{point.value}°'
                    }
                }],
                credits: {
                    enabled: false
                },
            });
        }
        /* var data = [
            ['pe-ic', 10],
            ['pe-cs', 11],
            ['pe-uc', 12],
            ['pe-md', 13],
            ['pe-sm', 14],
            ['pe-am', 15],
            ['pe-lo', 16],
            ['pe-ay', 17],
            ['pe-145', 18],
            ['pe-hv', 19],
            ['pe-ju', 20],
            ['pe-lr', 21],
            ['pe-lb', 22],
            ['pe-tu', 23],
            ['pe-ap', 24],
            ['pe-ar', 25],
            ['pe-cl', 26],
            ['pe-mq', 27],
            ['pe-ta', 28],
            ['pe-an', 29],
            ['pe-cj', 30],
            ['pe-hc', 31],
            ['pe-3341', 32],
            ['pe-ll', 33],
            ['pe-pa', 34],
            ['pe-pi', 35]
        ];
        // Create the chart
        Highcharts.mapChart('anal1', {
            chart: {
                map: 'countries/pe/pe-all'
            },
            title: {
                text: 'Reportes de Mapa'
            },
            subtitle: {
                text: 'Un descripción de reportes'
            },
            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'top'
                }
            },
            colorAxis: {
                min: 0
            },
            series: [{
                data: data,
                name: 'Población',
                states: {
                    hover: {
                        color: '#BADA55'
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }]
        }); */
    </script>

    {{--  --}}
    {{-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> --}}
    {{-- <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/maps/modules/map.js"></script>
    <script src="https://code.highcharts.com/maps/modules/data.js"></script>
    <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
    <script src="https://code.highcharts.com/maps/modules/accessibility.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> --}}
@endsection
