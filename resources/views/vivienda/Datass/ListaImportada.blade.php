@extends('layouts.main',['activePage'=>'FuenteImportacion','titlePage'=>'IMPORTACION REALIZADA CON EXITO - DATASS'])

@section('css')
     <!-- Table datatable css -->
     <link href="{{ asset('/') }}public/assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection

@section('content') 

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Relacion</h3>
                {{-- <p class="card-category">IMPORTADAS DEL PADRON WEB</p> --}}
            </div>
            <div class="card-body">
                @include('vivienda.Datass.ListaParcial')             
            </div>
            <!-- card-body -->
        </div> 
        <!-- card -->
    </div>
    <!-- col -->
  </div>
   
@endsection 

