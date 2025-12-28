<!-- Position Id Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('position_id', 'Job Position:') !!}
    <select class="form-control select2" name="position_id" id="position_id" required>
    	<option value="">-SELECT-</option>
    	@foreach($position as $pos)
    		<option value="{!! $pos->id !!}">{!! $pos->position_name !!}</option>
    	@endforeach
    </select>
</div>
</div>

<!-- Category Id Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category Competencies:') !!}
    <select class="form-control select2" name="category_competencies_id" id="category_competencies_id" required>
    	<option value="">-SELECT-</option>
    	@foreach($category_competencies as $cat)
    		<option value="{!! $cat->id !!}">{!! $cat->category_name !!}</option>
    	@endforeach
    </select>
</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('categoryJobs.index') !!}" class="btn btn-default">Cancel</a>
</div>
