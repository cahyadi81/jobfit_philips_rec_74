<!-- Quatril Field -->
<div class="col-md-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('quatril', 'Quatril:') !!}
	    {!! Form::text('quatril', null, ['class' => 'form-control', 'maxlength' => '50']) !!}
	</div>
</div>

<!-- Score Field -->
<div class="col-md-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('score', 'Score:') !!}
	    {!! Form::text('score', null, ['class' => 'form-control', 'maxlength' => '7']) !!}
	</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('quadranScores.index') !!}" class="btn btn-default">Cancel</a>
</div>
