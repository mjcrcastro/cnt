@extends('master')

@section('meta')
<!-- Usado para filtrar la lista de centros -->
<meta name="country_id" content="{{ $country->id }}">
@stop

@section('page_title')
  Ciudades de {{ $country->description }}
@stop

@section('main')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="container-fluid">
                <div class="col-sm">
                    <h6 class="m-0 font-weight-bold text-secondary">{{ link_to_route('cities.index',$country->description, ['country_id'=>$country->id], 'class="text-primary"') }} / Nueva Ciudad</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                {{ Form::open(array('route'=>'cities.store')) }}
                @include('city.form')
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop