<<<<<<< HEAD

{{-- @extends('layouts.main',['titlePage'=>'']) --}}

@extends('layouts.main', [
    'titlePage' => session('sistema_id') == 5 ? 'Principal' : 'Bienvenido al Sistema de Monitoreo Regional',
])

=======
@extends('layouts.main', [
    'titlePage' => session('sistema_id') == 5 ? 'Principal' : 'Bienvenido al Sistema de Monitoreo Regional',
])
>>>>>>> 35fe3f126b6eccca61bdec622b2dce0465518f4e

@section('content')
    @if (session('sistema_id') == 1)
        @include('inicioEducacion')
    @elseif (session('sistema_id') == 2)
        @include('inicioVivienda')
    @elseif (session('sistema_id') == 3)
        @include('inicioSalud')
    @elseif (session('sistema_id') == 4)
        @include('inicioAdministrador')
    @elseif (session('sistema_id') == 5)
        @include('inicioPresupuesto')
    @elseif (session('sistema_id') == 6)
        @include('inicioTrabajo')
    @else
        <h5>.....</h5>
    @endif
@endsection
