<div class="form-group @if ($errors->has('description')) has-error @endif">
    {{ Form::label('rate_date', 'Fecha:') }}
    {{ Form::text('rate_date', null, array('class="form-control"')) }}
    @if ($errors->has('rate_date')) 
    <div class="small alert alert-warning">
        {{ $errors->first('rate_date', ':message') }} 
    </div>
    @endif
    
    {{ Form::label('rate', 'Tasa:') }}
    {{ Form::text('rate', null, array('class="form-control"')) }}
    @if ($errors->has('description')) 
    <div class="small alert alert-warning">
        {{ $errors->first('rate', ':message') }} 
    </div>
    @endif
    
    <p></p>
    {{ Form::submit('Guardar', array('class'=>'btn  btn-primary col-xs-6')) }}
     {{ link_to_route('exchangerates.index', 'Cancelar', [],array('class'=>'btn  btn-outline-info col-xs-6')) }}
</div>