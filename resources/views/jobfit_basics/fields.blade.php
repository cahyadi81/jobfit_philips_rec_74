<!-- Position Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('position_id', 'Job Position:') !!}
    <select class="form-control select2 position" name="position_id" id="position_id" required>
        <option value="">-SELECT-</option>
        @foreach($position as $pos)
            <option value="{!! $pos->id !!}">{!! $pos->position_name !!}</option>
        @endforeach
    </select>
</div>

<!-- Category Competencies Id Field -->
<div class="col-sm-12 no-padding">
    <div class="form-group col-sm-6">
        {!! Form::label('category_competencies_id', 'Category Competency:') !!}
        <select class="form-control select2 category-competencies" id="category_competencies_id" name="category_competencies_id">
            <option value="">-SELECT-</option>
            @foreach($categoryCompetency as $cat)
                <option value="{!! $cat->id !!}">{!! $cat->category_name !!}</option>
            @endforeach
        </select>
    </div>
</div>

<!-- Jobfit Id Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('jobfit_id', 'Jobfit ID:') !!}
    {!! Form::text('jobfit_id', null, ['class' => 'form-control', 'maxlength' => '1']) !!}
</div>
</div>

<!-- Values Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('values', 'Values:') !!}
    {!! Form::text('values', null, ['class' => 'form-control', 'maxlength' => '3']) !!}
</div>
</div>

<!-- Percent Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('percent', 'Percent:') !!}
    {!! Form::text('percent', null, ['class' => 'form-control', 'maxlength' => '3']) !!}
</div>
</div>

<!-- Pattern Field -->
<div class="col-sm-12 no-padding">
<div class="form-group col-sm-6">
    {!! Form::label('pattern', 'Pattern:') !!}
    {!! Form::text('pattern', null, ['class' => 'form-control', 'maxlength' => '2']) !!}
</div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('jobfitBasics.index') !!}" class="btn btn-default">Cancel</a>
</div>