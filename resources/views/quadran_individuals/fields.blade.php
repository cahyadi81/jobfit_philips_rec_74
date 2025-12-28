<!-- Quatril Field -->
<div class="col-md-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('quatril', 'Quatril:') !!}
	    {!! Form::text('quatril', null, ['class' => 'form-control', 'maxlength' => '50']) !!}
	</div>
</div>

<!-- Min Field -->
<div class="col-md-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('min', 'Min:') !!}
	    {!! Form::text('min', null, ['class' => 'form-control', 'maxlength' => '3']) !!}
	</div>
</div>

<!-- Max Field -->
<div class="col-md-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('max', 'Max:') !!}
	    {!! Form::text('max', null, ['class' => 'form-control', 'maxlength' => '3']) !!}
	</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('quadranIndividuals.index') !!}" class="btn btn-default">Cancel</a>
</div>
