@extends('master')

{{-- The next section only serves to 
    let know master blade that the shops 
    menu option needs to be highligted--}}
    
@section('main')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="container-fluid">
                <div class="col-sm">
                    <h6 class="m-0 font-weight-bold text-secondary">{{ link_to_route('arearesp.index',$arearesp->description, null, 'class="text-primary"') }} / Editar Centro {{ $costCenter->description }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                {{ Form::model($costCenter, array('method'=>'PATCH', 'route'=> array('costCenters.update', $costCenter->id)))  }}
                @include('costCenters.form')
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop

