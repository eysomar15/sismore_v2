@extends('layouts.main', ['activePage' => 'usuarios', 'titlePage' => 'Padron Red Educativa Rural'])

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
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
        <form class="">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-border">
                        <div class="card-header bg-transparent pb-0">
                            <div class="card-widgets">
                                <button type="button" class="btn btn-danger btn-xs" onclick="location.reload()"><i
                                        class="fa fa-redo"></i> Actualizar</button>
                                <button type="button" class="btn btn-primary btn-xs" onclick="add()"><i
                                        class="fa fa-plus"></i>
                                    Asignar</button>
                            </div>
                            <h3 class="card-title">Institución Educativas </h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tbprincipal" class="table table-striped table-bordered tablex"
                                    style="font-size: 12px">
                                    <thead class="cabecera-dataTable">
                                        <tr class="bg-primary text-white">
                                            <th>Nº</th>
                                            <th>Ugel</th>
                                            <th>Cod.Modular</th>
                                            <th>Institución Educativa</th>
                                            <th>Nivel</th>
                                            <th>Red Educativa Rural</th>
                                            <th>Tipo Transporte</th>
                                            <th>Aciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div> <!-- End row -->
        </form>
    </div>

    <!-- Bootstrap modal -->
    <div id="modal_form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form" class="form-horizontal" autocomplete="off">
                        @csrf
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="rer_id"name="rer_id" value="">
                        <input type="hidden" id="iiee_id"name="iiee_id" value="">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Red Educativa <span class="required">*</span></label>
                                        <input type="text" id="rer" name="rer" class="form-control"
                                            placeholder="Buscar Red Educativa">
                                        <span class="help-block"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Institución Educativa <span class="required">*</span></label>
                                        <input type="text" id="iiee" name="iiee" class="form-control"
                                            placeholder="Buscar Institución Educativa">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Total Estudiantes<span class="required">*</span></label>
                                        <input id="estudiantes" name="estudiantes" class="form-control" type="number">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Total Docentes<span class="required">*</span></label>
                                        <input id="docentes" name="docentes" class="form-control" type="number">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Total Personal Administrativos<span class="required">*</span></label>
                                        <input id="administrativos" name="administrativos" class="form-control"
                                            type="number">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Tipo Transporte<span class="required">*</span></label>
                                        <input id="transporte" name="transporte" class="form-control" type="text"
                                            maxlength="30">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Tiempo traslado a la IE sede de RER<span class="required">*</span></label>
                                        <input id="tiempo1" name="tiempo1" class="form-control" type="text"
                                            maxlength="20">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Tiempo traslado a la IE sede de RER a la UGEL<span
                                                class="required">*</span></label>
                                        <input id="tiempo2" name="tiempo2" class="form-control" type="text"
                                            maxlength="20">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bootstrap modal -->

    <!-- Bootstrap modal -->
    <div id="modal_ver" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="formver" class="form-horizontal" autocomplete="off">
                        @csrf
                        <div class="form-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Red Educativa <span class="required">*</span></label>
                                        <input type="text" id="vrer" name="vrer" class="form-control"
                                            placeholder="Buscar Red Educativa" readonly>
                                        <span class="help-block"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Institución Educativa <span class="required">*</span></label>
                                        <input type="text" id="viiee" name="viiee" class="form-control"
                                            placeholder="Buscar Institución Educativa" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Total Estudiantes<span class="required">*</span></label>
                                        <input id="vestudiantes" name="vestudiantes" class="form-control" type="number"
                                            readonly>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Total Docentes<span class="required">*</span></label>
                                        <input id="vdocentes" name="vdocentes" class="form-control" type="number"
                                            readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Total Personal Administrativos<span class="required">*</span></label>
                                        <input id="vadministrativos" name="vadministrativos" class="form-control"
                                            type="number" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Tipo Transporte<span class="required">*</span></label>
                                        <input id="vtransporte" name="vtransporte" class="form-control" type="text"
                                            maxlength="30" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Tiempo traslado a la IE sede de RER<span class="required">*</span></label>
                                        <input id="vtiempo1" name="vtiempo1" class="form-control" type="text"
                                            maxlength="20" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Tiempo traslado a la IE sede de RER a la UGEL<span
                                                class="required">*</span></label>
                                        <input id="vtiempo2" name="vtiempo2" class="form-control" type="text"
                                            maxlength="20" readonly>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bootstrap modal -->
@endsection

