@extends('layouts.main',['titlePage'=>'Bienvenido al Sistema de Monitoreo Regional'])

@section('content')


    @if (session('sistema_id') == 1)
        @include('inicioEducacion')
    @elseif (session('sistema_id')==2)
        @include('inicioVivienda')
    @elseif (session('sistema_id')==4)
        @include('inicioAdministrador')
        @elseif (session('sistema_id')==5)
        @include('inicioPresupuesto')
    @elseif (session('sistema_id')==6)
        @include('inicioTrabajo')    
    @else
        <h5>.....</h5>
    @endif



@endsection
