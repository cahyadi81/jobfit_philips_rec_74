<!-- Nik Field -->
<div class="col-md-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('nik', 'NIK:') !!}
	    {!! Form::text('nik', null, ['class' => 'form-control']) !!}
	</div>
</div>

<!-- Position Id Field -->
<div class="col-md-12 no-padding">
	<div class="form-group col-sm-6">
	    {!! Form::label('position_id', 'Position:') !!}
	    <select class="form-control select2" name="position_id">
	    	@foreach($position as $pos)
	    		<option value="{!! $pos->position_id !!}">{!! $pos->position_name !!}</option>
	    	@endforeach
	    </select>
	</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('results.index') !!}" class="btn btn-default">Cancel</a>
</div>