@section('js')
    <script src="{{ asset('/') }}public/assets/jquery-ui/jquery-ui.js"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

    {{-- <script src="{{ asset('/') }}public/assets/jquery-ui/external/jquery/jquery.js"></script> --}}
    <script>
        var save_method = '';
        var table_principal;

        $(document).ready(function() {

            $("#rer").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('mantenimiento.padronrer.completar.rer') }}",
                        data: {
                            term: request.term
                        },
                        dataType: 'JSON',
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    console.log(ui);
                    $("#rer_id").val(ui.item.id)
                },

            })
            $('#iiee').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('mantenimiento.padronrer.completar.iiee') }}",
                        data: {
                            term: request.term
                        },
                        dataType: 'JSON',
                        success: function(data) {
                            response(data);
                        },
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    console.log(ui);
                    $("#iiee_id").val(ui.item.id);
                },
            });



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


            table_principal = $('#tbprincipal').DataTable({
                responsive: true,
                autoWidth: false,
                ordered: true,
                language: table_language,
                ajax: {
                    "headers": {
                        'X-CSRF-TOKEN': $('input[name=_token]').val()
                    },
                    "url": "{{ route('mantenimiento.padronrer.listar.importados') }}",
                    "type": "POST",
                    //"dataType": 'JSON',
                },

            });
        });

        function add() {
            save_method = 'add';
            $('#form')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $('#modal_form').modal('show');
            $('.modal-title').text('Asignar Institución Educativa');
            $('#id').val("");
        };

        function save() {
            $('#btnSave').text('guardando...');
            $('#btnSave').attr('disabled', true);
            var url;
            if (save_method == 'add') {
                url = "{{ url('/') }}/Mantenimiento/PadronRER/ajax_add";
                msgsuccess = "El registro fue creado exitosamente.";
                msgerror = "El registro no se pudo crear verifique las validaciones.";
            } else {
                url = "{{ url('/') }}/Mantenimiento/PadronRER/ajax_update";
                msgsuccess = "El registro fue actualizado exitosamente.";
                msgerror = "El registro no se pudo actualizar. Verifique la operación";
            }
            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data) {
                    console.log(data)
                    if (data.status) {
                        $('#modal_form').modal('hide');
                        reload_table_principal(); //listarDT();
                        toastr.success(msgsuccess, 'Mensaje');
                    } else {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                        }
                    }
                    $('#btnSave').text('Guardar');
                    $('#btnSave').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error(msgerror, 'Mensaje');
                    $('#btnSave').text('Guardar');
                    $('#btnSave').attr('disabled', false);
                }
            });
        };

        function edit(id) {
            save_method = 'update';
            $('#form')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $.ajax({
                url: "{{ url('/') }}/Mantenimiento/PadronRER/ajax_edit/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id"]').val(data.padronRER.id);
                    $('[name="rer_id"]').val(data.padronRER.rer_id);
                    $('[name="rer"]').val(data.padronRER.red);
                    $('[name="iiee_id"]').val(data.padronRER.institucioneducativa_id);
                    $('[name="iiee"]').val(data.padronRER.iiee);
                    $('[name="estudiantes"]').val(data.padronRER.total_estudiantes);
                    $('[name="docentes"]').val(data.padronRER.total_docentes);
                    $('[name="administrativos"]').val(data.padronRER.total_administrativo);
                    $('[name="transporte"]').val(data.padronRER.tipo_transporte);
                    $('[name="tiempo1"]').val(data.padronRER.tiempo_tras_rer);
                    $('[name="tiempo2"]').val(data.padronRER.tiempo_tras_rer_ugel);
                    $('#modal_form').modal('show');
                    $('.modal-title').text('Modificar Asignacion');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        };

        function borrar(id) {
            bootbox.confirm("Seguro desea Eliminar este registro?", function(result) {
                if (result === true) {
                    $.ajax({
                        url: "{{ url('/') }}/Mantenimiento/PadronRER/ajax_delete/" + id,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            $('#modal_form').modal('hide');
                            reload_table_principal(); //listarDT();
                            toastr.success('El registro fue eliminado exitosamente.', 'Mensaje');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error(
                                'No se puede eliminar este registro por seguridad de su base de datos, Contacte al Administrador del Sistema',
                                'Mensaje');
                        }
                    });
                }
            });
        };

        function reload_table_principal() {
            table_principal.ajax.reload(null, false);
        }

        function estado(id, x) {
            bootbox.confirm("Seguro desea " + (x == 1 ? "desactivar" : "activar") + " este registro?", function(result) {
                if (result === true) {
                    $.ajax({
                        url: "{{ url('/') }}/Mantenimiento/RER/ajax_estado/" + id,
                        /* type: "POST", */
                        dataType: "JSON",
                        success: function(data) {
                            console.log(data);
                            reload_table_principal(); //listarDT();
                            if (data.estado)
                                toastr.success('El registro fue Activo exitosamente.', 'Mensaje');
                            else
                                toastr.success('El registro fue Desactivado exitosamente.', 'Mensaje');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error(
                                'No se puede cambiar estado por seguridad de su base de datos, Contacte al Administrador del Sistema.',
                                'Mensaje');
                        }
                    });
                }
            });
        };

        function ver(id) {
            $('#formver')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $.ajax({
                url: "{{ url('/') }}/Mantenimiento/PadronRER/ajax_edit/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="vrer"]').val(data.padronRER.red);
                    $('[name="viiee"]').val(data.padronRER.iiee);
                    $('[name="vestudiantes"]').val(data.padronRER.total_estudiantes);
                    $('[name="vdocentes"]').val(data.padronRER.total_docentes);
                    $('[name="vadministrativos"]').val(data.padronRER.total_administrativo);
                    $('[name="vtransporte"]').val(data.padronRER.tipo_transporte);
                    $('[name="vtiempo1"]').val(data.padronRER.tiempo_tras_rer);
                    $('[name="vtiempo2"]').val(data.padronRER.tiempo_tras_rer_ugel);
                    $('#modal_ver').modal('show');
                    $('.modal-title').text('Modificar Asignacion');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        };
    </script>
@endsection
