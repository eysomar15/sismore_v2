@extends('layouts.main',['activePage'=>'usuarios','titlePage'=>'GESTION DE ENTIDAD'])

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header card-header-primary">
                            <h4 class="card-title">Relacion de Usuarios </h4>                            
                        </div> --}}

                            <div class="card-body">
                                <!-- <input type="hidden" id="tipogobierno" name="tipogobierno" value="3"> -->
                                <div class="row justify-content-between ">
                                    <div class="col-6 ">
                                        <div class="row form-group">
                                            <label class="col-md-4 col-form-label">TIPO DE GOBIERNO</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="tipogobierno" id="tipogobierno"
                                                    onchange="listarDT();">
                                                    {{-- <option value="0">SELECCIONAR</option> --}}
                                                    @foreach ($tipogobierno as $item)
                                                        <option value="{{ $item->id }}" {{$item->id==3?'selected':''}}>{{ $item->tipogobierno }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 ">
                                        <!-- <div class="row form-group">
                                            <label class="col-md-4 col-form-label">GERENCIA</label>
                                            <div class="col-md-8">
                                                <select class="form-control" name="entidadgerencia" id="entidadgerencia"
                                                    onchange="listarDT();">
                                                    <option value="0">SELECCIONAR</option>
                                                </select>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-4 ">
                                        <div class="row justify-content-end">
                                            <button type="button" class="btn btn-primary" onclick="add_entidad()"><i
                                                    class="fa fa-plus"></i> Nuevo</button>
                                        </div>

                                    </div>

                                </div>

                                <div class="table-responsive">
                                    <br>
                                    <table id="dtPrincipal" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="cabecera-dataTable" id="xxx">
                                            <!--th>Nº</th-->
                                            <th>Codigo</th>
                                            <!-- <th>Tipo de Gobierno</th> -->
                                            <th>Unidad Ejecutora</th>
                                            <th>Abreviado</th>
                                            <th>Aciones</th>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> <!-- End row -->
            </div>
        </div> <!-- End row -->

    </div>

    <!-- Bootstrap modal -->
    <div id="modal_form_entidad" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="form_entidad" class="form-horizontal" autocomplete="off">
                        @csrf
                        <input type="hidden" class="form-control" id="entidad_id" name="entidad_id">
                        <div class="form-body">
                        <div class="form-group">
                                <label>Tipo Gobierno <span class="required">*</span></label>
                                <select  id="entidad_tipogobierno" name="entidad_tipogobierno" class="form-control">
                                @foreach ($tipogobierno as $item)
                                    <option value="{{ $item->id }}">{{ $item->tipogobierno }}</option>
                                @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Codigo <span class="required">*</span></label>
                                <input type="text" id="entidad_codigo" name="entidad_codigo" class="form-control">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Unidad Ejecutora <span class="required">*</span></label>
                                <input id="entidad_nombre" name="entidad_nombre" class="form-control" type="text" onkeyup="this.value=this.value.toUpperCase()">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label>Abreviatura <span class="required">*</span></label>
                                <input id="entidad_abreviado" name="entidad_abreviado" class="form-control" type="text" onkeyup="this.value=this.value.toUpperCase()">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnSaveentidad" onclick="saveentidad()" class="btn btn-primary">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->

    
    @endsection

@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>


    {{-- DATA TABLE --}}
    <script>
        var save_method = '';
        $(document).ready(function() {
            var save_method = '';
            var table_principal;
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
            /* $("#entidad").change(function(){
                $("#opcionesx").html('Gerencia');
            }); */
            /* $("#entidadgerencia").change(function(){
                $("#opcionesx").html('Oficina');
                if($(this).val()==0){
                    $("#opcionesx").html('Gerencia');
                }
            }); */
            listarDT();
            //cargar_gerencia('')
        });

        function listarDT() {
            table_principal = $('#dtPrincipal').DataTable({
                "ajax": "{{ url('/') }}/Entidad/listar/" + $('#tipogobierno').val(),
                "columns": [{
                    data: 'codigo',
                },/* {
                    data: 'nombretipogobierno',
                }, */{
                    data: 'unidad_ejecutora',
                }, {
                    data: 'abreviatura',
                }, {
                    data: 'action',
                    orderable: false
                }],
                responsive: true,
                autoWidth: false,
                order: false,
                destroy: true,
                language: {
                    "lengthMenu": "Mostrar " +
                        `<select class="custom-select custom-select-sm form-control form-control-sm">
                        <option value = '10'> 10</option>
                        <option value = '25'> 25</option>
                        <option value = '50'> 50</option>
                        <option value = '100'>100</option>
                        <option value = '-1'>Todos</option>
                        </select>` + " registros por página",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                    "emptyTable": "No hay datos disponibles en la tabla.",
                    "info": "Del _START_ al _END_ de _TOTAL_ registros ",
                    "infoEmpty": "Mostrando 0 registros de un total de 0. registros",
                    "infoFiltered": "(filtrados de un total de _MAX_ )",
                    "infoPostFix": "",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "searchPlaceholder": "Dato para buscar",
                    "zeroRecords": "No se han encontrado coincidencias.",
                    "paginate": {
                        "next": "siguiente",
                        "previous": "anterior"
                    }
                }
            });
        }

        function reload_table_principal() {
            table_principal.ajax.reload(null, false);
        }

        function add_entidad() {
            save_method = 'add';
            $('#form_entidad')[0].reset();
            $('#form_entidad .form-group').removeClass('has-error');
            $('#form_entidad .help-block').empty();     
            $('#entidad_tipogobierno').val( $('#tipogobierno').val());
            $('#modal_form_entidad').modal('show');
            $('#modal_form_entidad .modal-title').text('Crear Nueva Entidad');

        };     
        function edit(id) {
            save_method = 'update';
            $('#form_entidad')[0].reset();
            $('#form_entidad .form-group').removeClass('has-error');
            $('#form_entidad .help-block').empty();     
            $('#entidad_tipogobierno').val( $('#tipogobierno').val());
            $.ajax({
                url: "{{ url('/') }}/Entidad/ajax_edit_entidad/"+id,
                type: "GET",
                data: {"entidad":id},
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $("#entidad_id").val(data.entidad.id);
                    $("#entidad_codigo").val(data.entidad.codigo);
                    $("#entidad_tipogobierno").val(data.entidad.tipogobierno);
                    $("#entidad_nombre").val(data.entidad.unidad_ejecutora);
                    $("#entidad_abreviado").val(data.entidad.abreviatura);
                    
                    $('#modal_form_entidad').modal('show');
                    $('#modal_form_entidad .modal-title').text('Modificar Entidad');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error("El registro no se pudo crear verifique las validaciones.", 'Mensaje');
                }
            });      
        };     
        function saveentidad() {
            $('#btnSaveentidad').text('guardando...');
            $('#btnSaveentidad').attr('disabled', true);
            var url=save_method=="add"?"{{route('entidad.ajax.addentidad')}}":"{{route('entidad.ajax.updateentidad')}}";
            $.ajax({
                url: url,
                type: "POST",
                data: $('#form_entidad').serialize(),
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    if (data.status) {
                        $('#modal_form_entidad').modal('hide');
                        reload_table_principal();
                        toastr.success("El registro fue creado exitosamente.", 'Mensaje');
                    } else {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                        }
                    }
                    $('#btnSaveentidad').text('Guardar');
                    $('#btnSaveentidad').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error("El registro no se pudo crear verifique las validaciones.", 'Mensaje');
                    $('#btnSaveentidad').text('Guardar');
                    $('#btnSaveentidad').attr('disabled', false);
                }
            });
        };

        function borrar(id) {
            bootbox.confirm("Seguro desea Eliminar este registro?", function(result) {
                if (result === true) {
                    $.ajax({
                        url: "{{ url('/') }}/Entidad/ajax_delete/" + id,
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
    
    </script>
@endsection
