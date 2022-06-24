@extends('master')

@section('page_title')
  Centros de Análisis
@stop

@section('main')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="container-fluid">
                <div class="col-sm">
                    <h6 class="m-0 font-weight-bold text-secondary">{{ link_to_route('costCenters.index','Area de Responsabilidad: '.$arearesp->description, Null, 'class="text-primary"') }} / Nuevo Centro de Análisis</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                {{ Form::open(array('route'=>'costCenters.store')) }}
                @include('costCenters.form')
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop