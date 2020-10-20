@extends('master')

@section('meta')
<!-- Usado para filtrar la lista de centros -->
<meta name="area_resp_id" content="{{ $arearesp->id }}">
@stop

@section('main')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="container-fluid">
                <div class="col-sm">
                    <h6 class="m-0 font-weight-bold text-secondary">{{ link_to_route('arearesp.index',$arearesp->description, null, 'class="text-primary"') }} / Nuevo Centro</h6>
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