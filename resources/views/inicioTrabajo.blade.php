<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="alert alert-info">                                                          
                <div id="Grafico_oferta_demanda_colocados">       
                    {{-- se carga con el scrip lineas abajo --}}
                </div>                     
        </div>                 
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="alert alert-info">                                                          
                <div id="Grafico_Promedio_Remuneracion">       
                    {{-- se carga con el scrip lineas abajo --}}
                </div>                     
        </div>                 
    </div>

    <div class="col-md-6 col-xl-6">
        <div class="alert alert-info">                                                          
                <div id="Grafico_Promedio_Trabajadores">       
                    {{-- se carga con el scrip lineas abajo --}}
                </div>                     
        </div>                 
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="alert alert-info">                                                          
                <div id="Grafico_Prestadores_Servicio4ta_Publico">       
                    {{-- se carga con el scrip lineas abajo --}}
                </div>                     
        </div>                 
    </div>

    <div class="col-md-6 col-xl-6">
        <div class="alert alert-info">                                                          
                <div id="Grafico_Prestadores_Servicio4ta_Privado">       
                    {{-- se carga con el scrip lineas abajo --}}
                </div>                     
        </div>                 
    </div>

</div>
{{-- llamado de forma directa
<div class="col-md-6">
   <div id="im1">       
       @include('graficos.Lineal')
   </div>
</div> --}}


@section('js')


    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts/highcharts-more.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/exporting.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/export-data.js"></script>
    <script src="{{ asset('/') }}assets/libs/highcharts-modules/accessibility.js"></script>

    <script type="text/javascript"> 
        
        $(document).ready(function() {
            Grafico_oferta_demanda_colocados();
            // Grafico_Promedio_Remuneracion();
            // Grafico_Promedio_Trabajadores();
            // Grafico_Prestadores_Servicio4ta_Publico();
            // Grafico_Prestadores_Servicio4ta_Privado();
        });

        function Grafico_oferta_demanda_colocados() {
            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/ProEmpleo/Grafico_oferta_demanda_colocados/"+0,
                type: 'post',
            }).done(function (data) {               
                $('#Grafico_oferta_demanda_colocados').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function Grafico_Promedio_Remuneracion() {
            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/AnuarioEstadistico/Grafico_Promedio_Remuneracion/"+0,
                type: 'post',
            }).done(function (data) {               
                $('#Grafico_Promedio_Remuneracion').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function Grafico_Promedio_Trabajadores() {
            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/AnuarioEstadistico/Grafico_Promedio_Trabajadores/"+0,
                type: 'post',
            }).done(function (data) {               
                $('#Grafico_Promedio_Trabajadores').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function Grafico_Prestadores_Servicio4ta_Publico() {
            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/AnuarioEstadistico/Grafico_Prestadores_Servicio4ta_Publico/"+0,
                type: 'post',
            }).done(function (data) {               
                $('#Grafico_Prestadores_Servicio4ta_Publico').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

        function Grafico_Prestadores_Servicio4ta_Privado() {
            
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/AnuarioEstadistico/Grafico_Prestadores_Servicio4ta_Privado/"+0,
                type: 'post',
            }).done(function (data) {               
                $('#Grafico_Prestadores_Servicio4ta_Privado').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }
       
    </script>
    
@endsection


