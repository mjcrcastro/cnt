@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}

@section('main')

<h1> Editar Area de Responsabilidad </h1>

{{ Form::model($arearesp, array('method'=>'PATCH', 'route'=> array('arearesp.update', $arearesp->id)))  }}
    @include('arearesp.form')
{{ Form::close() }}

@stop

