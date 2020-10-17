<div class="form-group @if ($errors->has('description')) has-error @endif">
    {{ Form::label('description', 'Descripción:') }}
    {{ Form::text('description', null, array('class="form-control"')) }}
    @if ($errors->has('description')) 
    <div class="small">
        {{ $errors->first('description', ':message') }} 
    </div>
    @endif
    <p></p>
    {{ Form::submit('Guardar', array('class'=>'btn  btn-primary col-xs-6')) }}
     {{ link_to_route('arearesp.index', 'Cancelar', [],array('class'=>'btn  btn-outline-info col-xs-6')) }}
</div>