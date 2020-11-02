<div class="form-group @if ($errors->has('description')) is-invalid @endif">
    {{ Form::label('first_name', 'Nombre:') }}
    {{ Form::text('first_name', null, array('class="form-control"')) }}
    @if ($errors->has('first_name')) 
    <div class="small alert alert-warning">
        {{ $errors->first('first_name', ':message') }} 
    </div>
    @endif
</div>

<div class="form-group @if ($errors->has('last_name')) is-invalid @endif">
    {{ Form::label('last_name', 'Apellido:') }}
    {{ Form::text('last_name', null, array('class="form-control"')) }}
    @if ($errors->has('last_name')) 
    <div class="small alert alert-warning">
        {{ $errors->first('last_name', ':message') }} 
    </div>
    @endif
</div> 

<div class="form-group @if ($errors->has('address')) is-invalid @endif">
    {{ Form::label('address', 'Dirección:') }}
    {{ Form::text('address', null, array('class="form-control"')) }}
    @if ($errors->has('address')) 
    <div class="small alert alert-warning">
        {{ $errors->first('address', ':message') }} 
    </div>
    @endif
</div>

<div class="form-group @if ($errors->has('city_id')) is-invalid @endif">
    {{ Form::label('city_id', 'Ciudad:') }}
    {{ Form::select('city_id', $cities ?? '', Null, array('class="form-control"')) }}
    @if ($errors->has('city_id')) 
    <div class="small">
        {{ $errors->first('city_id', ':message') }} 
    </div>
    @endif
    <p></p>
    {{ Form::submit('Guardar', array('class'=>'btn  btn-primary col-xs-6')) }}
    {{ link_to_route('contacts.index', 'Cancelar', [],array('class'=>'btn  btn-outline-info col-xs-6')) }}
</div>