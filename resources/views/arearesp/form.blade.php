<div class="form-group @if ($errors->has('description')) has-error @endif">
    {{ Form::label('description', 'Descripción:') }}
    {{ Form::text('description', null, array('class="form-control"')) }}
    @if ($errors->has('description')) 
    <div class="small">
        {{ $errors->first('description', ':message') }} 
    </div>
    @endif
    <p></p>
    {{ Form::submit('Enviar', array('class'=>'btn  btn-primary col-xs-6')) }}
</div>