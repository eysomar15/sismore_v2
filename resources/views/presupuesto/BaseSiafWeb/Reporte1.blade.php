@extends('layouts.main', ['activePage' => 'usuarios', 'titlePage' => ''])

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <link href="{{ asset('/') }}public/assets/jquery-ui/jquery-ui.css" rel="stylesheet" />

    <style>
        .tablex thead th {
            padding: 6px;
            text-align: center;
        }

        .tablex thead td {
            padding: 6px;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
        }

        .tablex tbody td,
        .tablex tbody th,
        .tablex tfoot td,
        .tablex tfoot th {
            padding: 5px;
        }

        .ui-autocomplete {
            z-index: 215000000 !important;
        }
    </style>
@endsection

@section('content')
    <div class="content">
        {{-- <form class="">@csrf </form> --}}

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-border">
                    <div class="card-header bg-transparent pb-0">
                        <div class="card-widgets">
                            <button type="button" class="btn btn-danger btn-xs" onclick="location.reload()"><i
                                    class="fa fa-redo"></i> Actualizar</button>
                        </div>
                        <h3 class="card-title">FILTRO</h3>
                    </div>
                    <div class="card-body pt-2 pb-0">
                        <form class="form-horizontal" id="form-filtro">
                            @csrf
                            <div class="form">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class=" col-form-label">Año</label>
                                        <div class="">
                                            <select class="form-control" name="fanio" id="fanio"
                                                onchange="cargarcuadros();">
                                                @foreach ($ano as $item)
                                                    <option value="{{ $item->anio }}">{{ $item->anio }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">Producto/Proyecto</label>
                                        <div class="">
                                            <select class="form-control" name="farticulo" id="farticulo"
                                                onchange="cargarcuadros();">
                                                <option value="0">TODOS</option>
                                                @foreach ($articulo as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">Función</label>
                                        <div class="">
                                            <select class="form-control" name="ffuncion" id="ffuncion"
                                                onchange="cargarcuadros();">
                                                <option value="0">TODOS</option>
                                                @foreach ($funcion as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="col-form-label">Categoría de Gasto</label>
                                        <div class="">
                                            <select class="form-control" name="fcategoria" id="fcategoria"
                                                onchange="cargarcuadros();">
                                                <option value="0">TODOS</option>
                                                @foreach ($categoria as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- card-body -->
                </div>
                <!-- card -->
            </div>
            <!-- col -->
        </div>
        <!-- End row -->

        <div class="row">
            <div class="col-xl-12 principal">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0 mb-0">
                        <h3 class="card-title">Ejecución de Gastos por Unidades Ejecutoras del Pliego</h3>
                    </div>
                    <div class="card-body pb-0 pt-0">
                        <div class="table-responsive" id="vista1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end  row --}}

        <div class="row">
            <div class="col-sm-12">
                <div class="card card-border">
                    <div class="card-header bg-transparent pb-0">
                        <div class="card-widgets">
                            <button type="button" class="btn btn-danger btn-xs" onclick="location.reload()"><i
                                    class="fa fa-redo"></i> Actualizar</button>
                        </div>
                        <h3 class="card-title">FILTRO</h3>
                    </div>
                    <div class="card-body pt-2 pb-0">
                        <form class="form-horizontal" id="form-filtro">
                            @csrf
                            <div class="form">
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class=" col-form-label">Año</label>
                                        <div class="">
                                            <select class="form-control" name="ganio" id="ganio"
                                                onchange="cargarcuadros2();">
                                                @foreach ($ano as $item)
                                                    <option value="{{ $item->anio }}">{{ $item->anio }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">Producto/Proyecto</label>
                                        <div class="">
                                            <select class="form-control" name="garticulo" id="garticulo"
                                                onchange="cargarcuadros2();">
                                                <option value="0">TODOS</option>
                                                @foreach ($articulo as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-form-label">Unidad Ejecutora</label>
                                        <div class="">
                                            <select class="form-control" name="gue" id="gue"
                                                onchange="cargarcuadros2();">
                                                <option value="0">TODOS</option>
                                                @foreach ($ue as $item)
                                                    <option value="{{ $item->id }}">{{ $item->unidad_ejecutora }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="col-form-label">Categoría de Gasto</label>
                                        <div class="">
                                            <select class="form-control" name="gcategoria" id="gcategoria"
                                                onchange="cargarcuadros2();">
                                                <option value="0">TODOS</option>
                                                @foreach ($categoria as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- card-body -->
                </div>
                <!-- card -->
            </div>
            <!-- col -->
        </div>
        <!-- End row -->


        <div class="row">
            <div class="col-xl-12 principal">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0 mb-0">
                        <h3 class="card-title">Ejecución de Gastos según Fuente de Financiamiento</h3>
                    </div>
                    <div class="card-body pb-0 pt-0">
                        <div class="table-responsive" id="vista2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end  row --}}


        <div class="row">
            <div class="col-xl-12 principal">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0 mb-0">
                        <h3 class="card-title">Ejecución de Gastos según Genérica </h3>
                    </div>
                    <div class="card-body pb-0 pt-0">
                        <div class="table-responsive" id="vista3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end  row --}}


        <div class="row">
            <div class="col-xl-12 principal">
                <div class="card card-border">
                    <div class="card-header border-primary bg-transparent pb-0 mb-0">
                        <h3 class="card-title">Ejecución del Gasto según Función</h3>
                    </div>
                    <div class="card-body pb-0 pt-0">
                        <div class="table-responsive" id="vista4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end  row --}}
    </div>
@endsection

@section('js')
    <script src="{{ asset('/') }}public/assets/jquery-ui/jquery-ui.js"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}

    <!-- third party js -->
    <script src="{{ asset('/') }}public/assets/libs/datatables/jquery.dataTables.min.js"></script>
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

    {{-- highcharts --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        var save_method = '';
        var table_principal;

        $(document).ready(function() {
            $("input").change(function() {
                $(this).parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("textarea").change(function() {
                $(this).parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("select").change(function() {
                $(this).parent().removeClass('has-error');
                $(this).next().empty();
            });

            cargarcuadros();
            cargarcuadros2();
        });

        function cargarcuadros() {
            /*
             *AJAX PARA LA PRESENTACION DE LA PRIMERA tabla 1
             */
            $.ajax({
                url: "{{ route('basesiafweb.tabla01') }}",
                data: {
                    'anio': $('#fanio').val(),
                    'articulo': $('#farticulo').val(),
                    'funcion': $('#ffuncion').val(),
                    'categoria': $('#fcategoria').val(),
                },
                type: "GET",
                beforeSend: function() {
                    $('#vista1').html('<span><i class="fa fa-spinner fa-spin"></i></span>');
                },
                success: function(data) {
                    $('#vista1').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    $('#vista1').html('Sin Informacion Disponible');
                },
            });

        }

        function cargarcuadros2() {


            /*
             *AJAX PARA LA PRESENTACION DE LA PRIMERA tabla 2
             */
            $.ajax({
                url: "{{ route('basesiafweb.tabla02') }}",
                data: {
                    'anio': $('#ganio').val(),
                    'articulo': $('#garticulo').val(),
                    'ue': $('#gue').val(),
                    'categoria': $('#gcategoria').val(),
                },
                type: "GET",
                beforeSend: function() {
                    $('#vista2').html('<span><i class="fa fa-spinner fa-spin"></i></span>');
                },
                success: function(data) {
                    $('#vista2').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    $('#vista2').html('Sin Informacion Disponible');
                },
            });


            /*
             *AJAX PARA LA PRESENTACION DE LA PRIMERA tabla 2
             */
             $.ajax({
                url: "{{ route('basesiafweb.tabla03') }}",
                data: {
                    'anio': $('#ganio').val(),
                    'articulo': $('#garticulo').val(),
                    'ue': $('#gue').val(),
                    'categoria': $('#gcategoria').val(),
                },
                type: "GET",
                beforeSend: function() {
                    $('#vista3').html('<span><i class="fa fa-spinner fa-spin"></i></span>');
                },
                success: function(data) {
                    $('#vista3').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    $('#vista3').html('Sin Informacion Disponible');
                },
            });


            /*
             *AJAX PARA LA PRESENTACION DE LA PRIMERA tabla 2
             */
             $.ajax({
                url: "{{ route('basesiafweb.tabla04') }}",
                data: {
                    'anio': $('#ganio').val(),
                    'articulo': $('#garticulo').val(),
                    'ue': $('#gue').val(),
                    'categoria': $('#gcategoria').val(),
                },
                type: "GET",
                beforeSend: function() {
                    $('#vista4').html('<span><i class="fa fa-spinner fa-spin"></i></span>');
                },
                success: function(data) {
                    $('#vista4').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    $('#vista4').html('Sin Informacion Disponible');
                },
            });
        }

        function cargarue() {
            $.ajax({
                url: "{{ route('basegastos.cargarue') }}",
                data: {
                    //'gobierno': $('#fgobierno').val(),
                    'sector': $('#fsector').val(),
                },
                type: 'get',
                success: function(data) {
                    $('#fue option ').remove();
                    var opt = '<option value="0">TODOS</option>';
                    $.each(data.ues, function(index, value) {
                        opt += '<option value="' + value.id + '">' + value.unidad_ejecutora +
                            '</option>';
                    });
                    $('#fue').append(opt);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }

        function cargarsector() {
            $.ajax({
                url: "{{ route('basegastos.cargarsector') }}",
                data: {
                    'gobierno': $('#fgobierno').val(),
                },
                type: 'get',
                success: function(data) {
                    console.log(data)
                    $('#fsector option ').remove();
                    var opt = '<option value="0">TODOS</option>';
                    $.each(data.sectors, function(index, value) {
                        opt += '<option value="' + value.id + '">' + value.nombre +
                            '</option>';
                    });
                    $('#fsector').append(opt);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
            });
        }
    </script>
    <script>
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
                },
                yAxis: {
                    title: {
                        enabled: false,
                        text: 'Number of Employees'
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },

                plotOptions: {
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
                    }
                },
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
                credits: false,

            });
        }
    </script>
@endsection